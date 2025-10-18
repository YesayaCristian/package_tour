<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\TourPackage;

class CartController extends Controller
{
    // Menampilkan isi cart user
    public function index()
    {
        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
        $items = $cart->items()->with('tourPackage')->get();
        return view('customer.cart', compact('items'));
    }

    // Tambah ke cart
    public function addToCart(Request $request)
    {
        $request->validate([
            'package_id' => 'required|exists:tour_packages,id',
            'quantity' => 'nullable|integer|min:1',
        ]);

        $quantity = $request->quantity ?? 1;
        $userId = Auth::id();

        // cari cart user
        $cart = Cart::firstOrCreate(['user_id' => $userId]);
        $package = TourPackage::findOrFail($request->package_id);

        // cek apakah paket sudah ada di cart
        $existingItem = CartItem::where('cart_id', $cart->id)
            ->where('tour_package_id', $package->id)
            ->first();

        if ($existingItem) {
            // update quantity
            $existingItem->quantity += $quantity;
            $existingItem->subtotal = $existingItem->quantity * $package->price;
            $existingItem->save();
        } else {
            // tambahkan baru
            CartItem::create([
                'cart_id' => $cart->id,
                'tour_package_id' => $package->id,
                'quantity' => $quantity,
                'subtotal' => $package->price * $quantity,
            ]);
        }

        return redirect()->route('cart')->with('success', 'Package added to cart!');
    }

    // Hapus item dari cart
    public function removeItem($id)
    {
        $item = CartItem::findOrFail($id);
        if ($item->cart->user_id !== Auth::id()) {
            abort(403);
        }
        $item->delete();

        return redirect()->route('cart')->with('success', 'Item removed from cart.');
    }

    // Kosongkan semua isi cart
    public function clearCart()
    {
        $cart = Cart::where('user_id', Auth::id())->first();
        if ($cart) {
            $cart->items()->delete();
        }

        return redirect()->route('cart')->with('success', 'Cart cleared.');
    }
}
