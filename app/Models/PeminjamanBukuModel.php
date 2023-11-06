<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeminjamanBukuModel extends Model
{
    use HasFactory;
    protected $table = 'peminjaman_buku';
    protected $primaryKey = 'id_peminjaman_buku';
    public $timestamps = false;
    protected $fillable = [
        'id_siswa','tanggal_pinjam','tanggal_kembali'
    ];
}
