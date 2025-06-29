<?php

namespace App\Http\Controllers\User;

use App\Models\Borrowing;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CollectionController extends Controller
{
    public function index()
    {
        $borrowings = Borrowing::with('book')
            ->where('user_id', Auth::id())
            ->latest('borrowed_at')
            ->get();
        return view('user.collection', compact('borrowings'));
    }

    public function returnBook($id)
{
    $borrow = Borrowing::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
    $borrow->update(['returned_at' => now()]);

    return redirect()->route('user.collection')->with('success', 'Buku berhasil dikembalikan.');
}

}
