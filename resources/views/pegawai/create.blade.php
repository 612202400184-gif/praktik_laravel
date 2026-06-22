@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Tambah Pegawai Baru</h5>
                    <a href="{{ route('pegawai.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
                </div>

                <div class="card-body">
                    <form action="{{ route('pegawai.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="nip" class="form-label">NIP</label>
                            <input type="text" name="nip" id="nip" class="form-control @error('nip') is-invalid @enderror" value="{{ old('nip') }}" required>
                            @error('nip')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}" required>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="skpd" class="form-label">SKPD</label>
                            <input type="text" name="skpd" id="skpd" class="form-control @error('skpd') is-invalid @enderror" value="{{ old('skpd') }}" required>
                            @error('skpd')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="jabatan" class="form-label">Jabatan</label>
                            <input type="text" name="jabatan" id="jabatan" class="form-control @error('jabatan') is-invalid @enderror" value="{{ old('jabatan') }}" required>
                            @error('jabatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="foto" class="form-label">Foto Pegawai</label>
                            <input type="file" name="foto" id="foto" class="form-control @error('foto') is-invalid @enderror" accept="image/*" onchange="previewImage()">
                            <small class="text-muted d-block mt-1">Format: JPG, JPEG, PNG. Maksimal 2MB.</small>
                            @error('foto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            
                            <div class="mt-3">
                                <img id="img-preview" class="img-fluid rounded d-none" style="max-height: 150px; object-fit: cover;">
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="reset" class="btn btn-light me-2">Reset</button>
                            <button type="submit" class="btn btn-primary">Simpan Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Script Opsional untuk Preview Gambar (Kriteria Praktikum Latihan 1) --}}
<script>
    function previewImage() {
        const image = document.querySelector('#foto');
        const imgPreview = document.querySelector('#img-preview');

        if (image.files && image.files[0]) {
            imgPreview.classList.remove('d-none');
            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);

            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;
            }
        }
    }
</script>
@endsection