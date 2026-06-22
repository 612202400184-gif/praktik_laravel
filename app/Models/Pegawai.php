<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;

    // 1. Tentukan nama tabel secara eksplisit (sesuaikan dengan nama di database Anda, misalnya 'pegawai')
    protected $table = 'pegawai'; 

    // 2. Tentukan primary key
    // protected $primaryKey = 'nip';

    // 3. Nonaktifkan auto-increment karena NIP berupa karakter atau angka
    public $incrementing = false;

    // 4. Tentukan tipe data primary key (string)
    protected $keyType = 'string';

    // 5. Daftarkan kolom yang bisa diisi (Mass Assignment)
    protected $fillable = [
        'nip',
        'nama',
        'skpd',
        'jabatan',
        'foto',
    ];
}