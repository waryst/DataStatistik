<?php

namespace App\Http\Controllers\Adminweb;

use App\User;
use App\models\Api;
use Ramsey\Uuid\Uuid;
use App\models\Dashboard;
use Illuminate\Support\Str;
use App\Traits\GetNavTraits;
use Illuminate\Http\Request;
use App\models\DataStatistik;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class InstansiAdminController extends Controller
{
    use GetNavTraits;
    public function get_curl($url,$post=null){
        $api=Api::first(); 
        $curl=curl_init();
        if ($post!=null) {
            curl_setopt_array($curl, array(
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_TIMEOUT => 30000,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_URL => $api->url.$url,
                CURLOPT_HTTPHEADER => array(
                  'Authorization:'.$api->token,
                ),
            ));
        }
        else{
            curl_setopt_array($curl, array(
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_TIMEOUT => 30000,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_URL => $api->url.$url,
                CURLOPT_HTTPHEADER => array(
                  'Authorization:'.$api->token,
                ),
            ));
        }      
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
        $result= curl_exec($curl);
        curl_close($curl);
        return json_decode($result,true);
    }
    public function index(){
        $data['instansi'] =  auth()->user()->instansi;
        $data['nav'] =$this->getnav();
        return view('adminweb.profil', $data);
    }

    public function edit(Request $request){
        $pencarian_data = Dashboard::find(auth()->user()->instansi_id);
       if ($request->hasFile('instansi')) {
            $logo_file = auth()->user()->instansi_id . "-" . $pencarian_data->name . "." . $request->file('instansi')->getClientOriginalExtension();
            
            $file = $request->file('instansi');
            $file->storeAs('data/'.auth()->user()->instansi_id, $logo_file);
    

            $pencarian_data->logo = $logo_file;
            $pencarian_data->save();
        }
        if ($request->hasFile('kepala_dinas')) {
            $poto_kepala_dinas = auth()->user()->instansi_id . "-kepala-" . $pencarian_data->name . "-" . time(). "." . $request->file('kepala_dinas')->getClientOriginalExtension();
            
            $file = $request->file('kepala_dinas');
            $file->storeAs('data/'.auth()->user()->instansi_id, $poto_kepala_dinas);

            
            $pencarian_data->foto_kadin = $poto_kepala_dinas;
            $pencarian_data->save();
        }
        $pencarian_data->alamat = $request->alamat;
        $pencarian_data->map = $request->peta;
        $pencarian_data->nama_kadin = $request->kepala;
        $pencarian_data->nip = $request->nip;
        $pencarian_data->pns = $request->pns;
        $pencarian_data->kontrak = $request->kontrak;
        $pencarian_data->save();
        return redirect('/profil')->with('success', 'Proses Update data sudah berhasil!');

    }
    public function data_instansi()
    {
        $data['nav'] =$this->getnav();
        $data['instansi'] = Dashboard::all();
        return view('adminweb.instansi', $data);
    }
    public function input_instansi(Request $request)
    {
        $cek= Dashboard::where([['name', $request->judul]])->count();
        if( $cek==0)
        {       
            $data = new Dashboard();
                $data->name = $request->judul;
                $data->description = $request->deskripsi;

            $post = [
                'name' => Str::slug($request->judul, '-') ,
                'title'   => $request->deskripsi,
                'state'=>'active',
            ]; 
            $result=self::get_curl('organization_create',$post);
            if($result['success']==true){
                $data->id_ckan = $result['result']['id'];
                $data->save();
                $data['nav'] =$this->getnav();      
                $data['instansi'] = Dashboard::all();
                return redirect('/data_instansi')->with('success', 'Proses Input Instansi sudah berhasil!');
            } 
        } 
    }
    public function edit_instansi(Request $request, $id)
    {
        $pencarian_data = Dashboard::find($id);
        $post = [
            'id'=> $pencarian_data->id_ckan,
            'name'=> strtolower($request->title),
            'title'   => $request->description,
            'state'=>'active',
        ]; 
        $result=self::get_curl('organization_update',$post);
        if($result['success']==true){
            $pencarian_data->name = strtolower($request->title);
            $pencarian_data->description = $request->description;
            $pencarian_data->save();
            return redirect('/data_instansi')->with('success', 'Proses Update data sudah berhasil!');
        }        
    }
    public function user_instansi($name)
    {
      $data['instansi'] =  auth()->user()->instansi;
      $data['nav'] =$this->getnav();
      $data['cek_id'] = Dashboard::where('name', $name)->first();
        if (auth()->user()->role == 'administrator'){
            $data['users'] = User::whereNotIn('role', ['administrator'])->where('instansi_id',$data['cek_id']->id)->get();
        }
        elseif (auth()->user()->role == 'verifikator'){            
            $data['users'] = User::where('role', 'admin')->where('instansi_id',auth()->user()->instansi_id)->get();

        }
        return view('adminweb/user_instansi', $data);
    }
    public function add_user_instansi(Request $request, $id)
    {
        $cek_instansi = Dashboard::where('id', $id)->first();
        if($request->judul!=null and $request->deskripsi!=null)
        {
            $password = Hash::make('1234567');
            $data = new User();
            $data->id=Uuid::uuid4()->getHex().time();
            $data->name = $request->judul;
            $data->email = $request->deskripsi;
            $data->password = $password;
            $data->instansi_id = $id;
            
            if (auth()->user()->role == 'administrator' and $request->hak=='on' ){
                $data->role = 'verifikator';
            }
            else{
                $data->role = 'admin';
            }
            $data->save();
            return redirect("/data_instansi/daftar_user/$cek_instansi->name")->with('success', 'Proses Tambah User sudah berhasil!');    
        }
        else{
            return redirect("/data_instansi/daftar_user/$cek_instansi->name")->with('warning', 'Lengkapi Isian Data');    
        }
    }
    public function edit_user_instansi(Request $request, $id)
    {
        $data = User::find($id);
        $cek_instansi = $data->instansi->name;
        if($request->title!=null and $request->description!=null)
        {
        $data = User::find($id);
        $data->name = $request->title;
        $data->email = $request->description;
        if (auth()->user()->role == 'administrator' and $request->hak=='on' ){
            $data->role = 'verifikator';
        }
        else{
            $data->role = 'admin';
        }
        $data->save();
        return redirect("/data_instansi/daftar_user/$cek_instansi")->with('success', 'Proses Update User sudah berhasil!');
        }
        else{
            return redirect("/data_instansi/daftar_user/$cek_instansi")->with('warning', 'Lengkapi Isian Data!');

        }
    }
    public function reset_user_instansi($id)
    {
        $password = Hash::make('1234567');
        $data = User::find($id);
        $data->password = $password;
        $data->save();
        $cek_instansi = Dashboard::where('id', $data->instansi_id)->first();
        return redirect("/data_instansi/daftar_user/$cek_instansi->name")->with('success', 'Proses Reset Password sudah berhasil. Password menjadi 1234567');
    }
    public function hapus_user_instansi($id)
    {
        $data = User::find($id);
        $data->delete();
        $cek_instansi = Dashboard::where('id', $data->instansi_id)->first();
        return redirect("/data_instansi/daftar_user/$cek_instansi->name")->with('success', 'Proses Hapus User sudah berhasil!!');
    }
        public function data_statistik($name)
    {
        $data['nav'] =$this->getnav();
        $data['cek_id'] = Dashboard::where('name', $name)->first();
        $data['data_statistik'] = DataStatistik::where('instansi_id', $data['cek_id']->id)->orderBy('id', 'desc')->get();
        return view('adminweb.data_statistik', $data);
    }    
    public function add_statistik(Request $request, $id)
    {
        if ($request->hasFile('file')) {
            $nama_file = $id . "-" . auth()->user()->id . "-" . time() . "-" . str_replace([" ","/"], "_", $request->judul) . "." . $request->file('file')->getClientOriginalExtension();
            $request->file('file')->move('Data/' . $id, $nama_file, $request->file('file')->getClientOriginalName());
            if (file_exists('Data/' . $id . "/" . $nama_file)) {
                $data = new DataStatistik();
                $data->title = $request->judul;
                $data->description = $request->deskripsi;
                $data->instansi_id = $id;
                $data->file = $nama_file;
                $data->status=1;
                $data->user_id = auth()->user()->id;
                $data->save();
            }
        }
        $cek_instansi = Dashboard::where('id', $id)->first();
        return redirect("/data_instansi/data_statistik/$cek_instansi->name")->with('success', 'Proses Input data sudah berhasil!');
    }
    public function edit_statistik(Request $request, $id)
    {
        $pencarian_data = DataStatistik::find($id);
        if ($request->hasFile('file')) {
            $destinationPath = "Data/" . $pencarian_data->instansi_id;
@unlink($destinationPath . "/" . $pencarian_data->file);
            $nama_file = $pencarian_data->instansi_id . "-" . auth()->user()->id . "-" . time() . "-" . str_replace(" ", "_", $request->title) . "." . $request->file('file')->getClientOriginalExtension();
            $request->file('file')->move('Data/' . $pencarian_data->instansi_id, $nama_file, $request->file('file')->getClientOriginalName());
            if (file_exists('Data/') . $pencarian_data->instansi_id . "/" . $nama_file) {
                $pencarian_data->title = $request->title;
                $pencarian_data->description = $request->description;
                $pencarian_data->file = $nama_file;
                $pencarian_data->user_id = auth()->user()->id;
                $pencarian_data->save();
            }
        } else {
            $pencarian_data->title = $request->title;
            $pencarian_data->description = $request->description;
            $pencarian_data->instansi_id = $pencarian_data->instansi_id;
            $pencarian_data->user_id = auth()->user()->id;
            $pencarian_data->save();
        }
        $cek_instansi = Dashboard::where('id', $pencarian_data->instansi_id)->first();
        return redirect("/data_instansi/data_statistik/$cek_instansi->name")->with('success', 'Proses Update data sudah berhasil!');
    }
     public function del_statistik($id)
    {
        $pencarian_data = DataStatistik::find($id);
        $destinationPath = "Data/" . $pencarian_data->instansi_id;
@unlink($destinationPath . "/" . $pencarian_data->file);
        $pencarian_data->delete();
        $cek_instansi = Dashboard::where('id', $pencarian_data->instansi_id)->first();
        return redirect("/data_instansi/data_statistik/$cek_instansi->name")->with('success', 'Proses Hapus data sudah berhasil!');

    }
    public function verifikasi()
    {
        if(auth()->user()->role == 'verifikator'){
            $id_instansi = auth()->user()->instansi_id;
            $data['hasil']=DataStatistik::where('instansi_id', $id_instansi)->whereIN('verifikator',[0,3])->orderBy('id', 'ASC')->get();
            $data['instansi'] =  auth()->user()->instansi;
            $data['nav'] =$this->getnav();
            return view('adminweb.verifikasi', $data);
        }
        elseif (auth()->user()->role == 'administrator')
        {
            $id_instansi = auth()->user()->instansi_id;
            $data['instansi'] =  auth()->user()->instansi;
            $data['nav'] =$this->getnav();
            $data['hasil']=DataStatistik::where('verifikator',1)->whereIN('validasi',[0,3])->orderBy('id', 'DESC')->get();

            return view('adminweb.verifikasi', $data);
        }

    }

}
