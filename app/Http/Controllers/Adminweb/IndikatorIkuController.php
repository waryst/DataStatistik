<?php

namespace App\Http\Controllers\Adminweb;

use App\Http\Controllers\Controller;
use App\models\DataStatistik;
use App\models\Ikd;
use App\models\IndikatorIku;
use App\models\Tahun;
use App\Traits\GetNavTraits;
use Illuminate\Http\Request;

class IndikatorIkuController extends Controller
{
    use GetNavTraits;

    public function index()
    {

        $data['nav'] =$this->getnav();
        $data['iku']=IndikatorIku::get();
        $data['ikd']=Ikd::get();
        return view('adminweb.master_iku_ikd', $data);
    }
    public function saveindikator(Request $request)
    {
        $validasi=$request->validate([
            'indikator' => 'required',
        ], 
        [
            'indikator.required' => "Indikator Utama Harus di isi",
        ]); 
        IndikatorIku::create([
            'indikator'=>$request->indikator,

        ]);
        alert()->success('Sukses','Data IKU Berhasil Dibuat');
        return response()->json(['url'=> url('indikator')]);

    }
    public function editindikator(Request $request,IndikatorIku $id)
    {
        $validasi=$request->validate([
            'editindikator' => 'required',
        ], 
        [
            'editindikator.required' => "Indikator Daerah Harus di isi",
        ]); 
        $id->update([
            'indikator'=>$request->editindikator,

        ]);
        alert()->success('Sukses','Data IKU Berhasil Diupdate');
        return response()->json(['url'=> url('indikator')]);

    }
    public function hapusindikator(IndikatorIku $id)
    {

        $id->delete();
        return redirect('/indikator')->with('success', 'Proses Hapus data berhasil!');

    }
    public function showindikator(IndikatorIku $id)
    {
        return response()->json(['pencarian_data' => $id]);

    }
    public function data_iku()
    {
        $id_instansi = auth()->user()->instansi_id;
        $data['instansi'] =  auth()->user()->instansi;
        if (auth()->user()->role == 'administrator'){
            $data['data_statistik'] = DataStatistik::where([['validasi', 1],['verifikator','1']])->orderBy('id', 'ASC')->get();
        }
        elseif (auth()->user()->role == 'verifikator' or auth()->user()->role == 'admin'){
            $data['data_statistik'] = DataStatistik::where([['instansi_id', $id_instansi]])->orderBy('id', 'ASC')->get();
        }
        $data['nav'] =$this->getnav();
        $data['tahun']=Tahun::orderBy('tahun', 'ASC')->get();
        $data['iku']=IndikatorIku::where('instansi_id', $id_instansi)->get();
        return view('adminweb.iku', $data);

    }

    
}
