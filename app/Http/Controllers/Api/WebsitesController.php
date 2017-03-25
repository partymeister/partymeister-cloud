<?php

namespace App\Http\Controllers\Api;

use Motor\Backend\Http\Controllers\Controller;

use App\Models\Website;
use App\Http\Requests\Backend\WebsiteRequest;
use App\Services\WebsiteService;
use App\Transformers\WebsiteTransformer;

class WebsitesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paginator = WebsiteService::collection()->getPaginator();
        $resource = $this->transformPaginator($paginator, WebsiteTransformer::class);

        return $this->respondWithJson('Website collection read', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(WebsiteRequest $request)
    {
        $result = WebsiteService::create($request)->getResult();
        $resource = $this->transformItem($result, WebsiteTransformer::class);

        return $this->respondWithJson('Website created', $resource);
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Website $record)
    {
        $result = WebsiteService::show($record)->getResult();
        $resource = $this->transformItem($result, WebsiteTransformer::class);

        return $this->respondWithJson('Website read', $resource);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(WebsiteRequest $request, Website $record)
    {
        $result = WebsiteService::update($record, $request)->getResult();
        $resource = $this->transformItem($result, WebsiteTransformer::class);

        return $this->respondWithJson('Website updated', $resource);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Website $record)
    {
        $result = WebsiteService::delete($record)->getResult();

        if ($result) {
            return $this->respondWithJson('Website deleted', ['success' => true]);
        }
        return $this->respondWithJson('Website NOT deleted', ['success' => false]);
    }
}