<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('order.user')
            ->latest()
            ->paginate(10);
            
        return view('admin.payments.index', compact('payments'));
    }

    public function updateStatus(Request $request, Payment $payment)
    {
        $request->validate([
            'status' => 'required|in:waiting,confirmed,rejected'
        ]);

        $payment->update(['status' => $request->status]);

        // Update order status if payment is confirmed
        if ($request->status === 'confirmed') {
            $payment->order->update(['status' => 'paid']);
        }

        return redirect()->back()->with('success', 'Status pembayaran berhasil diupdate!');
    }
}