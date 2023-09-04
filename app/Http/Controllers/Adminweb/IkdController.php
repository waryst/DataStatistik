<?php

namespace App\Http\Controllers\Adminweb;

use App\Http\Controllers\Controller;
use App\models\Ikd;
use App\Traits\GetNavTraits;
use Illuminate\Http\Request;

class IkdController extends Controller
{
    public function saveikd(Request $request)
    {
        $validasi=$request->validate([
            'ikd' => 'required',
        ], 
        [
            'ikd.required' => "Indikator Utama Harus di isi",
        ]); 
        Ikd::create([
            'indikator'=>$request->ikd,

        ]);
        alert()->success('Sukses','Data IKD Berhasil Dibuat');
        return response()->json(['url'=> url('indikator')]);

    }
    public function showindikator(Ikd $id)
    {
        return response()->json(['pencarian_data' => $id]);

    }
    public function editindikator(Request $request,Ikd $id)
    {
        $validasi=$request->validate([
            'editikd' => 'required',
        ], 
        [
            'editikd.required' => "Indikator Daerah Harus di isi",
        ]); 
        $id->update([
            'indikator'=>$request->editikd,

        ]);
        alert()->success('Sukses','Data IKD Berhasil Diupdate');
        return response()->json(['url'=> url('indikator')]);

    }
    public function hapusindikator(Ikd $id)
    {

        $id->delete();
        return redirect('/indikator')->with('success', 'Proses Hapus data berhasil!');

    }
}
