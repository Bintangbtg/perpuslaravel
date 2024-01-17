<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\buku;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class bukucontroller extends Controller
{
    public function getbuku()
    {
        if (!Auth::check()) {
            return response()->json([
                'message' => 'Login Dulu coy!',
            ], 401);
        }
    
        $dt_buku = buku::get();
        return response()->json([
            'books' => $dt_buku,
        ]);
    }

    public function addbuku(Request $req)
{
    if (!Auth::check()) {
        return response()->json([
            'message' => 'Login Dulu coy!',
        ], 401);
    }

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
        if (!Auth::check()) {
            return response()->json([
                'message' => 'Login Dulu coy!',
            ], 401);
        }

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
        if (!Auth::check()) {
            return response()->json([
                'message' => 'Login Dulu coy!',
            ], 401);
        }

        $buku = buku::where('id_buku',$id)->first();
        return Response()->json($buku);

        if (!$buku) {
            return response()->json(['status' => false, 'message' => 'buku tidak ditemukan']);
        }
    }

    public function deletebuku($id)
    {
        if (!Auth::check()) {
            return response()->json([
                'message' => 'Login Dulu coy!',
            ], 401);
        }

        $hapus = buku::where('id_buku',$id)->delete();

        if ($hapus) {
            return response()->json(['status' => true, 'message' => 'Sukses menghapus buku']);
        } else{
            return response()->json(['status' => false, 'message' => 'Gagal menghapus buku']);
        }
    }



    }