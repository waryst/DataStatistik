<?php

use App\models\Dashboard;
use App\models\DataPublic;
use App\models\Visualisasi;
use App\models\DataStatistik;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;
Route::get('file/{id_file}', function ($id_file)
{
    $caridatasets=DataStatistik::all();
    $datafile = $caridatasets->firstWhere('id',$id_file);
    $dinasnya=($datafile->instansi_id);
    $filenya=($datafile->file);
        $datafile->download =$datafile->download + 1;
        $datafile->save();
    $nama_file=preg_replace("/[^a-zA-Z0-9 ]/", "-", $datafile->title);
    return response()->download(storage_path('app/public/data/'.$dinasnya.'/'.$filenya),$nama_file.".".$datafile->type);

});
Route::get('view/{id_file}', function ($id_file)
{
    $caridatasets=DataStatistik::all();
    $datafile = $caridatasets->firstWhere('id',$id_file);
    $dinasnya=($datafile->instansi_id);
    $filenya=($datafile->file);
    $nama_file=preg_replace("/[^a-zA-Z0-9 ]/", "-", $datafile->title);
    return response()->download(storage_path('app/public/data/'.$dinasnya.'/'.$filenya),$nama_file.".".$datafile->type);

});
Route::get('public/{id_file}/{data}', function ($id_file)
{
    $caridatapublik=DataPublic::all();
    $datafile = $caridatapublik->firstWhere('id',$id_file);
    $dinasnya=($datafile->instansi_id);
    $filenya=($datafile->file);
    return response()->download(storage_path('app/public/data/'.$dinasnya.'/'.$filenya),$datafile->title.".".$datafile->type);
});
Route::get('image/{ket}/{id_file}', function ($ket, $id_file)
{
   if($ket=='logo'){
    $cariinstansi=Dashboard::all();
    $datafile = $cariinstansi->firstWhere('id',$id_file);
    $filenya=($datafile->logo);
    return response()->download(storage_path('app/public/data/'.$id_file.'/'.$filenya));

   }
   elseif($ket=='kadin'){
    $cariinstansi=Dashboard::all();
    $datafile = $cariinstansi->firstWhere('id',$id_file);
    $filenya=($datafile->foto_kadin);
    return response()->download(storage_path('app/public/data/'.$id_file.'/'.$filenya));

   }
   elseif($ket=='visualisasi'){
       $caridatasets=Visualisasi::all();
       $datafile = $caridatasets->firstWhere('id',$id_file);
       $filenya=($datafile->image);
       return response()->download(storage_path('app/public/'.$filenya));
   }
   elseif($ket=='publikasi'){
        $caridatapublik=DataPublic::all();
        $datafile = $caridatapublik->firstWhere('id',$id_file);
        $dinasnya=($datafile->instansi_id);
        $filenya=($datafile->cover);
        return response()->download(storage_path('app/public/data/'.$dinasnya.'/publikasi/'.$filenya));

   }
});

Route::get('/', 'Frontend\DashboardController@index');
Route::get('/visual', 'Frontend\DashboardController@visual');
Route::get('/visual/{slug}', 'Frontend\DashboardController@detail_visual');
Route::get('/instansi/{dinas}', 'Frontend\InstansiController@index');
Route::get('/data/lihatdata/{resource}', 'Frontend\InstansiController@detail')->name('detail');
Route::get('/lihat', 'Frontend\InstansiController@detail_lihat');
Route::get('/datasets', 'Frontend\InstansiController@datasets');
Route::get('/datasets/json/', 'Frontend\InstansiController@json');
Route::get('/instansi', 'Frontend\InstansiController@instansi');
Route::get('/publikasi', 'Frontend\InstansiController@datapublikasi');
Route::get('/login', 'Auth\AuthController@index')->name('login')->middleware('revalidate');
Route::post('/postlogin', 'Auth\AuthController@postlogin');
Route::get('/logout', 'Auth\AuthController@logout');

Route::group(['middleware' => ['auth', 'checkRole:administrator,verifikator,admin', 'revalidate']], function () {
    Route::get('/dashboard', 'Adminweb\DashboardAdminController@index')->name('dashboard');
    Route::get('/profil', 'Adminweb\InstansiAdminController@index');
    Route::post('/profil', 'Adminweb\InstansiAdminController@edit');
    Route::get('/statistik', 'Adminweb\DashboardAdminController@data_statistik')->name('data.statistik');
    Route::post('/statistik', 'Adminweb\DashboardAdminController@store')->name('tabel.store');
    Route::post('/statistik/{id}', 'Adminweb\DashboardAdminController@edit');
    Route::get('/statistik/{id}', 'Adminweb\DashboardAdminController@show')->name('data.show');
    Route::post('/statistik/note/{id}', 'Adminweb\DashboardAdminController@edit_note');
    Route::delete('/statistik/{id}', 'Adminweb\DashboardAdminController@hapus');
    Route::get('password', 'Auth\PasswordController@edit')->name('user.password.edit');
    Route::patch('password', 'Auth\PasswordController@update')->name('user.password.update');
    Route::get('/data_instansi/daftar_user/{id}', 'Adminweb\InstansiAdminController@user_instansi');
    Route::post('/data_instansi/daftar_user/{id}', 'Adminweb\InstansiAdminController@add_user_instansi');
    Route::post('/data_instansi/edit_user/{id}', 'Adminweb\InstansiAdminController@edit_user_instansi');
    Route::post('/data_instansi/reset_user/{id}', 'Adminweb\InstansiAdminController@reset_user_instansi');
    Route::delete('/data_instansi/hapus_user/{id}', 'Adminweb\InstansiAdminController@hapus_user_instansi');

});

Route::group(['middleware' => ['auth', 'checkRole:administrator,verifikator', 'revalidate']], function () {
    Route::get('/verifikasi', 'Adminweb\InstansiAdminController@verifikasi')->name('verifikasi');

});

Route::group(['middleware' => ['auth', 'checkRole:administrator', 'revalidate']], function () {
    Route::get('/data_instansi', 'Adminweb\InstansiAdminController@data_instansi');
    Route::post('/data_instansi', 'Adminweb\InstansiAdminController@input_instansi');
    Route::post('/data_instansi/{id}', 'Adminweb\InstansiAdminController@edit_instansi');
    Route::get('/data_instansi/daftar_user', 'Adminweb\InstansiAdminController@data_instansi');
    Route::get('/data_instansi/data_statistik/{id}', 'Adminweb\InstansiAdminController@data_statistik');
    Route::post('/data_instansi/data_statistik/{id}', 'Adminweb\InstansiAdminController@add_statistik');
    Route::post('/data_instansi/update_data_statistik/{id}', 'Adminweb\InstansiAdminController@edit_statistik');
    Route::delete('/data_instansi/update_data_statistik/{id}', 'Adminweb\InstansiAdminController@del_statistik');
    Route::get('/data_publikasi', 'Adminweb\PublikAdminController@index')->name('data.publikasi');
    Route::post('/data_publikasi', 'Adminweb\PublikAdminController@store')->name('data.publikasi.store');
    Route::get('/data_publikasi/{id}', 'Adminweb\PublikAdminController@show');
    Route::post('/data_publikasi/{id}', 'Adminweb\PublikAdminController@edit');
    Route::delete('/data_publikasi/{id}', 'Adminweb\PublikAdminController@hapus');
    Route::get('/unverified', 'Adminweb\DashboardAdminController@unverified');

    Route::get('/visualisasi_data', 'Adminweb\VisualAdminController@data_visualisasi');
    Route::get('/visualisasi_data/create', 'Adminweb\VisualAdminController@createvisual');
    Route::post('/visualisasi_data/post', 'Adminweb\VisualAdminController@postvisual');
    Route::get('/edit_visualisasi/{id}', 'Adminweb\VisualAdminController@show');
    Route::put('/visualisasi_data/{slug}', 'Adminweb\VisualAdminController@updatevisual');
    Route::delete('/visualisasi_data/{slug}', 'Adminweb\VisualAdminController@destroy');
    Route::get('/indikator', 'Adminweb\IndikatorController@index');


});

Route::get('import/excel', 'ExcelController@index');
Route::post('import/excel', 'ExcelController@import');
