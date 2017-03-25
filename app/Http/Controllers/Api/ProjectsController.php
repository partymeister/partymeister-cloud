<?php

namespace App\Http\Controllers\Api;

use Motor\Backend\Http\Controllers\Controller;

use App\Models\Project;
use App\Http\Requests\Backend\ProjectRequest;
use App\Services\ProjectService;
use App\Transformers\ProjectTransformer;

class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paginator = ProjectService::collection()->getPaginator();
        $resource = $this->transformPaginator($paginator, ProjectTransformer::class);

        return $this->respondWithJson('Project collection read', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectRequest $request)
    {
        $result = ProjectService::create($request)->getResult();
        $resource = $this->transformItem($result, ProjectTransformer::class);

        return $this->respondWithJson('Project created', $resource);
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Project $record)
    {
        $result = ProjectService::show($record)->getResult();
        $resource = $this->transformItem($result, ProjectTransformer::class);

        return $this->respondWithJson('Project read', $resource);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(ProjectRequest $request, Project $record)
    {
        $result = ProjectService::update($record, $request)->getResult();
        $resource = $this->transformItem($result, ProjectTransformer::class);

        return $this->respondWithJson('Project updated', $resource);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $record)
    {
        $result = ProjectService::delete($record)->getResult();

        if ($result) {
            return $this->respondWithJson('Project deleted', ['success' => true]);
        }
        return $this->respondWithJson('Project NOT deleted', ['success' => false]);
    }
}