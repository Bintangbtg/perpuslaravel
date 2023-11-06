<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pengembalianBukuModel extends Model
{
    use HasFactory;
    protected $table = 'pengembalian_buku';
    protected $primaryKey = 'id_pengembalian_buku';
    public $timestamps = false;
    protected $fillable = [
        'id_peminjaman_buku','tanggal_pengembalian','denda'
    ];
}
