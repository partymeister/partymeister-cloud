<?php

namespace App\Http\Controllers\Backend;

use Kalnoy\Nestedset\NestedSet;
use Motor\Backend\Http\Controllers\Controller;

use App\Models\ProjectNavigation;
use App\Http\Requests\Backend\ProjectNavigationRequest;
use App\Services\ProjectNavigationService;
use App\Grids\ProjectNavigationGrid;
use App\Forms\Backend\ProjectNavigationForm;

use Kris\LaravelFormBuilder\FormBuilderTrait;
use Motor\Core\Filter\Renderers\WhereRenderer;

class ProjectNavigationsController extends Controller
{
    use FormBuilderTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ProjectNavigation $record)
    {
        $grid = new ProjectNavigationGrid(ProjectNavigation::class);
        $grid->setSorting(NestedSet::LFT, 'ASC');

        $service = ProjectNavigationService::collection($grid);

        $filter = $service->getFilter();
        $filter->add(new WhereRenderer('project_id'))->setValue($record->project_id);
        $filter->add(new WhereRenderer('scope'))->setValue($record->scope);
        $filter->add(new WhereRenderer('parent_id'))->setOperator('!=')->setAllowNull(true)->setValue(null);

        $grid->filter = $filter;

        $paginator    = $service->getPaginator();

        return view('backend.project_navigations.index', compact('paginator', 'grid', 'record'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(ProjectNavigation $root)
    {
        $form = $this->form(ProjectNavigationForm::class, [
            'method'  => 'POST',
            'route'   => 'backend.project_navigations.store',
            'enctype' => 'multipart/form-data'
        ]);

        $trees = ProjectNavigation::where('scope', $root->scope)->defaultOrder()->get()->toTree();
        $newItem = true;
        $selectedItem = null;

        return view('backend.project_navigations.create', compact('form', 'trees', 'newItem', 'selectedItem', 'root'));
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
        $form = $this->form(ProjectNavigationForm::class);

        // It will automatically use current request, get the rules, and do the validation
        if ( ! $form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        $record = ProjectNavigationService::createWithForm($request, $form)->getResult();

        $root = $record->ancestors()->get()->first();

        flash()->success(trans('motor-cms::backend/navigations.created'));

        return redirect('backend/project_navigations/'.$root->id);
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
        $root = $record->ancestors()->get()->first();

        $trees = ProjectNavigation::where('scope', $root->scope)->defaultOrder()->get()->toTree();

        $form = $this->form(ProjectNavigationForm::class, [
            'method'  => 'PATCH',
            'url'     => route('backend.project_navigations.update', [ $record->id ]),
            'enctype' => 'multipart/form-data',
            'model'   => $record
        ]);

        $newItem = false;
        $selectedItem = $record->id;

        return view('backend.project_navigations.edit', compact('form', 'trees', 'root', 'newItem', 'selectedItem'));
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
        $form = $this->form(ProjectNavigationForm::class);

        // It will automatically use current request, get the rules, and do the validation
        if ( ! $form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        $record = ProjectNavigationService::updateWithForm($record, $request, $form)->getResult();

        $root = $record->ancestors()->get()->first();

        flash()->success(trans('backend/project_navigations.updated'));

        return redirect('backend/project_navigations/'.$root->id);
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

        flash()->success(trans('backend/project_navigations.deleted'));

        return redirect('backend/project_navigations');
    }
}
