@extends('layouts.app')

@section('content')
    <section class="py-5 px-3 px-md-5 min-vh-100 ">
        <div class="container">
            <!-- Heading -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold text-accent">
                    <i class="ph ph-plus-circle me-2"></i> Tambah Buku
                </h3>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-outline-dark">
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
                            <label for="title" class="form-label fw-semibold">Judul Buku</label>
                            <input type="text" name="title"
                                class="form-control rounded-3 @error('title') is-invalid @enderror"
                                placeholder="Contoh: Surti Tejo" value="{{ old('title') }}">
                            @error('title')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Penulis -->
                        <div class="mb-3">
                            <label for="author" class="form-label fw-semibold">Penulis</label>
                            <input type="text" name="author"
                                class="form-control rounded-3 @error('author') is-invalid @enderror"
                                placeholder="Contoh: Budi Santoso" value="{{ old('author') }}">
                            @error('author')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Kategori -->
                        <div class="mb-3">
                            <label for="category_id" class="form-label fw-semibold">Kategori</label>
                            <select name="category_id"
                                class="form-select rounded-3 @error('category_id') is-invalid @enderror">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>


                        <!-- Deskripsi -->
                        <div class="mb-3">
                            <label for="description" class="form-label fw-semibold">Deskripsi</label>
                            <textarea name="description" class="form-control rounded-3 @error('description') is-invalid @enderror" rows="4"
                                placeholder="Tulis ringkasan isi buku...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Cover -->
                        <div class="mb-4">
                            <label for="cover" class="form-label fw-semibold">Cover Buku</label>
                            <input type="file" name="cover"
                                class="form-control rounded-3 @error('cover') is-invalid @enderror">
                            @error('cover')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tombol Simpan -->
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn text-white fw-semibold px-4 py-2"
                                style="background-color: #5D4037;">
                                <i class="ph ph-floppy-disk me-2"></i> Simpan Buku
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
