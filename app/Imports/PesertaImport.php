<?php

namespace App\Imports;

use App\models\Peserta;
use Maatwebsite\Excel\Concerns\ToModel;

class PesertaImport implements ToModel
{
    public function model(array $row)
    {
        if ($row[4] == "Belum Verifikasi") {
            $status = 0;
        } else {
            $status = 1;
        }

        return new Peserta([
            'NIK'     => $row[1],
            'nama'    => $row[2],
            'bagian'    => $row[3],
            'hadiah'    => $row[0],
            'status'    => $status,
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s'),
        ]);
    }
}
