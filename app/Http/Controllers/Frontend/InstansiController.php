<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\models\DataPublic;
use App\models\Api;
use App\models\Dashboard;
use App\models\DataStatistik;

class InstansiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_curl($url){
        $api=Api::first(); 
        $curl=curl_init();
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
        $result= curl_exec($curl);
        curl_close($curl);
        return json_decode($result,true);
    }

    public function index($dinas)
    {
        $cariinstansi=Dashboard::all();
        $data['instansi'] = $cariinstansi->firstWhere('name', $dinas);
        $caridatasets=DataStatistik::all();
        $data['datasets'] = $caridatasets->Where('instansi_id', $data['instansi']->id)->Where('status', 1)->Where('validasi',1);
        $data['keterangan'] = 'dinas';
        return view('frontend.instansi', $data);
    }

    public function detail($resource)
    {
        $caridatasets=DataStatistik::all();
        $data['datasets'] = $caridatasets->firstWhere('id', $resource);
        $data['datasets']->view =$data['datasets']->view + 1;
        $data['datasets']->save();
        return view('frontend.detail_pencarian',$data);
    }
    public function datasets()
    {
        $data['datasets'] = DataStatistik::latest()->where('status',1)->where('validasi',1)->where('verifikator',1)->get();
        $data['keterangan'] = 'semua';
        return view('frontend.datasets',$data);
    }
    public function datapublikasi()
    {
        $hal=10;
        if(request('search')){
            $data['publikasi'] = DataPublic::latest()->where('title','like','%'.request('search').'%')->paginate($hal)->withQueryString();
        }
        else{
            $data['publikasi'] = DataPublic::latest()->paginate($hal)->withQueryString();
        }        return view('frontend.publikasi',$data);
    }
    public function instansi()
    {
        $hal=12;
        if(request('search')){
            $data['instansi'] = Dashboard::where('name','like','%'.request('search').'%')->paginate($hal)->withQueryString();
       
        }
        else{
            $data['instansi'] = Dashboard::paginate($hal)->withQueryString();
        }

        return view('frontend.data_instansi',$data);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Dashboard  $dashboard
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Dashboard  $dashboard
     * @return \Illuminate\Http\Response
     */
    public function edit(Dashboard $dashboard)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Dashboard  $dashboard
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Dashboard $dashboard)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Dashboard  $dashboard
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dashboard $dashboard)
    {
        //
    }
}
