<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Mpdf\Mpdf; 

class PegawaiController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil daftar unik semua nama SKPD untuk mengisi opsi pilihan di elemen Dropdown
        $allSkpd = Pegawai::select('skpd')->groupBy('skpd')->pluck('skpd')->toArray();

        // 2. Buat instance Query Builder dasar untuk Tabel dan Chart
        $pegawaiQuery = Pegawai::query();
        $chartQuery = Pegawai::select('skpd', DB::raw('count(*) as total'))->groupBy('skpd');

        // 3. Logika Filter Interaktif: Jika user memilih SKPD tertentu di dropdown form
        if ($request->filled('skpd')) {
            $pegawaiQuery->where('skpd', $request->skpd);
            $chartQuery->where('skpd', $request->skpd); // Grafik ikut terfilter
        }

        // 4. Eksekusi pengambilan data akhir dari database MySQL
        $pegawai = $pegawaiQuery->get();
        $chartData = $chartQuery->get();

        // 5. Ekstraksi data array untuk kebutuhan komponen Chart.js di frontend
        $chartLabels = $chartData->pluck('skpd')->toArray();
        $chartTotals = $chartData->pluck('total')->toArray();

        // 6. Kirim variabel baru ($allSkpd) ke halaman View index
        return view('pegawai.index', compact('pegawai', 'chartLabels', 'chartTotals', 'allSkpd'));
    }

    public function create()
    {
        return view('pegawai.create');
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nip'     => 'required|unique:pegawai,nip|max:20',
            'nama'    => 'required|string|max:255',
            'skpd'    => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'foto'    => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            $filename = time() . '.' . $request->file('foto')->extension();
            $path = $request->file('foto')->storeAs('pegawai', $filename, 'public');
            $data['foto'] = $path;
        }

        Pegawai::create($data);

        return redirect()->route('pegawai.index')->with('success', 'Data pegawai dan foto berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $pegawai = Pegawai::findOrFail($id);
        return view('pegawai.edit', compact('pegawai'));
    }

    public function update(Request $request, $id)
    {
        $pegawai = Pegawai::findOrFail($id);

        $request->validate([
            'nip'     => 'required|max:20|unique:pegawai,nip,' . $pegawai->id,
            'nama'    => 'required|string|max:255',
            'skpd'    => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'foto'    => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            if ($pegawai->foto && Storage::disk('public')->exists($pegawai->foto)) {
                Storage::disk('public')->delete($pegawai->foto);
            }

            $filename = time() . '.' . $request->file('foto')->extension();
            $path = $request->file('foto')->storeAs('pegawai', $filename, 'public');
            $data['foto'] = $path;
        }

        $pegawai->update($data);

        return redirect()->route('pegawai.index')->with('success', 'Data pegawai berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pegawai = Pegawai::findOrFail($id);

        if ($pegawai->foto && Storage::disk('public')->exists($pegawai->foto)) {
            Storage::disk('public')->delete($pegawai->foto);
        }

        $pegawai->delete();

        return redirect()->route('pegawai.index')->with('success', 'Data pegawai beserta berkas foto berhasil dihapus.');
    }

    /**
     * MENCETAK LAPORAN MENGGUNAKAN mPDF (Mendukung Sinkronisasi Filter)
     */
    public function cetakPdf(Request $request)
    {
        // 1. Buat query rekapitulasi dasar
        $rekapQuery = Pegawai::select('skpd', DB::raw('count(*) as total'))->groupBy('skpd');
        $totalQuery = Pegawai::query();

        // 2. Filter data PDF disesuaikan dengan filter halaman index yang sedang aktif
        if ($request->filled('skpd')) {
            $rekapQuery->where('skpd', $request->skpd);
            $totalQuery->where('skpd', $request->skpd);
        }

        $rekapSkpd = $rekapQuery->get();
        $totalPegawaiSemesta = $totalQuery->count();

        // 3. Ambil gambar Chart.js (format base64) dari frontend hidden input
        $chartImage = $request->input('chart_base64');

        // 4. Render file blade menjadi string HTML murni agar bisa dibaca mPDF
        $html = view('pegawai.cetak_pdf', compact('rekapSkpd', 'totalPegawaiSemesta', 'chartImage'))->render();

        // 5. Inisialisasi mPDF dengan format kertas A4 Portrait dan margin standar (15mm)
        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'margin_left' => 15,
            'margin_right' => 15,
            'margin_top' => 15,
            'margin_bottom' => 15,
        ]);

        // 6. Masukkan HTML ke dokumen mPDF dan unduh otomatis file-nya
        $mpdf->WriteHTML($html);
        
        return $mpdf->Output('Laporan_Distribusi_Pegawai_' . date('Y-m-d') . '.pdf', \Mpdf\Output\Destination::DOWNLOAD);
    }
}