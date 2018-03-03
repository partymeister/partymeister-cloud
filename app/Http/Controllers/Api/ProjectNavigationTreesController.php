<?php

namespace App\Http\Controllers\Api;

use App\Services\ProjectNavigationService;
use App\Transformers\ProjectNavigationTransformer;
use Motor\Backend\Http\Controllers\Controller;

use App\Models\ProjectNavigation;
use App\Http\Requests\Backend\ProjectNavigationTreeRequest;

class ProjectNavigationTreesController extends Controller
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

        return $this->respondWithJson('ProjectNavigationTree collection read', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectNavigationTreeRequest $request)
    {
        $result = ProjectNavigationService::create($request)->getResult();
        $resource = $this->transformItem($result, ProjectNavigationTransformer::class);

        return $this->respondWithJson('ProjectNavigationTree created', $resource);
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
        $resource = $this->transformCollection($result->children, ProjectNavigationTransformer::class);

        return $this->respondWithJson('ProjectNavigationTree read', $resource);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(ProjectNavigationTreeRequest $request, ProjectNavigation $record)
    {
        $result = ProjectNavigationService::update($record, $request)->getResult();
        $resource = $this->transformItem($result, ProjectNavigationTransformer::class);

        return $this->respondWithJson('ProjectNavigationTree updated', $resource);
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
            return $this->respondWithJson('ProjectNavigationTree deleted', ['success' => true]);
        }
        return $this->respondWithJson('ProjectNavigationTree NOT deleted', ['success' => false]);
    }
}