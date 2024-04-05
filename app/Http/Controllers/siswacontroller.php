<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\siswa;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class siswacontroller extends Controller
{
    public function getsiswa()
    {
        if (!Auth::check()) {
            return response()->json([
                'message' => 'Login Dulu coy!',
            ], 401);
        }

        $dt_siswa = siswa::get();
        return response()->json($dt_siswa);
    }

    public function addsiswa(Request $req)
    {
         if (!Auth::check()) {
             return response()->json([
                 'message' => 'Login Dulu coy!',
             ], 401);
         }

        $validator = Validator::make($req->all(), [
            'nama_siswa' => 'required',
            'tanggal_lahir' => 'required',
            'gender' => 'required',
            'alamat' => 'required',
            'username' => 'required',
            'password' => 'required',
            'id_kelas' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson());
        }

        $save = siswa::create([
            'nama_siswa' => $req->get('nama_siswa'),
            'tanggal_lahir' => $req->get('tanggal_lahir'),
            'gender' => $req->get('gender'),
            'alamat' => $req->get('alamat'),
            'username' => $req->get('username'),
            'password' => $req->get('password'),
            'id_kelas' => $req->get('id_kelas')
        ]);

        if ($save) {
            return response()->json(['status' => true, 'message' => 'Sukses menambahkan siswa bro']);
        } else {
            return response()->json(['status' => false, 'message' => 'Gagal menambahkan siswa bro']);
        }
    }

    public function updatesiswa(Request $req, $id)
    {
         if (!Auth::check()) {
             return response()->json([
                 'message' => 'Login Dulu coy!',
             ], 401);
         }

        $validator = Validator::make($req->all(), [
            'nama_siswa' => 'required',
            'tanggal_lahir' => 'required',
            'gender' => 'required',
            'alamat' => 'required',
            'username' => 'required',
            'password' => 'required',
            'id_kelas' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Gagal Masbro Validatornya']);
        }

        $ubah = siswa::where('id_siswa', $id)->update([
            'nama_siswa' => $req->get('nama_siswa'),
            'tanggal_lahir' => $req->get('tanggal_lahir'),
            'gender' => $req->get('gender'),
            'alamat' => $req->get('alamat'),
            'username' => $req->get('username'),
            'password' => $req->get('password'),
            'id_kelas' => $req->get('id_kelas')
        ]);
        
        if ($ubah) {
            return response()->json(['status' => true, 'message' => 'Sukses Masbro']);
        } else{
            return response()->json(['status' => false, 'message' => 'Gagal Masbro']);
        }   
        
        return response()->json(['status' => false, 'message' => 'Tidak ada perubahan data siswa']);
    }

    public function getsiswaById($id)
    {
         if (!Auth::check()) {
             return response()->json([
                 'message' => 'Login Dulu coy!',
             ], 401);
         }

        $siswa = siswa::where('id_siswa',$id)->first();
        return Response()->json($siswa);

        if (!$siswa) {
            return response()->json(['status' => false, 'message' => 'Siswa tidak ditemukan']);
        }
    }

    public function deletesiswa($id)
    {
         if (!Auth::check()) {
             return response()->json([
                 'message' => 'Login Dulu coy!',
             ], 401);
         }

        $hapus = siswa::where('id_siswa',$id)->delete();

        if ($hapus) {
            return response()->json(['status' => true, 'message' => 'Sukses menghapus siswa']);
        } else{
            return response()->json(['status' => false, 'message' => 'Gagal menghapus siswa']);
        }
    }



    }