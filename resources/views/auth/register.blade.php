@extends('layouts.app')

@section('content')
    <div style="height: 100vh">
        <div class="container-fluid h-100">
            <div class="row h-100">
                <!-- Form Section -->
                <div class="col-md-6 d-flex align-items-center justify-content-center bg-white px-5">
                    <div class="w-100" style="max-width: 650px">
                        <h2 class="fw-bold mb-3">Selamat Datang di
                            <span class="logo">
                                <span class="book fs-1">Book</span><span class="sphere fs-2">Sphere</span><span
                                    class="dot">.</span>
                            </span>
                        </h2>
                        <p class="text-muted mb-4">
                            Sudah punya akun?
                            <a href="{{ route('login') }}" class="text-accent fw-semibold">Log in</a>
                        </p>

                        <form method="POST" action="{{ route('register-store') }}">
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

                            <!-- Username -->
                            <div class="mb-3">
                                <label class="form-label">Username</label>
                                <input type="text" name="username" value="{{ old('username') }}"
                                    class="form-control rounded-pill shadow-sm px-4 py-2 @error('username') is-invalid @enderror"
                                    required>
                                @error('username')
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

                            <!-- Password Tips -->
                            <ul id="password-requirements" class="small list-unstyled d-flex flex-wrap gap-3 mb-3 ps-1">
                                <li id="charLength"><span class="me-2 d-inline-block"
                                        style="width: 10px; height: 10px; border-radius: 50%; background-color: #b0b0b0;"></span>8+
                                    karakter</li>
                                <li id="upperCase"><span class="me-2 d-inline-block"
                                        style="width: 10px; height: 10px; border-radius: 50%; background-color: #b0b0b0;"></span>1
                                    huruf besar</li>
                                <li id="lowerCase"><span class="me-2 d-inline-block"
                                        style="width: 10px; height: 10px; border-radius: 50%; background-color: #b0b0b0;"></span>1
                                    huruf kecil</li>
                                <li id="number"><span class="me-2 d-inline-block"
                                        style="width: 10px; height: 10px; border-radius: 50%; background-color: #b0b0b0;"></span>1
                                    angka</li>
                                <li id="symbol"><span class="me-2 d-inline-block"
                                        style="width: 10px; height: 10px; border-radius: 50%; background-color: #b0b0b0;"></span>1
                                    simbol</li>
                            </ul>




                            <!-- Konfirmasi Password -->
                            <div class="mb-3">
                                <label class="form-label">Konfirmasi Password</label>
                                <input type="password" name="password_confirmation"
                                    class="form-control rounded-pill shadow-sm px-4 py-2" required>
                            </div>

                            <!-- Checkbox -->
                            <div class="form-check mb-3">
                                <input class="form-check-input custom-checkbox" type="checkbox" id="termsCheck"
                                    name="termsCheck" required>
                                <label class="form-check-label small" for="termsCheck">
                                    Saya menyetujui <a href="#" class="text-accent">Ketentuan Layanan</a> dan
                                    <a href="#" class="text-accent">Kebijakan Privasi</a>.
                                </label>
                            </div>

                            <!-- Submit -->
                            <button type="submit"
                                class="btn btn-booksphere border rounded-pill bg-accent w-100 py-2 fw-semibold">
                                Buat Akun
                            </button>

                            <!-- Terms Note -->
                            <p class="small mt-3 text-muted text-center">
                                Dengan membuat akun, Anda menyetujui
                                <a href="#" class="text-accent">Ketentuan Layanan</a> dan
                                <a href="#" class="text-accent">Kebijakan Privasi</a>.
                            </p>
                        </form>

                        <!-- Divider -->
                        <div class="text-center my-3 text-muted">atau</div>

                        <!-- Google Register -->
                        <a href="{{ route('google.login') }}"
                            class="btn btn-outline-dark w-100 rounded-pill d-flex align-items-center justify-content-center gap-2 shadow-sm py-2">
                            <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google" width="20">
                            <span class="fw-semibold">Daftar dengan Google</span>
                        </a>

                    </div>
                </div>

                <!-- Image Section -->
                <div class="col-md-6 imgRegister"></div>
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
            if (password.type === 'password') {
                password.type = 'text';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
                label.innerText = 'Show';
            } else {
                password.type = 'password';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
                label.innerText = 'Hide';
            }

        }

        const passwordInput = document.getElementById('password');

        const rules = {
            charLength: /.{8,}/,
            upperCase: /[A-Z]/,
            lowerCase: /[a-z]/,
            number: /[0-9]/,
            symbol: /[@$!%*#?&]/,
        };

        const updateValidation = (value) => {
            for (let rule in rules) {
                const dot = document.querySelector(`#${rule} span`);
                const isValid = rules[rule].test(value);

                dot.style.backgroundColor = isValid ? '#5D4037' : '#b0b0b0';
            }
        };

        passwordInput.addEventListener('input', function() {
            updateValidation(this.value);
        });
    </script>
@endpush
