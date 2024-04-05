<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\PeminjamanBukuModel;
use App\Models\detailPeminjamanBukuModel;
use App\Models\pengembalianBukuModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    public function pinjamBuku(Request $req){
        if (!Auth::check()) {
            return response()->json([
                'message' => 'Login Dulu coy!',
            ], 401);
        }

        $validator = Validator::make($req->all(),[
            'id_siswa'=>'required',
            'tanggal_pinjam'=>'required',
            'tanggal_kembali'=>'required'
        ]);
        if($validator->fails()){
            return Response()->json($validator->errors());
        }
        $save = PeminjamanBukuModel::create([
            'id_siswa' => $req->id_siswa,
            'tanggal_pinjam' => $req->tanggal_pinjam,
            'tanggal_kembali' => $req->tanggal_kembali
        ]);
        if($save){
            return Response()->json(['status'=>1]);
        }
        else{
            return Response()->json(['status'=>0]);
        }
    }

    public function getPeminjamanBukuById($id_peminjaman_buku)
{
    $peminjaman = PeminjamanBukuModel::find($id_peminjaman_buku);

    if (!$peminjaman) {
        return response()->json(['message' => 'Data tidak ditemukan'], 404);
    }

    return response()->json($peminjaman);
}

public function updatePeminjamanBuku(Request $request, $id)
    {
        $peminjaman = PeminjamanBukuModel::find($id);

        if (!$peminjaman) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $validator = Validator::make($request->all(), [
            'id_siswa' => 'required',
            'tanggal_pinjam' => 'required',
            'tanggal_kembali' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $peminjaman->id_siswa = $request->id_siswa;
        $peminjaman->tanggal_pinjam = $request->tanggal_pinjam;
        $peminjaman->tanggal_kembali = $request->tanggal_kembali;
        $peminjaman->save();

        return response()->json(['message' => 'Data berhasil diperbarui', 'data' => $peminjaman]);
    }

    public function tambahItem(Request $req,$id){
        if (!Auth::check()) {
            return response()->json([
                'message' => 'Login Dulu coy!',
            ], 401);
        }

        $validator = Validator::make($req->all(),[
            'id_buku'=> 'required',
            'qty'=>'required'
        ]);
        if($validator->fails()){
            return Response()->json($validator->errors());
        }
        $save = detailPeminjamanBukuModel::create([
            'id_peminjaman_buku' => $req->id,
            'id_buku' => $req->id_buku,
            'qty' => $req->qty
        ]);
        if($save){
            return Response()->json(['status'=>1]);
        }
        else{
            return Response()->json(['status'=>0]);
        }
    }

    public function mengembalikanBuku(Request $req)
{
    if (!Auth::check()) {
        return response()->json([
            'message' => 'Login Dulu coy!',
        ], 401);
    }

    $validator = Validator::make($req->all(), [
        'id_peminjaman_buku' => 'required'
    ]);

    if ($validator->fails()) {
        return Response()->json($validator->errors());
    }

    $cek_kembali = pengembalianBukuModel::where('id_peminjaman_buku', $req->id_peminjaman_buku);

    if ($cek_kembali->count() == 0) {
        $dt_kembali = peminjamanBukuModel::where('id_peminjaman_buku', $req->id_peminjaman_buku)->first();
        $tanggal_sekarang = Carbon::now()->format('Y-m-d');
        $tanggal_kembali = new Carbon($dt_kembali->tanggal_kembali);
        $dendaperhari = 1500;

        if (strtotime($tanggal_sekarang) > strtotime($tanggal_kembali)) {
            $jumlah_hari = $tanggal_kembali->diff($tanggal_sekarang)->days;
            $denda = $jumlah_hari * $dendaperhari;
        } else {
            $denda = 0;
        }

        $save = pengembalianBukuModel::create([
            'id_peminjaman_buku' => $req->id_peminjaman_buku,
            'tanggal_pengembalian' => $tanggal_sekarang,
            'denda' => $denda
        ]);

        if ($save) {
            $data['status'] = 1;
            $data['message'] = 'Berhasil dikembalikan';
        } else {
            $data['status'] = 0;
            $data['message'] = 'Pengembalian gagal';
        }
    } else {
        $data = ['status' => 0, 'message' => 'Sudah pernah dikembalikan'];
    }

    return response()->json($data);
}

    public function daftarPinjaman()
    {
        $dt_buku = PeminjamanBukuModel::get();
        return response()->json($dt_buku);
    }

    public function daftarKembali()
    {
        $dt_kembali = pengembalianBukuModel::get();
        return response()->json($dt_kembali);
    }

    // public function daftarPinjamDetail()
    // {
    //     $dt_buku = detailPeminjamanBukuModel::get();
    //     return response()->json($dt_buku);
    // }

    // public function daftarPinjamDetaill($id)
    // {
    //     $dt_buku = detailPeminjamanBukuModel::where('id_peminjaman_buku', $id)->get();
    //     return response()->json($dt_buku);
    // }

    public function daftarPinjamDetail($id)
    {
        $detail = detailPeminjamanBukuModel::where('id_peminjaman_buku', $id)->first();

        if (!$detail) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        return response()->json(['id_buku' => $detail->id_buku]);
    }
}