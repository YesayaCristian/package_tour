<?php

namespace App\Http\Controllers;

use App\Models\TourPackage;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $packages = TourPackage::where('status', 'available')
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        return view('home', compact('packages'));
    }

    public function packages(Request $request)
    {
        $query = TourPackage::where('status', 'available');

        if ($request->has('location') && $request->location != '') {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        if ($request->has('min_price') && $request->min_price != '') {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->has('max_price') && $request->max_price != '') {
            $query->where('price', '<=', $request->max_price);
        }

        $packages = $query->orderBy('created_at', 'desc')->paginate(9);

        return view('packages.index', compact('packages'));
    }

    public function showPackage($id)
    {
        $package = TourPackage::with('reviews.user')->findOrFail($id);
        $relatedPackages = TourPackage::where('location', $package->location)
            ->where('id', '!=', $id)
            ->where('status', 'available')
            ->take(4)
            ->get();

        return view('packages.show', compact('package', 'relatedPackages'));
    }
}