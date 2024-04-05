<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class apa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create buku table
        Schema::create('buku', function (Blueprint $table) {
            $table->increments('id_buku');
            $table->longBlob('foto')->nullable();
            $table->string('nama_buku', 100);
            $table->string('deskripsi', 10000);
            $table->timestamps();
        });

        // Create detail_peminjaman_buku table
        Schema::create('detail_peminjaman_buku', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_peminjaman_buku')->unsigned();
            $table->integer('id_buku')->unsigned();
            $table->integer('qty');
            $table->foreign('id_peminjaman_buku')->references('id_peminjaman_buku')->on('peminjaman_buku');
            $table->foreign('id_buku')->references('id_buku')->on('buku');
        });

        // Create failed_jobs table
        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uuid');
            $table->text('connection');
            $table->text('queue');
            $table->longText('payload');
            $table->longText('exception');
            $table->timestamp('failed_at')->useCurrent();
        });

        // Create kelas table
        Schema::create('kelas', function (Blueprint $table) {
            $table->increments('id_kelas');
            $table->string('nama_kelas', 20);
            $table->string('kelompok', 20);
            $table->string('Angkatan', 30);
        });

        // Create migrations table
        Schema::create('migrations', function (Blueprint $table) {
            $table->unsignedInteger('id');
            $table->string('migration');
            $table->integer('batch');
        });

        // Create password_reset_tokens table
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email');
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        // Create peminjaman_buku table
        Schema::create('peminjaman_buku', function (Blueprint $table) {
            $table->increments('id_peminjaman_buku');
            $table->integer('id_siswa');
            $table->date('tanggal_pinjam');
            $table->date('tanggal_kembali');
        });

        // Create pengembalian_buku table
        Schema::create('pengembalian_buku', function (Blueprint $table) {
            $table->increments('id_pengembalian_buku');
            $table->integer('id_peminjaman_buku');
            $table->date('tanggal_pengembalian');
            $table->integer('denda');
        });

        // Create personal_access_tokens table
        Schema::create('personal_access_tokens', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tokenable_type');
            $table->unsignedBigInteger('tokenable_id');
            $table->string('name');
            $table->string('token', 64);
            $table->text('abilities')->nullable();
            $table->timestamp('last_used_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });

        // Create siswa table
        Schema::create('siswa', function (Blueprint $table) {
            $table->increments('id_siswa');
            $table->string('nama_siswa', 100);
            $table->date('tanggal_lahir');
            $table->enum('gender', ['L', 'P']);
            $table->text('alamat');
            $table->string('username')->nullable();
            $table->string('password')->nullable();
            $table->integer('id_kelas')->nullable();
        });

        // Create users table
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('remember_token', 100)->nullable();
            $table->timestamps();
            $table->string('api_token')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Drop tables in reverse order
        Schema::dropIfExists('users');
        Schema::dropIfExists('siswa');
        Schema::dropIfExists('personal_access_tokens');
        Schema::dropIfExists('pengembalian_buku');
        Schema::dropIfExists('peminjaman_buku');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('migrations');
        Schema::dropIfExists('kelas');
        Schema::dropIfExists('failed_jobs');
        Schema::dropIfExists('detail_peminjaman_buku');
        Schema::dropIfExists('buku');
    }
}