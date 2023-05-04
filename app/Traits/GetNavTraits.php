<?php

namespace App\Traits;

use App\models\DataStatistik;
use Illuminate\Http\Request;

trait GetNavTraits
{
    public function getnav()
    {
        $id_instansi = auth()->user()->instansi_id;
        if (auth()->user()->role == 'administrator'){
            $data['jumlah_validasi'] = DataStatistik::where([['instansi_id', $id_instansi],['verifikator','1'],['validasi','0']])->count();
            $data['jumlah_note'] = DataStatistik::where([['instansi_id', $id_instansi],['verifikator','1'],['validasi','2']])->count();
            $data['jumlah_validasi_ulang'] = DataStatistik::where([['instansi_id', $id_instansi],['verifikator','1'],['validasi','3']])->count();
            $data['jumlah_validasi_all'] = DataStatistik::where('verifikator',1)->whereIN('validasi',[0,3])->count();  
            $data['data_valid'] = DataStatistik::where('validasi',1)->count();  
            $data['data_unverified'] = DataStatistik::whereIN('verifikator',[0,3])->count();  
        }
        elseif (auth()->user()->role == 'verifikator' or auth()->user()->role == 'admin'){
            $data['jumlah_validasi'] = DataStatistik::where([['instansi_id', $id_instansi],['verifikator','0']])->count()+DataStatistik::where([['instansi_id', $id_instansi],['verifikator','1'],['validasi','0']])->count();
            $data['jumlah_note'] = DataStatistik::where([['instansi_id', $id_instansi],['verifikator','2']])->count()+DataStatistik::where([['instansi_id', $id_instansi],['verifikator','1'],['validasi','2']])->count();
            $data['jumlah_validasi_ulang'] = DataStatistik::where([['instansi_id', $id_instansi],['verifikator','3']])->count()+DataStatistik::where([['instansi_id', $id_instansi],['verifikator','1'],['validasi','3']])->count();
            $data['jumlah_validasi_all'] = DataStatistik::where('instansi_id', $id_instansi)->whereIN('verifikator',[0,3])->count();  
        }
        return $data;
    }
}
