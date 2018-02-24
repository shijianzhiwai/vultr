<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helper\Firewall;
use App\Helper\Response;

class VultrController extends Controller
{
    public function index()
    {
        return view('vultr.index');
    }

    public function fireList(Request $request)
    {
        return Response::vultr(Firewall::request('GET','firewall/group_list'));
    }

    public function user(Request $request)
    {
        return Response::vultr($request->user());
    }
}
