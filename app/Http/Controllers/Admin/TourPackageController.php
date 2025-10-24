<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TourPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class TourPackageController extends Controller
{
    public function index(Request $request)
    {
        $query = TourPackage::query();

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('location', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter by location
        if ($request->has('location') && $request->location != '') {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        $packages = $query->latest()->paginate(10);

        return view('admin.packages.index', compact('packages'));
    }

    public function create()
    {
        return view('admin.packages.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:150',
            'description' => 'required|string',
            'location' => 'required|string|max:100',
            'duration' => 'required|string|max:50',
            'price' => 'required|numeric|min:0',
            'available_seats' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|in:available,full,inactive',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('tour-packages', 'public');
        }

        TourPackage::create($validated);

        return redirect()->route('admin.packages.index')->with('success', 'Paket wisata berhasil ditambahkan!');
    }

    public function edit(TourPackage $package)
    {
        return view('admin.packages.edit', compact('package'));
    }

    public function update(Request $request, TourPackage $package)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:150',
            'description' => 'required|string',
            'location' => 'required|string|max:100',
            'duration' => 'required|string|max:50',
            'price' => 'required|numeric|min:0',
            'available_seats' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|in:available,full,inactive',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($package->image) {
                Storage::disk('public')->delete($package->image);
            }
            $validated['image'] = $request->file('image')->store('tour-packages', 'public');
        }

        $package->update($validated);

        return redirect()->route('admin.packages.index')->with('success', 'Paket wisata berhasil diupdate!');
    }

    public function destroy(TourPackage $package)
    {
        if ($package->image) {
            Storage::disk('public')->delete($package->image);
        }

        $package->delete();

        return redirect()->route('admin.packages.index')->with('success', 'Paket wisata berhasil dihapus!');
    }

    /**
     * Export packages to PDF
     */
    public function exportPdf(Request $request)
    {
        try {
            $filters = [
                'search' => $request->get('search'),
                'status' => $request->get('status'),
                'location' => $request->get('location'),
            ];

            $query = TourPackage::query();

            // Apply filters sama seperti di index
            if (!empty($filters['search'])) {
                $search = $filters['search'];
                $query->where(function($q) use ($search) {
                    $q->where('title', 'like', '%' . $search . '%')
                      ->orWhere('location', 'like', '%' . $search . '%')
                      ->orWhere('description', 'like', '%' . $search . '%');
                });
            }

            if (!empty($filters['status'])) {
                $query->where('status', $filters['status']);
            }

            if (!empty($filters['location'])) {
                $query->where('location', 'like', '%' . $filters['location'] . '%');
            }

            $packages = $query->orderBy('created_at', 'desc')->get();
            $totalPackages = $packages->count();
            $totalRevenue = $packages->sum('price');

            $timestamp = date('Y-m-d_H-i-s');
            $filename = "laporan-paket-wisata_{$timestamp}.pdf";

            $pdf = Pdf::loadView('exports.packages-pdf', [
                'packages' => $packages,
                'totalPackages' => $totalPackages,
                'totalRevenue' => $totalRevenue,
                'filters' => $filters
            ]);

            // Set paper orientation and size
            $pdf->setPaper('A4', 'landscape');
            
            // Set options for better rendering
            $pdf->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'defaultFont' => 'Arial',
                'chroot' => public_path()
            ]);

            return $pdf->download($filename);

        } catch (\Exception $e) {
            return redirect()->route('admin.packages.index')
                ->with('error', 'Terjadi kesalahan saat export PDF: ' . $e->getMessage());
        }
    }
}