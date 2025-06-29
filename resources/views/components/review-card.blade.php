<div class="border rounded-4 p-4 bg-white">
    <!-- Rating -->
    <div class="text-warning mb-2">
        @for ($i = 1; $i <= 5; $i++)
            <i class="ph {{ $i <= $review->rating ? 'ph-star' : 'ph-star' }}"></i>
        @endfor
    </div>

    <!-- Komentar -->
    <p class="fw-semibold mb-1">
        {{ $review->comment ?: 'This user did not leave a comment.' }}
    </p>
    <p class="text-muted small mb-3">
        {{ $review->created_at->format('F j, Y h:i A') }}
    </p>

    @php
        $user = $review->user;
        $initial = strtoupper(substr($user->username, 0, 1));
        $gradients = [
            'linear-gradient(135deg, #FF9A9E 0%, #FAD0C4 100%)',
            'linear-gradient(135deg, #A18CD1 0%, #FBC2EB 100%)',
            'linear-gradient(135deg, #84FAB0 0%, #8FD3F4 100%)',
            'linear-gradient(135deg, #FFDEE9 0%, #B5FFFC 100%)',
            'linear-gradient(135deg, #C9FFBF 0%, #FFAFBD 100%)',
        ];
        $hash = crc32($user->username);
        $index = $hash % count($gradients);
        $gradient = $gradients[$index];
    @endphp

    <!-- User & Reaksi -->
    <div class="d-flex justify-content-between align-items-center border-top pt-3">
        <div class="d-flex align-items-center gap-2">
            @if ($user->avatar)
                <img src="{{ $user->avatar }}" class="rounded-circle" width="32" height="32" alt="Avatar">
            @else
                <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold"
                    style="width: 32px; height: 32px; background: {{ $gradient }}">
                    {{ $initial }}
                </div>
            @endif

            <span class="fw-semibold">{{ $user->username }}</span>
        </div>
        <div class="d-flex align-items-center gap-2">
            <button class="btn btn-sm border rounded-pill d-flex align-items-center gap-1 px-3">
                <i class="ph ph-thumbs-up-fill"></i> {{ rand(0, 200) }}
            </button>
            <button class="btn btn-sm border rounded-pill d-flex align-items-center gap-1 px-3">
                <i class="ph ph-thumbs-down"></i>
            </button>
        </div>
    </div>
</div>
