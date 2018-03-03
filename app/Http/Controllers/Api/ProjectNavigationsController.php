<?php

namespace App\Http\Controllers\Api;

use Motor\Backend\Http\Controllers\Controller;

use App\Models\ProjectNavigation;
use App\Http\Requests\Backend\ProjectNavigationRequest;
use App\Services\ProjectNavigationService;
use App\Transformers\ProjectNavigationTransformer;

class ProjectNavigationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paginator = ProjectNavigationService::collection()->getPaginator();
        $resource = $this->transformPaginator($paginator, ProjectNavigationTransformer::class);

        return $this->respondWithJson('ProjectNavigation collection read', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectNavigationRequest $request)
    {
        $result = ProjectNavigationService::create($request)->getResult();
        $resource = $this->transformItem($result, ProjectNavigationTransformer::class);

        return $this->respondWithJson('ProjectNavigation created', $resource);
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show(ProjectNavigation $record)
    {
        $result = ProjectNavigationService::show($record)->getResult();


        $resource = $this->transformItem($result, ProjectNavigationTransformer::class);

        return $this->respondWithJson('ProjectNavigation read', $resource);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(ProjectNavigationRequest $request, ProjectNavigation $record)
    {
        $result = ProjectNavigationService::update($record, $request)->getResult();
        $resource = $this->transformItem($result, ProjectNavigationTransformer::class);

        return $this->respondWithJson('ProjectNavigation updated', $resource);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProjectNavigation $record)
    {
        $result = ProjectNavigationService::delete($record)->getResult();

        if ($result) {
            return $this->respondWithJson('ProjectNavigation deleted', ['success' => true]);
        }
        return $this->respondWithJson('ProjectNavigation NOT deleted', ['success' => false]);
    }
}