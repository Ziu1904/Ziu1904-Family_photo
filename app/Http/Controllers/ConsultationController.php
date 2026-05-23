<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Consultation;
use Illuminate\Support\Facades\Log;

class ConsultationController extends Controller
{
    /**
     * Display booking/consultation page
     */
    public function index()
    {
        $packages = \App\Models\Package::where('is_active', true)->get();
        return view('booking', compact('packages'));
    }

    /**
     * Store consultation request
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'class_name' => 'required|string|max:255',
            'phone' => 'required|string|max:30',
            'package_id' => 'nullable|exists:packages,id',
            'area' => 'nullable|string|max:255',
            'student_count' => 'required|integer|min:1',
            'time' => 'required|string|max:255',
            'note' => 'nullable|string',
        ]);

        try {
            // Create consultation record
            $consultation = Consultation::create([
                'user_id' => auth()->id(),
                'package_id' => $validated['package_id'] ?? null,
                'class_name' => $validated['class_name'],
                'phone' => $validated['phone'],
                'area' => $validated['area'] ?? null,
                'student_count' => $validated['student_count'],
                'time' => $validated['time'],
                'note' => $validated['note'] ?? null,
                'status' => 'pending',
            ]);

            Log::info('Consultation created: ' . $consultation->id);

            return redirect()->back()
                ->with('success', 'Cảm ơn bạn! Chúng tôi sẽ liên hệ với bạn sớm.');
        } catch (\Exception $e) {
            Log::error('Consultation creation error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Có lỗi khi gửi yêu cầu. Vui lòng thử lại sau.')
                ->withInput();
        }
    }

    public function confirm(Consultation $consultation)
    {
        if ($consultation->user_id !== auth()->id()) {
            abort(403);
        }

        if (! in_array($consultation->status, ['pending', 'confirmed'], true)) {
            return redirect()->back()->with('error', 'Không thể xác nhận booking ở trạng thái hiện tại.');
        }

        $consultation->update(['status' => 'confirmed']);

        return redirect()->back()->with('success', 'Bạn đã xác nhận booking chính thức.');
    }

    public function cancel(Consultation $consultation)
    {
        if ($consultation->user_id !== auth()->id()) {
            abort(403);
        }

        if (in_array($consultation->status, ['completed', 'cancelled', 'confirmed'], true)) {
            return redirect()->back()->with('error', 'Không thể hủy yêu cầu này.');
        }

        $consultation->update(['status' => 'cancelled']);

        return redirect()->back()->with('success', 'Yêu cầu tư vấn đã được hủy.');
    }
}
