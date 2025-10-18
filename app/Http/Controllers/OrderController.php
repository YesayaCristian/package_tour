<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\TourPackage;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    // Proses checkout
    public function checkout()
    {
        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Your cart is empty!');
        }

        $total = $cart->items->sum('subtotal');

        // generate kode unik
        $orderCode = 'ORD-' . now()->format('Ymd') . '-' . str_pad(rand(1,999), 3, '0', STR_PAD_LEFT);

        // buat order
        $order = Order::create([
            'user_id' => $user->id,
            'order_code' => $orderCode,
            'total_amount' => $total,
            'status' => 'pending',
            'payment_status' => 'unpaid',
        ]);

        // pindahkan isi cart ke order_items
        foreach ($cart->items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'tour_package_id' => $item->tour_package_id,
                'quantity' => $item->quantity,
                'price' => $item->tourPackage->price,
                'subtotal' => $item->subtotal,
            ]);

            // kurangi kursi tersedia
            $item->tourPackage->decrement('available_seats', $item->quantity);
        }

        // kosongkan cart
        $cart->items()->delete();

        return redirect()->route('payments.create', ['order_id' => $order->id])
                         ->with('success', 'Checkout successful! Please complete your payment.');
    }

    // Melihat semua pesanan customer
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())->with('items.tourPackage')->latest()->get();
        return view('customer.orders', compact('orders'));
    }
}
