@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white d-flex justify-content-between align-items-center py-3 border-bottom">
                    <h4 class="mb-0 text-primary fw-bold">Data Pegawai</h4>
                    <a href="{{ url('pegawai/tambah') }}" class="btn btn-success btn-sm">
                        <i class="fas fa-plus"></i> Tambah Pegawai
                    </a>
                </div>

                <div class="card-body">
                    {{-- Alert Notifikasi Sukses --}}
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    {{-- Tabel Data Pegawai --}}
                    <div class="table-responsive mt-3">
                        <table class="table table-hover table-bordered align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%" class="text-center">No</th>
                                    <th>NIP</th>
                                    <th>Nama</th>
                                    <th>SKPD</th>
                                    <th>Jabatan</th>
                                    <th width="20%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pegawai as $key => $p)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $p->nip }}</td>
                                    <td>{{ $p->nama }}</td>
                                    <td>{{ $p->skpd }}</td>
                                    <td>{{ $p->jabatan }}</td>
                                    <td class="text-center">
                                        {{-- Menggunakan $p->nip sebagai parameter utama pengganti id --}}
                                        <a href="{{ url('pegawai/edit/'.$p->nip) }}" class="btn btn-warning btn-sm text-white me-1">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <a href="{{ url('pegawai/hapus/'.$p->nip) }}" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                            <i class="fas fa-trash-alt"></i> Hapus
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">
                                        Data pegawai belum tersedia. Silakan tambahkan data baru.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection