<?php

namespace App\Http\Controllers\Api;

use App\Models\App;
//use GrahamCampbell\Throttle\Facades\Throttle;
use App\Models\Project;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Motor\Backend\Http\Controllers\Controller;
use GuzzleHttp\Client;

class TicketsController extends Controller
{

    public function index(Request $request, Project $project, App $app)
    {
        //$throttler = Throttle::get($request, 10, 30);

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
                if ($body->success == false || (isset($body->data) && $body->data->Nachname != $request->last_name)) {
                    //if (!$throttler->attempt($request)) {
                    //    return response()->json(['message' => 'Blocked', 'data' => []], 429);
                    //}
                    return response()->json(['message' => 'Invalid', 'data' => []], 400);
                } elseif($body->data->Nachname == $request->get('last_name')) {
                    //$throttler->clear($request);
                    $response = [
                        'first_name' => $body->data->Vorname,
                        'last_name' => $body->data->Nachname,
                        'code' => $body->data->Code,
                        'type' => $body->data->TicketArt,
                        'order_number' => $body->data->Betreff
                    ];
                    return $this->respondWithJson('Valid', $response);
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
