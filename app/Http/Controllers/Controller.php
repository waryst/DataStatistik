<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{

    public function __construct()
    {
        $user = auth()->user();
        view()->share('user', $user);
    }
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}

