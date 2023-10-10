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
        Schema::table('files', function (Blueprint $table) {
            $table->string('nama')->nullable();
            $table->string('sekolah')->nullable();
            $table->string('tempat')->nullable();
            $table->string('tgl_lahir')->nullable();
            $table->string('posisi')->nullable();
            $table->date('tgl_join')->nullable();
            $table->date('tgl_keluar')->nullable();
            $table->string('alasan_keluar')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('files', function (Blueprint $table) {
            $table->dropColumn('nama');
            $table->dropColumn('sekolah');
            $table->dropColumn('tempat_tgl_lahir');
            $table->dropColumn('posisi');
            $table->dropColumn('tgl_join');
            $table->dropColumn('tgl_keluar');
            $table->dropColumn('alasan_keluar');
        });
    }
};
