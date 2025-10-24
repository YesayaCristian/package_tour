<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Order;
use App\Models\TourPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Show the form for creating a new review
     */
    public function create($orderId)
    {
        // Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $order = Order::with(['items.tourPackage', 'user'])
                    ->where('user_id', Auth::id())
                    ->findOrFail($orderId);

        // Cek apakah order sudah completed
        if ($order->status !== 'completed') {
            return redirect()->route('orders.show', $orderId)
                ->with('error', 'Anda hanya dapat memberikan review untuk pesanan yang sudah selesai.');
        }

        // Cek apakah sudah ada review untuk order ini
        if (Review::where('order_id', $orderId)->where('user_id', Auth::id())->exists()) {
            return redirect()->route('orders.show', $orderId)
                ->with('error', 'Anda sudah memberikan review untuk pesanan ini.');
        }

        return view('reviews.create', compact('order'));
    }

    /**
     * Store a newly created review
     */
    public function store(Request $request, $orderId)
    {
        // Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $order = Order::with('items.tourPackage')
                    ->where('user_id', Auth::id())
                    ->where('status', 'completed')
                    ->findOrFail($orderId);

        // Validasi
        $request->validate([
            'tour_package_id' => 'required|exists:tour_packages,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10|max:1000'
        ]);

        // Cek apakah tour package termasuk dalam order
        $packageInOrder = $order->items->contains('tour_package_id', $request->tour_package_id);
        if (!$packageInOrder) {
            return redirect()->back()->with('error', 'Paket wisata tidak valid untuk pesanan ini.');
        }

        // Cek apakah sudah ada review untuk paket ini di order ini
        $existingReview = Review::where('user_id', Auth::id())
                              ->where('tour_package_id', $request->tour_package_id)
                              ->where('order_id', $orderId)
                              ->exists();

        if ($existingReview) {
            return redirect()->route('orders.show', $orderId)
                ->with('error', 'Anda sudah memberikan review untuk paket ini dalam pesanan ini.');
        }

        try {
            // Create review
            Review::create([
                'user_id' => Auth::id(),
                'tour_package_id' => $request->tour_package_id,
                'order_id' => $orderId,
                'rating' => $request->rating,
                'comment' => $request->comment,
                'status' => 'pending' // Review perlu approval admin
            ]);

            return redirect()->route('orders.show', $orderId)
                ->with('success', 'Review berhasil dikirim! Review Anda akan ditampilkan setelah disetujui oleh admin.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display user's reviews
     */
    public function index()
    {
        $reviews = Review::with('tourPackage', 'order')
                        ->where('user_id', Auth::id())
                        ->orderBy('created_at', 'desc')
                        ->paginate(10);

        return view('reviews.index', compact('reviews'));
    }

    /**
     * Show individual review
     */
    public function show($id)
    {
        $review = Review::with('tourPackage', 'order')
                       ->where('user_id', Auth::id())
                       ->findOrFail($id);

        return view('reviews.show', compact('review'));
    }

    /**
     * Show form to edit review
     */
    public function edit($id)
    {
        $review = Review::with('tourPackage', 'order')
                       ->where('user_id', Auth::id())
                       ->where('status', 'pending') // Hanya bisa edit review yang masih pending
                       ->findOrFail($id);

        return view('reviews.edit', compact('review'));
    }

    /**
     * Update review
     */
    public function update(Request $request, $id)
    {
        $review = Review::where('user_id', Auth::id())
                       ->where('status', 'pending')
                       ->findOrFail($id);

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10|max:1000'
        ]);

        $review->update([
            'rating' => $request->rating,
            'comment' => $request->comment
        ]);

        return redirect()->route('reviews.show', $review->id)
            ->with('success', 'Review berhasil diperbarui!');
    }

    /**
     * Delete review
     */
    public function destroy($id)
    {
        $review = Review::where('user_id', Auth::id())
                       ->where('status', 'pending') // Hanya bisa hapus review yang masih pending
                       ->findOrFail($id);

        $review->delete();

        return redirect()->route('reviews.index')
            ->with('success', 'Review berhasil dihapus!');
    }
}