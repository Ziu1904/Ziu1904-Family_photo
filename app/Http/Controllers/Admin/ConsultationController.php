<?php

namespace App\Http\Controllers\Admin;

use App\Models\Consultation;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ConsultationController extends Controller
{
    public function index()
    {
        $consultations = Consultation::latest()
            ->paginate(15);

        return view('admin.consultations.index', compact('consultations'));
    }

    public function show(Consultation $consultation)
    {
        return view('admin.consultations.show', compact('consultation'));
    }

    public function updateStatus(Request $request, Consultation $consultation)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled',
            'manager_response' => 'nullable|string',
        ]);

        $consultation->update($validated);

        return redirect()->back()
            ->with('success', 'Cập nhật trạng thái thành công!');
    }

    public function destroy(Consultation $consultation)
    {
        $consultation->delete();

        return redirect()->route('admin.consultations.index')
            ->with('success', 'Xóa tư vấn thành công!');
    }
}
