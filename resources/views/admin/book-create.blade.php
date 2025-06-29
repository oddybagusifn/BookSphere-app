@extends('layouts.app')

@section('content')
    <section class="py-5 px-3 px-md-5 min-vh-100 ">
        <div class="container">
            <!-- Heading -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold text-accent">
                    <i class="ph ph-plus-circle me-2"></i> Tambah Buku
                </h3>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-sm rounded-pill btn-outline-dark">
                    <i class="ph ph-arrow-left me-1"></i> Kembali
                </a>
            </div>

            <!-- Form Card -->
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Judul Buku -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Judul Buku</label>
                            <input type="text" name="title"
                                class="form-control rounded-3 @error('title') is-invalid @enderror"
                                value="{{ old('title') }}" placeholder="Contoh: Surti Tejo">
                            @error('title')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Penulis -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Penulis</label>
                            <input type="text" name="author"
                                class="form-control rounded-3 @error('author') is-invalid @enderror"
                                value="{{ old('author') }}" placeholder="Contoh: Budi Santoso">
                            @error('author')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Penerbit -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Penerbit</label>
                            <input type="text" name="publisher" class="form-control rounded-3"
                                value="{{ old('publisher') }}">
                        </div>

                        <!-- ISBN & Tahun Terbit -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">ISBN</label>
                                <input type="text" name="isbn" class="form-control rounded-3"
                                    value="{{ old('isbn') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Tahun Terbit</label>
                                <input type="number" name="published_year" class="form-control rounded-3"
                                    value="{{ old('published_year') }}">
                            </div>
                        </div>

                        <!-- Edisi & Bahasa -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Edisi</label>
                                <input type="text" name="edition" class="form-control rounded-3"
                                    value="{{ old('edition') }}">
                            </div>
                            <div class="col-md-6 ">
                                <label class="form-label fw-semibold">Bahasa</label>
                                <select id="languageSelect" name="language" class="form-select rounded-3">
                                    <option value="">Memuat daftar bahasa...</option>
                                </select>
                            </div>

                        </div>

                        <!-- Jumlah Halaman -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Jumlah Halaman</label>
                            <input type="number" name="page_count" class="form-control rounded-3"
                                value="{{ old('page_count') }}">
                        </div>

                        <!-- Input Kategori -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Kategori</label>
                            <input type="text" name="category_name" list="categoryList"
                                class="form-control rounded-3 @error('category_name') is-invalid @enderror"
                                value="{{ old('category_name') }}" placeholder="Contoh: Fiksi, Biografi, Teknologi...">
                            <datalist id="categoryList">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->name }}"></option>
                                @endforeach
                            </datalist>
                            @error('category_name')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>





                        <!-- Sinopsis -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Sinopsis</label>
                            <textarea name="synopsis" class="form-control rounded-3" rows="4" placeholder="Tulis ringkasan isi buku...">{{ old('synopsis') }}</textarea>
                        </div>

                        <!-- Link Baca (opsional) -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Link Baca (jika ada)</label>
                            <input type="url" name="read_url" class="form-control rounded-3"
                                value="{{ old('read_url') }}" placeholder="https://archive.org/...">
                        </div>

                        <!-- Apakah Bisa Dibaca -->
                        <div class="form-check form-switch mb-4">
                            <input class="form-check-input" type="checkbox" name="is_readable" id="isReadable"
                                value="1" {{ old('is_readable') ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold" for="isReadable">Buku dapat dibaca langsung</label>
                        </div>

                        <!-- Cover -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Cover Buku</label>
                            <input type="file" name="cover"
                                class="form-control rounded-3 @error('cover') is-invalid @enderror">
                            @error('cover')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tombol Simpan -->
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn text-white rounded-pill fw-semibold px-4 py-2"
                                style="background-color: #5D4037;">
                                <i class="ph ph-floppy-disk me-2"></i> Simpan Buku
                            </button>
                        </div>

                        <!-- Hidden Source -->
                        <input type="hidden" name="source" value="manual">
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection


@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", async () => {
            const select = document.getElementById("languageSelect");
            try {
                const response = await fetch("https://libretranslate.com/languages");
                const languages = await response.json();

                select.innerHTML = `<option value="">-- Pilih Bahasa --</option>`;
                languages.forEach(lang => {
                    const option = document.createElement("option");
                    option.value = lang.name;
                    option.textContent = lang.name;
                    select.appendChild(option);
                });
            } catch (error) {
                console.error("Gagal memuat bahasa:", error);
                select.innerHTML = `<option value="">Gagal memuat bahasa</option>`;
            }

        });
    </script>
@endpush
