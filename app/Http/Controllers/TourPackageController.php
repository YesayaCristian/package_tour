<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TourPackage;

class TourPackageController extends Controller
{
    public function index()
    {
        $packages = TourPackage::all(); // ambil semua paket
        return view('customer.packages', compact('packages'));
    }

    public function show($id)
    {
        $package = TourPackage::findOrFail($id); // ambil paket sesuai id
        return view('customer.package_detail', compact('package'));
    }
}
