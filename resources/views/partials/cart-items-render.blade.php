@if ($cartItems->count())
    @foreach ($cartItems as $item)
        @include('partials.cart-items', ['book' => $item->book])
    @endforeach
@else
    <div class="text-muted h-100 d-flex justify-content-center flex-column align-items-center gap-3">
        <i class="ph ph-empty fs-1"></i>
        Keranjang masih kosong.
    </div>
@endif
