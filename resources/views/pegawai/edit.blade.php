@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Edit Data Pegawai</h5>
                    <a href="{{ route('pegawai.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
                </div>

                <div class="card-body">
                    <form action="{{ route('pegawai.update', $pegawai->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="nip" class="form-label">NIP</label>
                            <input type="text" name="nip" id="nip" class="form-control @error('nip') is-invalid @enderror" value="{{ old('nip', $pegawai->nip) }}" required>
                            @error('nip')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $pegawai->nama) }}" required>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="skpd" class="form-label">SKPD</label>
                            <input type="text" name="skpd" id="skpd" class="form-control @error('skpd') is-invalid @enderror" value="{{ old('skpd', $pegawai->skpd) }}" required>
                            @error('skpd')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="jabatan" class="form-label">Jabatan</label>
                            <input type="text" name="jabatan" id="jabatan" class="form-control @error('jabatan') is-invalid @enderror" value="{{ old('jabatan', $pegawai->jabatan) }}" required>
                            @error('jabatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="foto" class="form-label">Foto Pegawai (Biarkan kosong jika tidak ingin diubah)</label>
                            
                            <div class="mb-2">
                                @if($pegawai->foto)
                                    <div class="text-muted small mb-1">Foto saat ini:</div>
                                    <img src="{{ asset('storage/' . $pegawai->foto) }}" class="img-thumbnail d-block mb-2" style="max-height: 120px;" id="old-photo">
                                @else
                                    <div class="text-muted small mb-1">Belum ada foto profil.</div>
                                @endif
                            </div>

                            <input type="file" name="foto" id="foto" class="form-control @error('foto') is-invalid @enderror" accept="image/*" onchange="previewImage()">
                            <small class="text-muted d-block mt-1">Format: JPG, JPEG, PNG. Maksimal 2MB.</small>
                            @error('foto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            
                            <div class="mt-3">
                                <div id="preview-title" class="text-muted small mb-1 d-none">Preview foto baru:</div>
                                <img id="img-preview" class="img-fluid rounded d-none" style="max-height: 150px; object-fit: cover;">
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Perbarui Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Script Opsional untuk Preview Gambar Baru --}}
<script>
    function previewImage() {
        const image = document.querySelector('#foto');
        const imgPreview = document.querySelector('#img-preview');
        const previewTitle = document.querySelector('#preview-title');

        if (image.files && image.files[0]) {
            imgPreview.classList.remove('d-none');
            if(previewTitle) previewTitle.classList.remove('d-none');
            
            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);

            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;
            }
        }
    }
</script>
@endsection