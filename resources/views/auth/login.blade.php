@extends('layouts.app')

@section('content')
    <div style="height: 100vh">
        <div class="container-fluid h-100">
            <div class="row h-100">
                <!-- Image Section -->
                <div class="col-md-6 d-none d-md-block imgLogin"></div>

                <!-- Form Section -->
                <div class="col-md-6 d-flex align-items-center justify-content-center bg-white px-5">
                    <div class="w-100" style="max-width: 650px">
                        <h2 class="fw-bold mb-3">Masuk ke
                            <span class="logo">
                                <span class="book fs-1">Book</span><span class="sphere fs-2">Sphere</span><span
                                    class="dot">.</span>
                            </span>
                        </h2>
                        <p class="text-muted mb-4">
                            Belum punya akun?
                            <a href="{{ route('register-page') }}" class="text-accent fw-semibold">Daftar</a>
                        </p>

                        <form method="POST" action="{{ route('login-store') }}">
                            @csrf

                            <!-- Email -->
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" value="{{ old('email') }}"
                                    class="form-control rounded-pill shadow-sm px-4 py-2 @error('email') is-invalid @enderror"
                                    required>
                                @error('email')
                                    <div class="invalid-feedback d-block small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="mb-2 position-relative">
                                <label class="form-label">Password</label>
                                <input type="password" id="password" name="password"
                                    class="form-control rounded-pill shadow-sm px-4 py-2 @error('password') is-invalid @enderror"
                                    required>
                                <span onclick="togglePassword()"
                                    class="position-absolute top-50 end-0 translate-middle-y me-4 text-muted"
                                    style="cursor: pointer;">
                                </span>
                                @error('password')
                                    <div class="invalid-feedback d-block small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Remember Me -->
                            <div class="form-check mb-3">
                                <input class="form-check-input custom-checkbox" type="checkbox" name="remember"
                                    id="remember">
                                <label class="form-check-label small" for="remember">
                                    Ingat saya
                                </label>
                            </div>

                            <!-- Submit -->
                            <button type="submit"
                                class="btn btn-booksphere border rounded-pill bg-accent w-100 py-2 fw-semibold">
                                Log In
                            </button>

                            <!-- Forgot Password -->
                            <div class="mt-3 text-end">
                                <a href="" class="text-accent small">Lupa password?</a>
                            </div>
                        </form>

                        <!-- Divider -->
                        <div class="text-center my-3 text-muted">atau</div>

                        <!-- Google Login -->
                        <a href="{{ route('google.login') }}"
                            class="btn btn-outline-dark w-100 rounded-pill d-flex align-items-center justify-content-center gap-2 shadow-sm py-2">
                            <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google" width="20">
                            <span class="fw-semibold">Masuk dengan Google</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function togglePassword() {
            const password = document.getElementById('password');
            const icon = event.target.closest('span').querySelector('i');
            const label = event.target.closest('span').querySelector('small');
        }
    </script>
@endpush
