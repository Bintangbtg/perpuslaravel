<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\buku;
use Illuminate\Support\Facades\Validator;

class bukucontroller extends Controller
{
    public function getbuku()
    {
        $dt_buku = buku::get();
        return response()->json($dt_buku);
    }

    public function addbuku(Request $req)
{
    $validator = Validator::make($req->all(), [
        'foto' => 'required|image',
        'nama_buku' => 'required',
        'deskripsi' => 'required'
    ]);

    if ($validator->fails()) {
        return response()->json($validator->errors()->toJson());
    }

    if ($req->hasFile('foto')) {
        $file = $req->file('foto');
        $fileName = $file->getClientOriginalName();

        $file->move(public_path('uploads'), $fileName);

        $save = buku::create([
            'foto' => $fileName,
            'nama_buku' => $req->get('nama_buku'),
            'deskripsi' => $req->get('deskripsi'),
        ]);
        
        return response()->json(['message' => 'Buku berhasil ditambahkan.']);
        }

        return response()->json(['message' => 'Gagal mengunggah file foto.']);

        if ($save) {
            return response()->json(['status' => true, 'message' => 'Sukses menambahkan buku bro']);
        } else {
            return response()->json(['status' => false, 'message' => 'Gagal menambahkan buku bro']);
        }
    } 

    public function updatebuku(Request $req, $id)
    {
        $validator = Validator::make($req->all(), [
            'foto' => 'required',
            'nama_buku' => 'required',
            'deskripsi' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Gagal Masbro Validatornya']);
        }

        $ubah = buku::where('id_buku', $id)->update([
            'foto' => $req->get('foto'),
            'nama_buku' => $req->get('nama_buku'),
            'deskripsi' => $req->get('deskripsi'),
        ]);
        
        if ($ubah) {
            return response()->json(['status' => true, 'message' => 'Sukses Masbro']);
        } else{
            return response()->json(['status' => false, 'message' => 'Gagal Masbro']);
        }   
        
        return response()->json(['status' => false, 'message' => 'Tidak ada perubahan data buku']);
    }

    public function getbukuById($id)
    {
        $buku = buku::where('id_buku',$id)->first();
        return Response()->json($buku);

        if (!$buku) {
            return response()->json(['status' => false, 'message' => 'buku tidak ditemukan']);
        }
    }

    public function deletebuku($id)
    {

        $hapus = buku::where('id_buku',$id)->delete();

        if ($hapus) {
            return response()->json(['status' => true, 'message' => 'Sukses menghapus buku']);
        } else{
            return response()->json(['status' => false, 'message' => 'Gagal menghapus buku']);
        }
    }



    }