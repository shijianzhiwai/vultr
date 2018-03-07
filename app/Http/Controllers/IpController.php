<?php

namespace App\Http\Controllers;

use App\Ip;
use Illuminate\Http\Request;
use App\Http\Resources\IpCollection;

class IpController extends Controller
{
    public function index()
    {
        return  new IpCollection(Ip::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Ip  $ip
     * @return \Illuminate\Http\Response
     */
    public function show(Ip $ip)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Ip  $ip
     * @return \Illuminate\Http\Response
     */
    public function edit(Ip $ip)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Ip  $ip
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ip $ip)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ip  $ip
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ip $ip)
    {
        //
    }
}
