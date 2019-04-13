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

        $paginator = $service->getPaginator();

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
     * @param \Illuminate\Http\Request $request
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
     * @param ProjectNavigation $record
     */
    public function duplicate(ProjectNavigation $record)
    {
        $tree = ProjectNavigation::where('project_id', $record->project_id)->where('scope', $record->scope)->defaultOrder()->get()->toTree();

        $cleanedTree             = [
            'name'                     => 'DUPLICATE OF ' . $tree[0]->name,
            'client_id'                => $tree[0]->client_id,
            'project_id'               => 2,
            'icon'                     => $tree[0]->icon,
            'url'                      => $tree[0]->url,
            'page'                     => str_replace('2018', '2019', $tree[0]->page),
            'function'                 => $tree[0]->function,
            'is_protected'             => $tree[0]->is_protected,
            'is_default'               => $tree[0]->is_default,
            'is_hidden_when_logged_in' => $tree[0]->is_hidden_when_logged_in,
            'is_visible_for_at_home'   => $tree[0]->is_visible_for_at_home,
            'scope'                    => $tree[0]->scope,
            'children'                 => []
        ];
        $cleanedTree['children'] = $this->recurseTree($tree, $cleanedTree['children']);
        $newTree                 = ProjectNavigation::create($cleanedTree);
        dd($newTree);
    }


    protected function recurseTree($nodes, $tree = [])
    {
        foreach ($nodes as $node) {
            $tree[] = [
                'name'                     => $node->name,
                'client_id'                => $node->client_id,
                'project_id'               => 2,
                'icon'                     => $node->icon,
                'url'                      => $node->url,
                'page'                     => str_replace('2018', '2019', $node->page),
                'function'                 => $node->function,
                'is_protected'             => $node->is_protected,
                'is_default'               => $node->is_default,
                'is_hidden_when_logged_in' => $node->is_hidden_when_logged_in,
                'is_visible_for_at_home'   => $node->is_visible_for_at_home,
                'scope'                    => $node->scope,
                'children'                 => $this->recurseTree($node->children, [])
            ];
        }

        return $tree;
    }


    /**
     * Display the specified resource.
     *
     * @param int $id
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
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(ProjectNavigation $record)
    {
        $form = $this->form(ProjectNavigationTreeForm::class, [
            'method'  => 'PATCH',
            'url'     => route('backend.project_navigation_trees.update', [$record->id]),
            'enctype' => 'multipart/form-data',
            'model'   => $record
        ]);

        return view('backend.project_navigation_trees.edit', compact('form'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
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
     * @param int $id
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
