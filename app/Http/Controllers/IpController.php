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

    /**
     * @param Request $request
     * @return $this|\Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $pm = \App\Helper\Request::validator($request->all(),[
            'ip' => 'bail|required|ipv4',
            'remark' => 'bail|required',
        ]);

        $ip = new Ip;
        $ip->ip = $pm['ip'];
        $ip->remark = $pm['remark'];
        $ip->save();
        return Response::vultr(['data' => $ip->toArray()]);
    }

    public function show(Ip $ip)
    {

    }

    /**
     * @param Request $request
     * @param Ip $ip
     * @return $this|\Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Ip $ip)
    {
        $pm = \App\Helper\Request::validator($request->all(),[
            'ip' => 'bail|required|ipv4',
            'remark' => 'bail|required',
        ]);

        $ip->ip = $pm['ip'];
        $ip->remark = $pm['remark'];
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
