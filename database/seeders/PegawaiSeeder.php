<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pegawai;

class PegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Pegawai::create([
            'nip'     => '198001012008011001',
            'nama'    => 'Wawan Darmawan',
            'skpd'    => 'Dinas Pendidikan',
            'jabatan' => 'Kepala Dinas',
        ]);

        Pegawai::create([
            'nip'     => '198505052010012002',
            'nama'    => 'Maudy Koesnadi',
            'skpd'    => 'Dinas Kesehatan',
            'jabatan' => 'Analis Kesehatan',
        ]);
    }
}