<!DOCTYPE html>

@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Tambah Pegawai</h2>
    <a href="{{ url('/pegawai') }}" class="mb-3 d-block">Kembali</a>

    <form action="{{ url('/pegawai/simpan') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nip" class="form-label">NIP</label>
            <input type="text" class="form-control" id="nip" name="nip" required>
        </div>
        <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" class="form-control" id="nama" name="nama" required>
        </div>
        <div class="mb-3">
            <label for="skpd" class="form-label">SKPD</label>
            <input type="text" class="form-control" id="skpd" name="skpd" required>
        </div>
        <div class="mb-3">
            <label for="jabatan" class="form-label">Jabatan</label>
            <input type="text" class="form-control" id="jabatan" name="jabatan" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection