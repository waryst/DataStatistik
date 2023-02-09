<?php

namespace App\Http\Controllers\Auth;


use App\Traits\GetNavTraits;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UpdatePasswordRequest;

class PasswordController extends Controller
{
    use GetNavTraits;

    public function edit()
    {
        $data['instansi'] =  auth()->user()->instansi;
        $data['nav'] =$this->getnav();
        return view('adminweb.changePassword', $data);
    }
    /**
     * @param UpdatePasswordRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdatePasswordRequest $request)
    {
        $request->user()->update([
            'password' => Hash::make($request->get('password'))
        ]);

        return redirect()->route('dashboard')->with('success', 'Proses Update Password sudah berhasil!');;
    }
}
