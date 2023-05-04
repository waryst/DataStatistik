<?php

namespace App\Http\Controllers\Adminweb;

use CURLFile;
use App\models\Api;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Str;
use App\Traits\GetNavTraits;
use Illuminate\Http\Request;
use App\models\DataStatistik;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class DashboardAdminController extends Controller
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
    public function index()
    {
        $id_instansi = auth()->user()->instansi_id;
        $data['instansi'] =  auth()->user()->instansi;
        $data['verifieddata'] = DataStatistik::verifiedData($id_instansi)->count();        
        $data['unverifieddata'] = DataStatistik::unverifiedData($id_instansi)->count();        
        $data['nav'] =$this->getnav();
        return view('adminweb.home', $data);
    }
    public function data_statistik()
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
        return view('adminweb.excel', $data);
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'deskripsi' =>'required',
            'file' => 'required|mimes:csv,txt,xlsx,xls,pdf|max:5120'
        ],
        [
            'title.required' => 'Judul Data Harus Di Isi',
            'deskripsi.required' => 'Deskripsi Data Harus Di Isi',
            'file.max' => 'Ukuran File Maksimal 5 Mbps',
        ]);
        $file = $request->file('file');
        $filename = Str::slug($request->title, '-')."-".time(). "." . $request->file('file')->getClientOriginalExtension();      
        $file->storeAs('data/'.auth()->user()->instansi_id, $filename);
        $data = new DataStatistik();
        $data->id=Uuid::uuid4()->getHex().time();
        $data->title = $request->title;
        $data->description = $request->deskripsi;
        $data->instansi_id = auth()->user()->instansi_id;
        if (auth()->user()->role == 'verifikator'){
            $data->verifikator = 1;
        }

        $data->file = $filename;
        $data->catatan = '';
        $data->note = '';
        $data->id_package = '';
        $data->id_resource = '';
        $data->type = $request->file('file')->getClientOriginalExtension();
        $data->status=$request->status;
        $data->user_id = auth()->user()->id;
        $data->save();
 
        alert()->success('Sukses','Data Berhasil Disimpan');
        return response()->json(['url'=> route('data.statistik')]);

    }
    public function show($id){
        $pencarian_data= DataStatistik::find($id);
        if (auth()->user()->role == 'administrator'){
            $catatan=$pencarian_data['note'];
            return response()->json(['pencarian_data' => $pencarian_data,'catatan'=>$catatan]);
        }
        elseif (auth()->user()->role == 'verifikator' or auth()->user()->role == 'admin' ){
                $catatan=$pencarian_data['catatan'];
                return response()->json(['pencarian_data' => $pencarian_data,'catatan'=>$catatan]);
        }
    }   
    public function edit(Request $request, $id)
    {
        $pencarian_data = DataStatistik::find($id);
        $id_package= $pencarian_data->id_package;
        if($request->show=='show'){
            if( $pencarian_data->validasi==1){
                $post = [
                    'id' => $id_package,
                    'private'=>'true',
                ];
                $result=self::get_curl('package_patch',$post);
                if($result['success']==true){
                    $pencarian_data->status= 0;
                    $pencarian_data->timestamps = false;
                    $pencarian_data->save();
                    return redirect('/statistik')->with('success', 'Data Telah Di Private!');
                }
            }
            else{
                
                if(($pencarian_data->verifikator==2 or $pencarian_data->verifikator==3) and auth()->user()->role == 'verifikator'){
                    $pencarian_data->verifikator=1;
                    $pencarian_data->catatan = '';
                }
                elseif($pencarian_data->validasi==2 and auth()->user()->role == 'verifikator'){
                    $pencarian_data->verifikator=1;
                    $pencarian_data->catatan = '';
                    $pencarian_data->validasi=3;
                }
                elseif(auth()->user()->role == 'admin')
                {
                    $pencarian_data->verifikator=3;
                }
                elseif($pencarian_data->validasi==2)
                {
                    $pencarian_data->validasi=3;
                }
                $pencarian_data->status= 0;
                $pencarian_data->timestamps = false;
                $pencarian_data->save();
                return redirect('/statistik')->with('success', 'Data Telah Di Private!');           
            }
        }
        else if($request->unshow=='unshow'){
            if( $pencarian_data->validasi==1){
                $post = [
                    'id' => $id_package,
                    'private'=>'false',
                ];

                $result=self::get_curl('package_patch',$post);
                if($result['success']==true){
                    $pencarian_data->status= 1;
                    $pencarian_data->timestamps = false;
                    $pencarian_data->save();
                    return redirect('/statistik')->with('success', 'Data Telah Di Publish!');
                }
            }
            else{
                if(($pencarian_data->verifikator==2 or $pencarian_data->verifikator==3) and auth()->user()->role == 'verifikator'){
                    $pencarian_data->verifikator=1;
                    $pencarian_data->catatan = '';
                }
                elseif($pencarian_data->validasi==2 and auth()->user()->role == 'verifikator'){
                    $pencarian_data->verifikator=1;
                    $pencarian_data->catatan = '';
                    $pencarian_data->validasi=3;
                }
                elseif(auth()->user()->role == 'admin'){
                    $pencarian_data->verifikator=3;
                }
                elseif($pencarian_data->validasi==2){
                    $pencarian_data->validasi=3;
                }
                $pencarian_data->status= 1;
                $pencarian_data->timestamps = false;
                $pencarian_data->save();
                return redirect('/statistik')->with('success', 'Data Telah Di Publish!');           
            }

        }
        else{
            if($request->edit_file!=null)
            {
                $request->validate([
                    'edit_title' => 'required',
                    'description' =>'required',
                    'edit_file' => 'mimes:csv,txt,xlsx,xls,pdf|max:5120'
                ],
                [
                    'edit_title.required' => 'Judul Data Harus Di Isi',
                    'description.required' => 'Deskripsi Data Harus Di Isi',
                    'edit_file.max' => 'Ukuran File Maksimal 5 Mbps',
                    'edit_file.mimes' => 'File harus bertipe: xlsx, xls, pdf, csv',
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
            if (auth()->user()->role == 'verifikator'){
                if ($request->hasFile('edit_file')) {
                    $nama_file =Str::slug($request->edit_title, '-')."-".time(). "." . $request->file('edit_file')->getClientOriginalExtension();
                    Storage::delete('data/'.auth()->user()->instansi_id.'/'.$pencarian_data->file);
                    $request->file('edit_file')->storeAs('data/'.auth()->user()->instansi_id,$nama_file);
                    if($pencarian_data->id_package!='')
                    {
                        $post = [
                            'id' => $id_package,
                        ]; 
                        $result=self::get_curl('dataset_purge',$post);
                        if($result['success']==true){                            
                            $pencarian_data->id_package = '';
                            $pencarian_data->id_resource = '';
                            $pencarian_data->verifikator=1;
                            $pencarian_data->validasi=3;
                            $pencarian_data->catatan='';
                            $pencarian_data->title = $request->edit_title;
                            $pencarian_data->description = $request->description;
                            $pencarian_data->file = $nama_file;
                            $pencarian_data->type = $request->file('edit_file')->getClientOriginalExtension();
                            $pencarian_data->user_id = auth()->user()->id;
                            $pencarian_data->save();
                            alert()->success('Sukses','Data Berhasil Diupdate');
                            return response()->json(['url'=> route('data.statistik')]);
                        }
                    }
                    else{
                            if($pencarian_data->verifikator==2){
                                $pencarian_data->verifikator=1;
                            }
                            elseif($pencarian_data->validasi==2){
                                $pencarian_data->validasi=3;
                            }
                            $pencarian_data->catatan='';
                            $pencarian_data->title = $request->edit_title;
                            $pencarian_data->description = $request->description;
                            $pencarian_data->file = $nama_file;
                            $pencarian_data->type = $request->file('edit_file')->getClientOriginalExtension();
                            $pencarian_data->user_id = auth()->user()->id;
                            $pencarian_data->save();
                            alert()->success('Sukses','Data Berhasil Diupdate');
                            return response()->json(['url'=> route('data.statistik')]);
                    }
                }
                else
                {
                    if($pencarian_data->id_package!='')
                    {
                        $post = [
                            'id' => $id_package,
                            'title' => $request->edit_title,
                            'notes'   => $request->description,
                        ];
                        $result=self::get_curl('package_patch',$post);
                        if($result['success']==true){
                            $pencarian_data->title = $request->edit_title;
                            $pencarian_data->description = $request->description;
                            $pencarian_data->user_id = auth()->user()->id;
                            $pencarian_data->save();
                            alert()->success('Sukses','Data Berhasil Diupdate');
                            return response()->json(['url'=> route('data.statistik')]);
                            }
                    }
                    else{
                        if($pencarian_data->verifikator==2){
                            $pencarian_data->verifikator=1;
                            $pencarian_data->catatan = '';

                        }
                        elseif($pencarian_data->validasi==2){
                            $pencarian_data->verifikator=1;
                            $pencarian_data->catatan = '';
                            $pencarian_data->validasi=3;
                        }
                        $pencarian_data->title = $request->edit_title;
                        $pencarian_data->description = $request->description;
                        $pencarian_data->user_id = auth()->user()->id;
                        $pencarian_data->save();
                        alert()->success('Sukses','Data Berhasil Diupdate');
                        return response()->json(['url'=> route('data.statistik')]);
                    }
                }
            }
            elseif (auth()->user()->role == 'admin'){
                if ($request->hasFile('edit_file')) {
                    $nama_file =Str::slug($request->edit_title, '-')."-".time(). "." . $request->file('edit_file')->getClientOriginalExtension();
                    Storage::delete('data/'.auth()->user()->instansi_id.'/'.$pencarian_data->file);
                    $request->file('edit_file')->storeAs('data/'.auth()->user()->instansi_id,$nama_file);
                    if($pencarian_data->id_package!='')
                    {
                        $post = [
                            'id' => $id_package,
                        ]; 
                        $result=self::get_curl('dataset_purge',$post);
                        if($result['success']==true){                            
                            if($pencarian_data->verifikator==1 or $pencarian_data->verifikator==2)
                            {
                                $pencarian_data->verifikator=3;
                            }
                            $pencarian_data->id_package = '';
                            $pencarian_data->id_resource = '';
                            $pencarian_data->title = $request->edit_title;
                            $pencarian_data->description = $request->description;
                            $pencarian_data->file = $nama_file;
                            $pencarian_data->type = $request->file('edit_file')->getClientOriginalExtension();
                            $pencarian_data->user_id = auth()->user()->id;
                            $pencarian_data->save();
                            alert()->success('Sukses','Data Berhasil Diupdate');
                            return response()->json(['url'=> route('data.statistik')]);
                        }
                    }
                    else{
                        if($pencarian_data->verifikator==1 or $pencarian_data->verifikator==2)
                        {
                            $pencarian_data->verifikator=3;
                        }
                        $pencarian_data->title = $request->edit_title;
                        $pencarian_data->description = $request->description;
                        $pencarian_data->file = $nama_file;
                        $pencarian_data->type = $request->file('edit_file')->getClientOriginalExtension();
                        $pencarian_data->user_id = auth()->user()->id;
                        $pencarian_data->save();
                        alert()->success('Sukses','Data Berhasil Diupdate');
                        return response()->json(['url'=> route('data.statistik')]);
                    }
                    
                }
                else
                {
                    if($pencarian_data->id_package!='')
                    {
                        $post = [
                            'id' => $id_package,
                            'title' => $request->edit_title,
                            'notes'   => $request->description,
                        ];
                        $result=self::get_curl('package_patch',$post);
                        if($result['success']==true){
                            $pencarian_data->title = $request->edit_title;
                            $pencarian_data->description = $request->description;
                            $pencarian_data->user_id = auth()->user()->id;
                            $pencarian_data->save();
                            alert()->success('Sukses','Data Berhasil Diupdate');
                            return response()->json(['url'=> route('data.statistik')]);
                            }
                    }
                    else{
                        if($pencarian_data->verifikator==1 or $pencarian_data->verifikator==2)
                        {
                            $pencarian_data->verifikator=3;
                        }
                        $pencarian_data->title = $request->edit_title;
                        $pencarian_data->description = $request->description;
                        $pencarian_data->user_id = auth()->user()->id;
                        $pencarian_data->save();
                        alert()->success('Sukses','Data Berhasil Diupdate');
                        return response()->json(['url'=> route('data.statistik')]);
                    }
                }
            }   
        }
    }
    public function edit_note(Request $request, $id)
    {
        $pencarian_data = DataStatistik::find($id);
        $owner_org= $pencarian_data->instansi->id_ckan;
        $author= $pencarian_data->instansi->description;
        $title= $pencarian_data->title;
        $note=$pencarian_data->description;
        $cek_status=$pencarian_data->status;
        $name=time().$pencarian_data->id; 
        $id_instansi=$pencarian_data->instansi_id; 
        if (auth()->user()->role == 'administrator'){
            if($request->status==1){
                if($cek_status==0){
                    $status='true';
                }
                else{
                    $status='false';
                }
                    $post = [
                        'owner_org' => $owner_org,
                        'name' => $name,
                        'title'   => $title,
                        'notes'=>$note,
                        'author'=>$author,
                        'license_id'=>'License not specified',
                        'private'=>$status,
                        ]; 
                        $result=self::get_curl('package_create',$post);
                        if($result['success']==true){
                            $pencarian_data->id_package = $result['result']['id'];
                            $pencarian_data->save();  
                            $cFile = new CURLFile(storage_path('app/public/data/'.$id_instansi.'/'.$pencarian_data->file));
                            $post = [
                                'package_id' => $result['result']['id'],
                                'name' => $title,
                                'upload'=>$cFile,
                            ]; 
                            $result=self::get_curl('resource_create',$post);
                            if($result['success']==true)
                            {
                                $pencarian_data->id_resource =  $result['result']['id'];
                                $pencarian_data->validasi = 1;
                                $pencarian_data->note = '';
                                $pencarian_data->save();
                                return redirect('/verifikasi')->with('success', 'Proses Verifikasi data sudah berhasil!');
                                
                        }
                    }
            }
            else{
                $pencarian_data->validasi = 2;
                $pencarian_data->note = $request->catatan;
                $pencarian_data->save();  
                return redirect('/verifikasi')->with('success', 'Proses Verifikasi data sudah berhasil!');
            }
    
        }
        elseif (auth()->user()->role == 'verifikator'){
            if($pencarian_data['instansi_id']== auth()->user()->instansi_id){
                if($request->status==1){
                    if($pencarian_data->validasi !=0){
                        $pencarian_data->validasi=3;
                    }
                    $pencarian_data->verifikator = 1;
                    $pencarian_data->catatan = '';
                    $pencarian_data->save();
                    return redirect('/verifikasi')->with('success', 'Proses Verifikasi data sudah berhasil!');
                }
                else{
                    $pencarian_data->verifikator = 2;
                    $pencarian_data->catatan = $request->catatan;
                    $pencarian_data->save();
                    return redirect('/verifikasi')->with('success', 'Proses Verifikasi data sudah berhasil!');
                }
            }

        }       
    }
    public function hapus($id)
    {
        $pencarian_data = DataStatistik::find($id);
        $id_package= $pencarian_data->id_package;
        if($pencarian_data->validasi==1 or ($pencarian_data->validasi==3 and $id_package!=null) or ($pencarian_data->validasi==2 and $id_package!=null)){
            $post = [
                'id' => $id_package,
            ]; 
            $result=self::get_curl('dataset_purge',$post);
            if($result['success']==true){
                Storage::delete('data/'.$pencarian_data->instansi_id.'/'.$pencarian_data->file);
                $pencarian_data->delete();
                return redirect('/statistik')->with('success', 'Proses Hapus data sudah berhasil!');
            }
        }
        else{
            Storage::delete('data/'.$pencarian_data->instansi_id.'/'.$pencarian_data->file);
            $pencarian_data->delete();
            return redirect('/statistik')->with('success', 'Proses Hapus data sudah berhasil!');
        }
    }
    public function unverified()
    {
        $data['nav'] =$this->getnav();
        $data['hasil'] = DB::table('data_statistik')
                ->join('instansi', 'data_statistik.instansi_id', '=', 'instansi.id')
                ->select('instansi.description',DB::raw('COUNT(data_statistik.verifikator) as data'))
                ->whereIN('data_statistik.verifikator',['0','3'])
                ->orderby('data_statistik.instansi_id','DESC')
                ->groupBy('data_statistik.instansi_id')
                ->get();
        return view('adminweb.unverified', $data);
    }
}
