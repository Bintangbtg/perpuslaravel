<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\kelas;
use Illuminate\Support\Facades\Validator;

class kelascontroller extends Controller
{
    public function getkelas()
    {
        $dt_kelas = kelas::get();
        return response()->json($dt_kelas);
    }

    public function addkelas(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'nama_kelas' => 'required',
            'kelompok' => 'required',
            'angkatan' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson());
        }

        $save = kelas::create([
            'nama_kelas' => $req->get('nama_kelas'),
            'kelompok' => $req->get('kelompok'),
            'angkatan' => $req->get('angkatan')
        ]);

        if ($save) {
            return response()->json(['status' => true, 'message' => 'Sukses menambahkan kelas bro']);
        } else {
            return response()->json(['status' => false, 'message' => 'Gagal menambahkan kelas bro']);
        }
    }

    public function updatekelas(Request $req, $id)
    {
        $validator = Validator::make($req->all(), [
            'nama_kelas' => 'required',
            'kelompok' => 'required',
            'angkatan' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Gagal Masbro Validatornya']);
        }

        $ubah = kelas::where('id_kelas', $id)->update([
            'nama_kelas' => $req->get('nama_kelas'),
            'kelompok' => $req->get('kelompok'),
            'angkatan' => $req->get('angkatan')
        ]);
        
        if ($ubah) {
            return response()->json(['status' => true, 'message' => 'Sukses Masbro']);
        } else{
            return response()->json(['status' => false, 'message' => 'Gagal Masbro']);
        }   
        
    }

    public function getkelasById($id)
    {
        $kelas = kelas::where('id_kelas',$id)->first();
        return Response()->json($kelas);

        if (!$kelas) {
            return response()->json(['status' => false, 'message' => 'kelas tidak ditemukan']);
        }
    }

    public function deletekelas($id)
    {

        $hapus = kelas::where('id_kelas',$id)->delete();

        if ($hapus) {
            return response()->json(['status' => true, 'message' => 'Sukses menghapus kelas']);
        } else{
            return response()->json(['status' => false, 'message' => 'Gagal menghapus kelas']);
        }
    }
}
