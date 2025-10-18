<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\TourPackage;
use App\Models\Order;
use App\Models\Payment;

class DashboardController extends Controller
{
    public function index()
    {
        $totalCustomers = User::where('role', 'customer')->count();
        $totalPackages = TourPackage::count();
        $totalOrders = Order::count();
        $totalPayments = Payment::count();

        return view('admin.dashboard', compact(
            'totalCustomers', 'totalPackages', 'totalOrders', 'totalPayments'
        ));
    }
}
