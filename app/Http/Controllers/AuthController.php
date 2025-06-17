<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // dd($request->all());

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);
            
            session([
                'berhasil_login' => true,
                'id_user' => $user->id,
                'id_role' => $user->id_role,
                'tgl_from' => date('Y-m-01'),
                'tgl_to' => date('Y-m-d'),
            ]);

            $now = date('Y-m-d');
            $cek = date('Y-12-d');

            return redirect('dashboard')->with('sukses', 'Berhasil login');

            if ($now >= $cek) {
                return redirect('/login')->with('gagal', 'Gagal');
            } else {
                return redirect('dashboard');
            }
        } else {
            return redirect('/login')->with('gagal', 'Gagal');
        }
    }

    // public function login(Request $request)
    // {
    //     $user = DB::table('tbl_user')
    //         ->where('email', $request->email)
    //         ->first();

    //     if (Hash::check(@$request->password, @$user->password)) {
    //         $data = DB::table('tbl_user')
    //             ->where('id', $user->id)
    //             ->first();
    //         session([
    //             'berhasil_login' => true,
    //             'id_user' => $data->id,
    //             'id_role' => $data->id_role,
    //             'tgl_from' => date('Y-m-01'),
    //             'tgl_to' => date('Y-m-d'),
    //         ]);

    //         //return redirect('dashboard');
    //         $now = date('Y-m-d');
    //         $cek = date('Y-12-d');
    //         if ($now >= $cek) {
    //             return redirect('/login')->with('gagal', 'Gagal');
    //         } else {
    //             return redirect('dashboard');
    //         }
    //     } else {
    //         return redirect('/login')->with('gagal', 'Gagal');
    //     }
    // }

    public function logout()
    {
        Auth::logout();
        session()->flush();
        return redirect('/login')->with('logout', 'Sukses');
    }
}
