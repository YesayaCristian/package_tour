<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('order.user')->latest()->get();
        return view('admin.payments.index', compact('payments'));
    }

    public function updateStatus(Request $request, $id)
    {
        $payment = Payment::findOrFail($id);
        $data = $request->validate([
            'status' => 'required|in:pending,verified,failed'
        ]);

        $payment->update(['status' => $data['status']]);

        return redirect()->back()->with('success', 'Payment status updated!');
    }
}
