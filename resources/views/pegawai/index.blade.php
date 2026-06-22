@extends('layouts.app')

@section('content')
<div class="container">
    {{-- 1. SECTION VISUALISASI DATA CHART & TOMBOL CETAK PDF --}}
    <div class="row justify-content-center mb-4">
        <div class="col-md-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white d-flex justify-content-between align-items-center py-3 border-bottom">
                    <h5 class="mb-0 text-primary fw-bold">
                        <i class="fas fa-chart-bar me-2"></i>Grafik Distribusi Pegawai per SKPD
                    </h5>
                    
                    {{-- Form Tersembunyi untuk Mengirimkan Gambar Chart ke Backend mPDF --}}
                    <form action="{{ route('pegawai.cetak_pdf') }}" method="POST" id="formCetakPdf" target="_blank">
                        @csrf
                        <input type="hidden" name="chart_base64" id="chart_base64">
                        <button type="button" id="btnCetak" class="btn btn-danger btn-sm px-3 shadow-sm">
                            <i class="fas fa-file-pdf me-1"></i> Cetak Laporan PDF (mPDF)
                        </button>
                    </form>
                </div>
                <div class="card-body">
                    <div style="max-height: 280px; position: relative;">
                        {{-- Kanvas Grafik Batang --}}
                        <canvas id="pegawaiChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 2. SECTION UTAMA: TABEL DATA PEGAWAI --}}
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-sm border-0">
                <div class="card-header d-flex justify-content-between align-items-center bg-white py-3 border-bottom">
                    <h5 class="mb-0 fw-bold text-secondary">Daftar Pegawai Sesuai Hak Akses</h5>
                    {{-- Tombol Tambah hanya untuk Admin & Operator --}}
                    @if(auth()->user()->role == 'admin' || auth()->user()->role == 'operator')
                        <a href="{{ route('pegawai.create') }}" class="btn btn-primary btn-sm px-3 shadow-sm">
                            <i class="fas fa-plus me-1"></i> Tambah Pegawai
                        </a>
                    @endif
                </div>

                <div class="card-body">
                    {{-- Notifikasi Sukses CRUD --}}
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                            <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover table-bordered vertical-align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center" width="50">No</th>
                                    <th class="text-center" width="80">Foto</th>
                                    <th>NIP</th>
                                    <th>Nama</th>
                                    <th>SKPD</th>
                                    <th>Jabatan</th>
                                    <th class="text-center" width="200">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pegawai as $index => $p)
                                    <tr>
                                        <td class="text-center fw-bold text-muted">{{ $index + 1 }}</td>
                                        <td class="text-center">
                                            @if($p->foto)
                                                {{-- Menampilkan gambar dari folder storage publik --}}
                                                <img src="{{ asset('storage/' . $p->foto) }}" alt="Foto {{ $p->nama }}" class="rounded-circle img-thumbnail shadow-sm" style="width: 50px; height: 50px; object-fit: cover;">
                                            @else
                                                {{-- Placeholder jika pegawai tidak punya foto profil --}}
                                                <img src="https://ui-avatars.com/api/?name={{ urlencode($p->nama) }}&background=random&color=fff&size=50" alt="No Image" class="rounded-circle img-thumbnail shadow-sm" style="width: 50px; height: 50px;">
                                            @endif
                                        </td>
                                        <td class="fw-bold text-secondary">{{ $p->nip }}</td>
                                        <td>{{ $p->nama }}</td>
                                        <td><span class="badge bg-light text-dark border px-2 py-1">{{ $p->skpd }}</span></td>
                                        <td>{{ $p->jabatan }}</td>
                                        <td class="text-center">
                                            {{-- Aksi Edit untuk Admin & Operator --}}
                                            @if(auth()->user()->role == 'admin' || auth()->user()->role == 'operator')
                                                <a href="{{ route('pegawai.edit', $p->id) }}" class="btn btn-warning btn-sm text-white px-2 me-1 shadow-sm">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                            @endif

                                            {{-- Aksi Hapus Khusus Admin (Aman dengan konfirmasi) --}}
                                            @if(auth()->user()->role == 'admin')
                                                <form action="{{ route('pegawai.destroy', $p->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm px-2 shadow-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini beserta berkas gambarnya dari storage?')">
                                                        <i class="fas fa-trash"></i> Hapus
                                                    </button>
                                                </form>
                                            @endif

                                            {{-- Penanda jika role-nya hanya viewer --}}
                                            @if(auth()->user()->role == 'viewer')
                                                <span class="badge bg-info text-dark px-2 py-1"><i class="fas fa-eye me-1"></i>Hanya Lihat</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-4">
                                            <i class="fas fa-folder-open d-block mb-2 fa-2x"></i> Data pegawai masih kosong.
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

{{-- CSS Opsional Penyelaras Baris Tabel --}}
<style>
    .vertical-align-middle td, .vertical-align-middle th {
        vertical-align: middle;
    }
</style>

{{-- 3. JAVASCRIPT: CHART.JS & ENGINE EKSTRAKSI UNTUK mPDF --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Parsing data array agregat dari PHP Laravel ke JavaScript JSON Array
        const labelsData = {!! json_encode($chartLabels) !!};
        const totalsData = {!! json_encode($chartTotals) !!};

        const ctx = document.getElementById('pegawaiChart').getContext('2d');
        
        // Memasang instance chart ke window object global agar bisa ditarik datanya saat submit PDF
        window.myPegawaiChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labelsData,
                datasets: [{
                    label: 'Jumlah Pegawai',
                    data: totalsData,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: {
                    duration: 0 // Dimatikan agar grafik instan terbentuk saat render & siap diproses base64-nya
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 }
                    }
                },
                plugins: {
                    legend: { display: false }
                }
            }
        });

        // Logika Pengiriman Gambar Chart Base64 ke Backend mPDF saat tombol Cetak ditekan
        document.getElementById('btnCetak').addEventListener('click', function() {
            if (window.myPegawaiChart) {
                // Konversi Canvas Chart.js menjadi text image string base64 PNG
                const base64Image = window.myPegawaiChart.toBase64Image();
                document.getElementById('chart_base64').value = base64Image;
                
                // Eksekusi kirim form ke method cetakPdf di Controller
                document.getElementById('formCetakPdf').submit();
            }
        });
    });
</script>
@endsection