<?php

namespace App\Http\Controllers\Api;

use App\Models\App;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Motor\Backend\Http\Controllers\Controller;
use GuzzleHttp\Client;

class TicketsController extends Controller
{

    public function index(Request $request, App $app)
    {
        $client = new Client([
            'timeout' => 2.0,
        ]);

        try {
            $response = $client->request('POST', $app->deinetickets_api_url, [
                'form_params' => [
                    'token' => $app->deinetickets_api_token,
                    'code'  => $request->get('code')
                ]
            ]);

            if ($response->getStatusCode() == 200) {
                $body = \GuzzleHttp\json_decode((string) $response->getBody());
                if ($body->success == false) {
                    return $this->respondWithJson('Invalid', []);
                } else {
                    return $this->respondWithJson('Valid', $body);
                }
            }
        } catch (RequestException $e) {
            var_dump($e->getRequest());
            if ($e->hasResponse()) {
                var_dump($e->getResponse());
            }
        }
    }
}
