<?php

namespace App\Http\Controllers\Api;

use Motor\Backend\Http\Controllers\Controller;

use App\Models\App;
use App\Http\Requests\Backend\AppRequest;
use App\Services\AppService;
use App\Transformers\AppTransformer;

class AppsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paginator = AppService::collection()->getPaginator();
        $resource = $this->transformPaginator($paginator, AppTransformer::class);

        return $this->respondWithJson('App collection read', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(AppRequest $request)
    {
        $result = AppService::create($request)->getResult();
        $resource = $this->transformItem($result, AppTransformer::class);

        return $this->respondWithJson('App created', $resource);
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show(App $record)
    {
        $result = AppService::show($record)->getResult();
        $resource = $this->transformItem($result, AppTransformer::class);

        return $this->respondWithJson('App read', $resource);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(AppRequest $request, App $record)
    {
        $result = AppService::update($record, $request)->getResult();
        $resource = $this->transformItem($result, AppTransformer::class);

        return $this->respondWithJson('App updated', $resource);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(App $record)
    {
        $result = AppService::delete($record)->getResult();

        if ($result) {
            return $this->respondWithJson('App deleted', ['success' => true]);
        }
        return $this->respondWithJson('App NOT deleted', ['success' => false]);
    }
}