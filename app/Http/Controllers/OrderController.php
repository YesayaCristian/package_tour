<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\TourPackage;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function checkout(Request $request)
    {
        $cart = Auth::user()->cart;
        
        if ($cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja kosong!');
        }

        DB::beginTransaction();
        try {
            // Buat order
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_code' => (new Order())->generateOrderCode(),
                'total_amount' => $cart->total,
                'payment_method' => $request->payment_method,
                'status' => 'pending',
            ]);

            // Pindahkan items dari cart ke order
            foreach ($cart->items as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'tour_package_id' => $cartItem->tour_package_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->tourPackage->price,
                    'subtotal' => $cartItem->total_price,
                ]);

                // Kurangi available seats
                $package = TourPackage::find($cartItem->tour_package_id);
                $package->decrement('available_seats', $cartItem->quantity);
                
                if ($package->available_seats <= 0) {
                    $package->update(['status' => 'full']);
                }
            }

            // Kosongkan cart
            $cart->items()->delete();

            DB::commit();

            return redirect()->route('orders.show', $order->id)->with('success', 'Pesanan berhasil dibuat!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('cart.index')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function index()
    {
        $orders = Auth::user()->orders()->with('items.tourPackage')->latest()->get();
        return view('orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with('items.tourPackage', 'payment')->findOrFail($id);
        
        if ($order->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403);
        }

        return view('orders.show', compact('order'));
    }

    public function uploadPayment(Request $request, $orderId)
    {
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'payment_date' => 'required|date',
            'amount' => 'required|numeric',
        ]);

        $order = Order::findOrFail($orderId);

        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $imagePath = $request->file('payment_proof')->store('payment-proofs', 'public');

        Payment::create([
            'order_id' => $order->id,
            'payment_date' => $request->payment_date,
            'amount' => $request->amount,
            'payment_proof' => $imagePath,
            'status' => 'waiting',
        ]);

        $order->update(['status' => 'paid']);

        return redirect()->route('orders.show', $order->id)->with('success', 'Bukti pembayaran berhasil diupload!');
    }
}