<?php

namespace App\Http\Controllers\Frontend;

use App\models\Api;
use App\models\Visual;
use App\models\Dashboard;
use Illuminate\Http\Request;
use App\models\DataStatistik;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function get_curl($url){
        $api=Api::first(); 
        $curl=curl_init();
        curl_setopt($curl,CURLOPT_URL, $api->url.$url);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        $result= curl_exec($curl);
        curl_close($curl);
        return json_decode($result,true);
    }

    public function index()
    {
        $data['instansi'] = Dashboard::inRandomOrder()->get();
        $data['visual'] = Visual::whereNotNull('publish_at')->limit(12)->orderByDesc('id')->get();
        $data['jumlah_DataStatistik'] = DataStatistik::where([['validasi', 1],['verifikator','1'],['status','1']])->count();
        $data['jumlah_instansi'] = Dashboard::all()->count();

        return view('frontend.index', $data);
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
    public function visual()
    {
        $hal=16;
        if(request('search')){
            $data['visuals'] = Visual::latest()->whereNotNull('publish_at')->where('title','like','%'.request('search').'%')->paginate($hal)->withQueryString();
        }
        else{
            $data['visuals'] = Visual::latest()->whereNotNull('publish_at')->paginate($hal)->withQueryString();
        }
        return view('frontend.visual', $data);
    }
    public function detail_visual($slug)
    {
        $data['visual'] = Visual::where('slug',$slug)->first();
        if($data['visual']->publish_at!=null){
            return view('frontend.visualdetail', $data);
        }
        else{
            $data['visual'] = Visual::where('status',1)->where('validasi',1)->get();
            return view('frontend.visual', $data);
        }
    }
}
