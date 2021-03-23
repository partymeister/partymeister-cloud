<?php

namespace App\Http\Controllers\Backend;

use Motor\Backend\Http\Controllers\Controller;

use App\Models\Project;
use App\Http\Requests\Backend\ProjectRequest;
use App\Services\ProjectService;
use App\Grids\ProjectGrid;
use App\Forms\Backend\ProjectForm;

use Kris\LaravelFormBuilder\FormBuilderTrait;

class ProjectsController extends Controller
{
    use FormBuilderTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $grid = new ProjectGrid(Project::class);

        $service = ProjectService::collection($grid);
        $grid->setFilter($service->getFilter());
        $paginator    = $service->getPaginator();

        return view('backend.projects.index', compact('paginator', 'grid'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $form = $this->form(ProjectForm::class, [
            'method'  => 'POST',
            'route'   => 'backend.projects.store',
            'enctype' => 'multipart/form-data'
        ]);

        return view('backend.projects.create', compact('form'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  ProjectRequest  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(ProjectRequest $request)
    {
        $form = $this->form(ProjectForm::class);

        // It will automatically use current request, get the rules, and do the validation
        if ( ! $form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        ProjectService::createWithForm($request, $form);

        flash()->success(trans('backend/projects.created'));

        return redirect('backend/projects');
    }


    /**
     * Display the specified resource.
     *
     * @param $id
     */
    public function show($id)
    {
        //
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  Project  $record
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Project $record)
    {
        $form = $this->form(ProjectForm::class, [
            'method'  => 'PATCH',
            'url'     => route('backend.projects.update', [ $record->id ]),
            'enctype' => 'multipart/form-data',
            'model'   => $record
        ]);

        return view('backend.projects.edit', compact('form'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  ProjectRequest  $request
     * @param  Project  $record
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(ProjectRequest $request, Project $record)
    {
        $form = $this->form(ProjectForm::class);

        // It will automatically use current request, get the rules, and do the validation
        if ( ! $form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        ProjectService::updateWithForm($record, $request, $form);

        flash()->success(trans('backend/projects.updated'));

        return redirect('backend/projects');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  Project  $record
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Project $record)
    {
        ProjectService::delete($record);

        flash()->success(trans('backend/projects.deleted'));

        return redirect('backend/projects');
    }
}
