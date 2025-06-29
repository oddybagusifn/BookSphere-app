<?php

namespace App\Http\Controllers\User;

use App\Models\Book;
use App\Models\Cart;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $bookId = $request->input('book_id');
        $book = Book::findOrFail($bookId);
        $user = Auth::user();

        $existing = Cart::where('user_id', $user->id)
            ->where('book_id', $book->id)
            ->first();

        if ($existing) {
            return redirect()->back()->with('warning', 'Buku sudah ada di keranjang Anda.');
        }

        Cart::create([
            'user_id' => $user->id,
            'book_id' => $book->id,
        ]);

        return redirect()->back()->with('success', 'Buku berhasil ditambahkan ke keranjang.');
    }


    public function remove(Request $request)
    {
        $user = Auth::user();
        $bookId = $request->input('book_id');

        Cart::where('user_id', $user->id)
            ->where('book_id', $bookId)
            ->delete();

        return redirect()->back()->with('success', 'Buku berhasil dihapus dari keranjang.');
    }


    public function verify()
    {
        $cart = Cart::with('book.category')
            ->where('user_id', Auth::id())
            ->get();

        if ($cart->isEmpty()) {
            return redirect()->back()->with('error', 'Keranjang kamu masih kosong.');
        }

        return view('user.cart.verify', compact('cart'));
    }

    public function viewCart()
    {
        $user = Auth::user();

        $cartItems = Cart::with('book.category')
            ->where('user_id', $user->id)
            ->get();

        $html = view('partials.cart-items-render', compact('cartItems'))->render();

        return response()->json(['html' => $html]);
    }


    public function submitVerification(Request $request)
    {
        $request->validate([
            'duration' => 'required|in:3,7,14',
        ]);

        $userId = Auth::id();
        $cartItems = Cart::with('book')->where('user_id', $userId)->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('user.books.index')->with('error', 'Keranjang kamu kosong.');
        }

        DB::beginTransaction();

        try {
            foreach ($cartItems as $item) {
                Borrowing::create([
                    'user_id'     => $userId,
                    'book_id'     => $item->book_id,
                    'borrowed_at' => now(),
                    'returned_at' => now()->addDays((int) $request->duration),
                ]);

                $item->delete();
            }

            DB::commit();

            return redirect()->route('user.collection')->with('success', 'Peminjaman berhasil! Buku kamu sudah masuk ke koleksi.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses peminjaman.');
        }
    }
}
