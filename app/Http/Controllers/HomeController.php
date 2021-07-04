<?php

namespace App\Http\Controllers;

use App\Helpers\NgBuildService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __invoke(NgBuildService $ng)
    {
        return view('app', ['ngAssets' => $ng->assets]);
    }
}
