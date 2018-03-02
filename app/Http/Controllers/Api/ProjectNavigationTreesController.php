<?php

namespace App\Http\Controllers\Api;

use Motor\Backend\Http\Controllers\Controller;

use App\Models\ProjectNavigationTree;
use App\Http\Requests\Backend\ProjectNavigationTreeRequest;
use App\Services\ProjectNavigationTreeService;
use App\Transformers\ProjectNavigationTreeTransformer;

class ProjectNavigationTreesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paginator = ProjectNavigationTreeService::collection()->getPaginator();
        $resource = $this->transformPaginator($paginator, ProjectNavigationTreeTransformer::class);

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
        $result = ProjectNavigationTreeService::create($request)->getResult();
        $resource = $this->transformItem($result, ProjectNavigationTreeTransformer::class);

        return $this->respondWithJson('ProjectNavigationTree created', $resource);
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show(ProjectNavigationTree $record)
    {
        $result = ProjectNavigationTreeService::show($record)->getResult();
        $resource = $this->transformItem($result, ProjectNavigationTreeTransformer::class);

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
    public function update(ProjectNavigationTreeRequest $request, ProjectNavigationTree $record)
    {
        $result = ProjectNavigationTreeService::update($record, $request)->getResult();
        $resource = $this->transformItem($result, ProjectNavigationTreeTransformer::class);

        return $this->respondWithJson('ProjectNavigationTree updated', $resource);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProjectNavigationTree $record)
    {
        $result = ProjectNavigationTreeService::delete($record)->getResult();

        if ($result) {
            return $this->respondWithJson('ProjectNavigationTree deleted', ['success' => true]);
        }
        return $this->respondWithJson('ProjectNavigationTree NOT deleted', ['success' => false]);
    }
}