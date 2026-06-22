<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pegawai', function (Blueprint $table) {
            // Menambahkan kolom 'foto' dengan tipe string, bersifat nullable (boleh kosong),
            // dan posisinya diletakkan setelah kolom 'jabatan' agar struktur tabel tetap rapi.
            $table->string('foto')->nullable()->after('jabatan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pegawai', function (Blueprint $table) {
            // Fungsi rollback untuk menghapus kembali kolom 'foto' jika migration di-refresh/rollback
            $table->dropColumn('foto');
        });
    }
};