<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers;

use App\Imports\PesertaImportCollection;
use App\Imports\PesertaImport;
use App\Imports\PesertaImportHeader;

use Excel;

class ExcelController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function import(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');

            // Excel::import(new PesertaImportCollection, $file);
            Excel::import(new PesertaImport, $file);
            // Excel::import(new PesertaImportHeader, $file);


            return redirect('import/excel');
        }
    }
}
