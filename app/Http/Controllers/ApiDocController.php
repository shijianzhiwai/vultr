<?php

namespace App\Http\Controllers;

use App\Ip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helper\Firewall;
use App\Helper\Response;

class ApiDocController extends Controller
{
    public function index() {
        return view('apidoc.index');
    }
}