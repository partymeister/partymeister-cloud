<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\ProjectNavigationRequest;
use App\Models\ProjectNavigation;
use App\Services\ProjectNavigationService;
use Motor\Backend\Http\Controllers\Controller;

use App\Grids\ProjectNavigationTreeGrid;
use App\Forms\Backend\ProjectNavigationTreeForm;

use Kris\LaravelFormBuilder\FormBuilderTrait;
use Motor\Core\Filter\Renderers\WhereRenderer;

class ProjectNavigationTreesController extends Controller
{
    use FormBuilderTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $grid = new ProjectNavigationTreeGrid(ProjectNavigation::class);

        $service = ProjectNavigationService::collection($grid);

        $filter = $service->getFilter();
        $filter->add(new WhereRenderer('parent_id'))->setDefaultValue(null)->setAllowNull(true);

        $grid->filter = $filter;

        $paginator    = $service->getPaginator();

        return view('backend.project_navigation_trees.index', compact('paginator', 'grid'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $form = $this->form(ProjectNavigationTreeForm::class, [
            'method'  => 'POST',
            'route'   => 'backend.project_navigation_trees.store',
            'enctype' => 'multipart/form-data'
        ]);

        return view('backend.project_navigation_trees.create', compact('form'));
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
        $form = $this->form(ProjectNavigationTreeForm::class);

        // It will automatically use current request, get the rules, and do the validation
        if ( ! $form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        ProjectNavigationService::createWithForm($request, $form);

        flash()->success(trans('backend/project_navigation_trees.created'));

        return redirect('backend/project_navigation_trees');
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(ProjectNavigation $record)
    {
        $form = $this->form(ProjectNavigationTreeForm::class, [
            'method'  => 'PATCH',
            'url'     => route('backend.project_navigation_trees.update', [ $record->id ]),
            'enctype' => 'multipart/form-data',
            'model'   => $record
        ]);

        return view('backend.project_navigation_trees.edit', compact('form'));
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
        $form = $this->form(ProjectNavigationTreeForm::class);

        // It will automatically use current request, get the rules, and do the validation
        if ( ! $form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        ProjectNavigationService::updateWithForm($record, $request, $form);

        flash()->success(trans('backend/project_navigation_trees.updated'));

        return redirect('backend/project_navigation_trees');
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
        ProjectNavigationService::delete($record);

        flash()->success(trans('backend/project_navigation_trees.deleted'));

        return redirect('backend/project_navigation_trees');
    }
}
