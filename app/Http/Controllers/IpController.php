<?php

namespace App\Http\Controllers;

use App\Helper\Response;
use App\Ip;
use Illuminate\Http\Request;
use App\Http\Resources\IpCollection;

class IpController extends Controller
{
    public function index()
    {
        return  new IpCollection(Ip::all());
    }

    public function create()
    {

    }

    public function store(Request $request)
    {

    }

    public function show(Ip $ip)
    {

    }

    public function update(Request $request, Ip $ip)
    {
        $ip->ip = $request->input('ip');
        $ip->remark = $request->input('remark');
        $ip->save();
        return Response::vultr('');
    }

    /**
     * @param Request $request
     * @param Ip $ip
     * @return $this|\Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function destroy(Request $request, Ip $ip)
    {
        $ip->delete();
        return Response::vultr('');
    }

    public function myIp(Request $request)
    {
        return $request->getClientIp();
    }
}
