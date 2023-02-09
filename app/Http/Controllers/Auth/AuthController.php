<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\models\Dashboard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
//use Auth;

class AuthController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        } else {
            return view('login.login');
        }
    }
    public function changePassword()
    {
        $id_instansi = auth()->user()->instansi_id;
        $data['nama_instansi'] = Dashboard::where('id', $id_instansi)->first();

        return view('adminweb\changePassword', $data);
    }
    public function postlogin(Request $request)
    {
        $email = $request->email;
        $password = $request->password;
        if (Auth::attempt(['email' => $email, 'password' => $password])) {

            if (auth()->user()->role == 'administrator'){
                return redirect()->route('verifikasi');
            }
            else{
                return redirect()->route('dashboard');
            }


        } else {
            return redirect()->route('login');
        }
    }
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
