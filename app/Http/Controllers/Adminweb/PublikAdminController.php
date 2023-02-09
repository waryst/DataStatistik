<?php

namespace App\Http\Controllers\Adminweb;

use CURLFile;
use App\models\Api;
use Ramsey\Uuid\Uuid;
use App\models\Dashboard;
use App\models\DataPublic;
use Illuminate\Support\Str;
use App\Traits\GetNavTraits;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class PublikAdminController extends Controller
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
        $id_instansi = auth()->user()->instansi_id;
        $data['instansi'] =  auth()->user()->instansi;
        $data['data_public'] = DataPublic::where('instansi_id', $id_instansi)->orderBy('id', 'DESC')->get();
        $data['nav'] =$this->getnav();
        return view('adminweb.publik', $data);
    }
    public function store(Request $request){
        $request->validate([
            'title' => 'required',
            'deskripsi' =>'required',
            'cover' => 'required|image|mimes:jpg,png,jpeg|max:2048',
            'file' => 'required|mimes:pdf|max:15360'
        ],
        [
            'title.required' => 'Judul Data Harus Di Isi',
            'deskripsi.required' => 'Deskripsi Data Harus Di Isi',
            'cover.max' => 'Ukuran File Maksimal 2 Mbps',
            'file.max' => 'Ukuran File Maksimal 15 Mbps',
        ]);
        $id_instansi = auth()->user()->instansi_id;
        $pencarian_data = Dashboard::find($id_instansi);;
        $owner_org= $pencarian_data->id_ckan;
        $uuid=Uuid::uuid4()->getHex().time();

        $post = [
            'owner_org' => $owner_org,
            'name' => Str::slug($request->title, '-').time(),
            'title'   => $request->title,
            'notes'=>$request->deskripsi,
            'author'=>$pencarian_data->description,
            'license_id'=>'License not specified',
            'private'=>false,
        ]; 
        $result=self::get_curl('package_create',$post);
        if($result['success']==true){
            $cover = $request->file('cover');
            $covername = Str::slug($request->title, '-')."-".time(). "." . $request->file('cover')->getClientOriginalExtension();      
            $cover->storeAs('data/'.auth()->user()->instansi_id.'/'.'publikasi/', $covername);
            $file = $request->file('file');
            $filename = Str::slug($request->title, '-')."-".time(). "." . $request->file('file')->getClientOriginalExtension();      
            $file->storeAs('data/'.auth()->user()->instansi_id.'/', $filename);
            $data = new DataPublic();
            $data->id=$uuid;
            $data->id_package =  $result['result']['id'];
            $data->title = $request->title;
            $data->description = $request->deskripsi;
            $data->instansi_id = auth()->user()->instansi_id;
            $data->file = $filename;
            $data->cover = $covername;
            $data->type = $request->file('file')->getClientOriginalExtension();
            $data->user_id = auth()->user()->id;
            $data->save();

            $cFile = new CURLFile(storage_path('app/public/data/'.auth()->user()->instansi_id.'/'.$filename));
            $post = [
                'package_id' => $result['result']['id'],
                'name' => $request->title,
                'upload'=>$cFile,
            ]; 
            $result=self::get_curl('resource_create',$post);
            if($result['success']==true)
            {
                $pencarian_data = DataPublic::find($uuid);;
                $pencarian_data->id_resource =  $result['result']['id'];
                $pencarian_data->save();
                alert()->success('Sukses','Data Berhasil Disimpan');
                return response()->json(['url'=> route('data.publikasi')]);
            }              
        }
    }
    public function show($id){
        $pencarian_data= DataPublic::find($id);
            return response()->json(['pencarian_data' => $pencarian_data]);
    }  
    public function edit(Request $request, $id)
    {
        $pencarian_data = DataPublic::find($id);
        $id_package= $pencarian_data->id_package;
        if($request->edit_file!=null and $request->editcover!=null)
        {
            $request->validate([
                'edit_title' => 'required',
                'description' =>'required',
                'edit_file' => 'mimes:pdf|max:5120',
                'editcover' => 'image|mimes:jpg,png,jpeg|max:2048',
            ],
            [
                'edit_title.required' => 'Judul Data Harus Di Isi',
                'description.required' => 'Deskripsi Data Harus Di Isi',
                'edit_file.max' => 'Ukuran File Maksimal 5 Mbps',
                'edit_file.mimes' => 'File harus bertipe: pdf',
                'editcover.max' => 'Ukuran File Maksimal 2 Mbps',
                'editcover.mimes' => 'Gambar Harus Bertipe jpg,png,jpeg',
                'editcover.image' => 'File Harus Bertipe Gambar',
            ]); 
        }
        elseif($request->edit_file!=null)
        {
            $request->validate([
                'edit_title' => 'required',
                'description' =>'required',
                'edit_file' => 'mimes:pdf|max:5120',

            ],
            [
                'edit_title.required' => 'Judul Data Harus Di Isi',
                'description.required' => 'Deskripsi Data Harus Di Isi',
                'edit_file.max' => 'Ukuran File Maksimal 5 Mbps',
                'edit_file.mimes' => 'File harus bertipe: pdf',
            ]); 
        }
        elseif($request->editcover!=null)
        {
            $request->validate([
                'edit_title' => 'required',
                'description' =>'required',
                'editcover' => 'image|mimes:jpg,png,jpeg|max:2048',
            ],
            [
                'edit_title.required' => 'Judul Data Harus Di Isi',
                'description.required' => 'Deskripsi Data Harus Di Isi',
                'editcover.max' => 'Ukuran File Maksimal 2 Mbps',
                'editcover.mimes' => 'Gambar Harus Bertipe jpg,png,jpeg',
                'editcover.image' => 'File Harus Bertipe Gambar',
            ]); 
        }
        else{
            $request->validate([
                'edit_title' => 'required',
                'description' =>'required',
            ],
            [
                'edit_title.required' => 'Judul Data Harus Di Isi',
                'description.required' => 'Deskripsi Data Harus Di Isi',
            ]); 
        }  
        if ($request->hasFile('edit_file')) {
            $nama_file =Str::slug($request->edit_title, '-')."-".time(). "." . $request->file('edit_file')->getClientOriginalExtension();
            Storage::delete('data/'.auth()->user()->instansi_id.'/'.$pencarian_data->file);
            $request->file('edit_file')->storeAs('data/'.auth()->user()->instansi_id,$nama_file);
            $post = [
                'id' => $id_package,
            ]; 
            $result=self::get_curl('dataset_purge',$post);
            if($result['success']==true){
                $id_instansi = auth()->user()->instansi_id;
                $pencarian_idckan = Dashboard::find($id_instansi);;
                $owner_org= $pencarian_idckan->id_ckan;        
                $post = [
                    'owner_org' => $owner_org,
                    'name' => Str::slug($request->title, '-').time(),
                    'title'   => $request->edit_title,
                    'notes'=>$request->description,
                    'author'=>$pencarian_data->description,
                    'license_id'=>'License not specified',
                    'private'=>false,
                ]; 
                $result=self::get_curl('package_create',$post);
                if($result['success']==true){
                    if ($request->hasFile('editcover')) {
                        Storage::delete('data/'.auth()->user()->instansi_id.'/'.'publikasi/'.$pencarian_data->cover);
                        $cover = $request->file('editcover');
                        $covername = Str::slug($request->edit_title, '-')."-".time(). "." . $request->file('editcover')->getClientOriginalExtension();      
                        $cover->storeAs('data/'.auth()->user()->instansi_id.'/'.'publikasi/', $covername);
                        $pencarian_data->cover = $covername;
                    }
                    $file = $request->file('edit_file');
                    $filename = Str::slug($request->title, '-')."-".time(). "." . $request->file('edit_file')->getClientOriginalExtension();      
                    $file->storeAs('data/'.auth()->user()->instansi_id.'/', $filename);
                    $pencarian_data->id_package =  $result['result']['id'];
                    $pencarian_data->title = $request->edit_title;
                    $pencarian_data->description = $request->description;
                    $pencarian_data->instansi_id = auth()->user()->instansi_id;
                    $pencarian_data->file = $filename;
                    $pencarian_data->cover = $covername;
                    $pencarian_data->type = $request->file('edit_file')->getClientOriginalExtension();
                    $pencarian_data->user_id = auth()->user()->id;
                    $pencarian_data->save();
                    $cFile = new CURLFile(storage_path('app/public/data/'.auth()->user()->instansi_id.'/'.$filename));
                    $post = [
                        'package_id' => $result['result']['id'],
                        'name' => $request->edit_title,
                        'upload'=>$cFile,
                    ]; 
                    $result=self::get_curl('resource_create',$post);
                    if($result['success']==true)
                    {
                        $pencarian_data->id_resource =  $result['result']['id'];
                        $pencarian_data->save();
                        alert()->success('Sukses','Data Berhasil Disimpan');
                        return response()->json(['url'=> route('data.publikasi')]);
                    } 
    
                }
            }
        }
        else{

            $post = [
                'id' => $id_package,
                'title' => $request->edit_title,
                'notes'   => $request->description,
            ];
            $result=self::get_curl('package_patch',$post);
            if($result['success']==true){
                if ($request->hasFile('editcover')) {

                    Storage::delete('data/'.auth()->user()->instansi_id.'/'.'publikasi/'.$pencarian_data->cover);
                    $cover = $request->file('editcover');
                    $covername = Str::slug($request->edit_title, '-')."-".time(). "." . $request->file('editcover')->getClientOriginalExtension();      
                    $cover->storeAs('data/'.auth()->user()->instansi_id.'/'.'publikasi/', $covername);
                    $pencarian_data->cover = $covername;
                }
                $pencarian_data->title = $request->edit_title;
                $pencarian_data->description = $request->description;
                $pencarian_data->user_id = auth()->user()->id;
                $pencarian_data->save();
                alert()->success('Sukses','Data Berhasil Diupdate');
                return response()->json(['url'=> url('data_publikasi')]);        
            }
        }
    }
    public function hapus($id){
        $pencarian_data = DataPublic::find($id);
        $id_package= $pencarian_data->id_package;
        $post = [
            'id' => $id_package,
        ]; 
        $result=self::get_curl('dataset_purge',$post);
        if($result['success']==true){
            Storage::delete('data/'.$pencarian_data->instansi_id.'/'.$pencarian_data->file);
            Storage::delete('data/'.$pencarian_data->instansi_id.'/publikasi'.'/'.$pencarian_data->cover);
            $pencarian_data->delete();
            return redirect('/data_publikasi')->with('success', 'Proses Hapus data sudah berhasil!');
        }
    }
}
