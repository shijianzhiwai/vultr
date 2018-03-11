<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cookie;

class DocController extends Controller
{

    public function index(Request $request, $path='')
    {
        return redirect('https://youyudoc.oftime.me/')
            ->cookie('docpass', 'youyudocshijianzhiwai123', 60*24*30, '/', '.oftime.me');
        /*
        $client = new Client([
            'base_uri' => 'http://localhost:5555/',
            'timeout'  => 10.0,
        ]);

        try{
            $response = $client->request('GET', $path . '?' . http_build_query($request->query()));
            if ($response->getStatusCode() != '200') {
                return abort(404);
            }

        }catch (\Exception $exception){
            return abort(404);
        }

        return response($response->getBody(), 200 ,['Content-Type'=> $response->getHeader('Content-Type')] );
        */
    }

    public function gitPush(Request $request)
    {
        $json = \json_decode($request->getContent(), 1);
        if (is_array($json) && $json['password'] == 'asjfjasbd') {
            $dir = storage_path('git') . '/git.log';
            file_put_contents($dir,'');
            chmod($dir, 0777);
            return response('ok');
        }

        return response('error');
    }
}
