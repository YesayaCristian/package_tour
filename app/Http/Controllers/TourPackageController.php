<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TourPackage;

class TourPackageController extends Controller
{
    // Menampilkan semua paket dengan kursi tersisa > 0
    public function index()
    {
        // hanya ambil paket dengan available_seats > 0
        $packages = TourPackage::where('available_seats', '>', 0)->get();
        return view('customer.packages', compact('packages'));
    }

    // Menampilkan detail paket tertentu
    public function show($id)
    {
        // hanya tampilkan jika available_seats masih > 0
        $package = TourPackage::where('id', $id)
                              ->where('available_seats', '>', 0)
                              ->first();

        if (!$package) {
            return redirect()->route('packages')
                             ->with('error', 'Package not available or sold out.');
        }

        return view('customer.package_detail', compact('package'));
    }
}
