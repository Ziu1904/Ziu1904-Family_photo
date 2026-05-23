<?php

namespace App\Http\Controllers\Admin;

use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::latest()->paginate(15);
        return view('admin.packages.index', compact('packages'));
    }

    public function show(Package $package)
    {
        
        if (Schema::hasTable('bookings')) {
            $package->load('bookings');
        }
        return view('admin.packages.show', compact('package'));
    }

    public function create()
    {
        return view('admin.packages.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:packages,name',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'photos_count' => 'nullable|integer|min:0',
            'videos_count' => 'nullable|integer|min:0',
            'concepts_count' => 'nullable|integer|min:0',
            'features' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        // Process features
        if (!empty($validated['features'])) {
            $validated['features'] = array_filter(array_map('trim', explode("\n", $validated['features'])));
        } else {
            $validated['features'] = null;
        }

        try {
            Package::create($validated);
            return redirect()->route('admin.packages.index')->with('success', 'Gói dịch vụ đã được tạo thành công!');
        } catch (\Exception $e) {
            Log::error('Package store error: ' . $e->getMessage(), ['exception' => $e]);
            return back()->withInput()->withErrors(['error' => 'Có lỗi xảy ra khi tạo gói dịch vụ. Vui lòng thử lại.']);
        }
    }

    public function edit(Package $package)
    {
        return view('admin.packages.edit', compact('package'));
    }

    public function update(Request $request, Package $package)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:packages,name,' . $package->id,
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'photos_count' => 'nullable|integer|min:0',
            'videos_count' => 'nullable|integer|min:0',
            'concepts_count' => 'nullable|integer|min:0',
            'features' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        // Process features
        if (!empty($validated['features'])) {
            $validated['features'] = array_filter(array_map('trim', explode("\n", $validated['features'])));
        } else {
            $validated['features'] = null;
        }

        try {
            $package->update($validated);
            return redirect()->route('admin.packages.index')->with('success', 'Gói dịch vụ đã được cập nhật thành công!');
        } catch (\Exception $e) {
            Log::error('Package update error: ' . $e->getMessage(), ['exception' => $e, 'package_id' => $package->id]);
            return back()->withInput()->withErrors(['error' => 'Có lỗi xảy ra khi cập nhật gói dịch vụ. Vui lòng thử lại.']);
        }
    }

    public function destroy(Package $package)
    {
        try {
            $package->delete();
            return redirect()->route('admin.packages.index')->with('success', 'Gói dịch vụ đã được xóa thành công!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Có lỗi xảy ra khi xóa gói dịch vụ. Vui lòng thử lại.']);
        }
    }
}
