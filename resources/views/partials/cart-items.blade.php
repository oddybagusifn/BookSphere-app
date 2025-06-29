    @php
        $book = $item->book;
    @endphp

    <div class="d-flex bg-white shadow rounded gap-5 overflow-hidden mb-3" style="min-height: 120px;">
        {{-- Left Panel: Cover --}}
        <div style="min-width: 160px; max-width: 160px; position: relative; overflow: hidden;">
            <div
                style="background-image: url('{{ $book->cover_url }}');
                background-size: cover;
                background-position: center;
                width: 100%;
                height: 100%;
                filter: blur(6px);
                transform: scale(1.1);">
            </div>
            <div
                style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;
                background: linear-gradient(to right, rgba(0, 0, 0, 0.5), transparent);">
            </div>
            <div class="position-absolute top-50 start-50 translate-middle text-white text-center px-2"
                style="z-index: 2;">
                <img src="{{ $book->cover_url }}" alt="cover" class="img-fluid shadow-sm rounded"
                    style="max-height: 80px;">
            </div>
        </div>

        {{-- Right Panel --}}
        <div class="flex-grow-1 d-flex flex-column justify-content-between px-3 py-2">
            <div>
                <div class="fw-semibold mb-1" style="font-size: 1rem;">{{ $book->title }}</div>
                <div class="small text-muted mb-1">Penulis: {{ $book->author ?? '-' }}</div>
                <div class="small text-muted mb-1">ISBN: {{ $book->isbn ?? '-' }}</div>
                <div class="small text-muted">Kategori: {{ $book->category->name ?? '-' }}</div>
            </div>

            <div class="d-flex justify-content-end">
                <form action="{{ route('cart.remove') }}" method="POST">
                    @csrf
                    <input type="hidden" name="book_id" value="{{ $book->id }}">
                    <button class="btn btn-danger px-2 py-1 rounded-pill" type="submit" style="font-size: 0.8rem;">
                        <i class="ph ph-trash"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
