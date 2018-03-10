<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helper\Mime;
use GuzzleHttp\Client;

class DocController extends Controller
{
    //
    public function index(Request $request, $path)
    {
        $client = new Client([
            'base_uri' => 'http://localhost:5555/',
            'timeout'  => 10.0,
        ]);

        try{
            $response = $client->request('GET', $path . '?' . http_build_query($request->query()));

            if ($response->getStatusCode() !== '200') {
                return abort(404);
            }

        }catch (\Exception $exception){
            return abort(404);
        }


        return response($response->getBody(), 200 ,['Content-Type'=> $response->getHeader('Content-Type')] );


    }
}
