<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    // Tampilkan form pembayaran
    public function create(Request $request)
    {
        $order = Order::where('id', $request->order_id)
                      ->where('user_id', Auth::id())
                      ->firstOrFail();

        return view('customer.payments', compact('order'));
    }

    // Simpan pembayaran
    public function store(Request $request)
    {
        $data = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'payment_method' => 'required|in:transfer,credit_card,ewallet',
            'payment_proof' => 'nullable|image|max:2048',
        ]);

        $order = Order::where('id', $data['order_id'])
                    ->where('user_id', Auth::id())
                    ->firstOrFail();

        $fileName = null;
        if ($request->hasFile('payment_proof')) {
            $fileName = $request->file('payment_proof')->store('payment_proofs', 'public');
        }

        // Simpan data pembayaran
        $payment = Payment::create([
            'order_id' => $order->id,
            'payment_method' => $data['payment_method'],
            'payment_date' => now(),
            'amount' => $order->total_amount,
            'payment_proof' => $fileName,
            'status' => 'verified', // langsung dianggap berhasil
        ]);

        // Ubah status order menjadi paid dan completed
        $order->update([
            'payment_status' => 'paid',
            'status' => 'completed',
        ]);

        return redirect()->route('orders')
                        ->with('success', 'Payment successful! Your order is now marked as paid.');
    }
}
