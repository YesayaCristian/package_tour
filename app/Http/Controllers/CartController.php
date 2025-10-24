<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\TourPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cart = Auth::user()->cart;
        return view('cart.index', compact('cart'));
    }

    public function add(Request $request, $packageId)
    {
        $package = TourPackage::findOrFail($packageId);
        
        if (!$package->isAvailable()) {
            return redirect()->back()->with('error', 'Paket tidak tersedia.');
        }

        $cart = Auth::user()->cart;
        $quantity = $request->quantity ?: 1;

        // Cek apakah item sudah ada di cart
        $existingItem = $cart->items()->where('tour_package_id', $packageId)->first();

        if ($existingItem) {
            $existingItem->update([
                'quantity' => $existingItem->quantity + $quantity,
                'total_price' => ($existingItem->quantity + $quantity) * $package->price
            ]);
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'tour_package_id' => $packageId,
                'quantity' => $quantity,
                'total_price' => $quantity * $package->price
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Paket berhasil ditambahkan ke keranjang!');
    }

    public function update(Request $request, $itemId)
    {
        $item = CartItem::findOrFail($itemId);
        
        if ($item->cart->user_id !== Auth::id()) {
            abort(403);
        }

        $quantity = $request->quantity;
        $item->update([
            'quantity' => $quantity,
            'total_price' => $quantity * $item->tourPackage->price
        ]);

        return redirect()->route('cart.index')->with('success', 'Keranjang berhasil diupdate!');
    }

    public function remove($itemId)
    {
        $item = CartItem::findOrFail($itemId);
        
        if ($item->cart->user_id !== Auth::id()) {
            abort(403);
        }

        $item->delete();

        return redirect()->route('cart.index')->with('success', 'Item berhasil dihapus dari keranjang!');
    }
}