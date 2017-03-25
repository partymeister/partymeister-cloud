<?php

namespace App\Http\Controllers\Backend;

use Motor\Backend\Http\Controllers\Controller;

use App\Models\App;
use App\Http\Requests\Backend\AppRequest;
use App\Services\AppService;
use App\Grids\AppGrid;
use App\Forms\Backend\AppForm;

use Kris\LaravelFormBuilder\FormBuilderTrait;

class AppsController extends Controller
{
    use FormBuilderTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $grid = new AppGrid(App::class);

        $service = AppService::collection($grid);
        $grid->filter = $service->getFilter();
        $paginator    = $service->getPaginator();

        return view('backend.apps.index', compact('paginator', 'grid'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $form = $this->form(AppForm::class, [
            'method'  => 'POST',
            'route'   => 'backend.apps.store',
            'enctype' => 'multipart/form-data'
        ]);

        return view('backend.apps.create', compact('form'));
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
        $form = $this->form(AppForm::class);

        // It will automatically use current request, get the rules, and do the validation
        if ( ! $form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        AppService::createWithForm($request, $form);

        flash()->success(trans('backend/apps.created'));

        return redirect('backend/apps');
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
    public function edit(App $record)
    {
        $form = $this->form(AppForm::class, [
            'method'  => 'PATCH',
            'url'     => route('backend.apps.update', [ $record->id ]),
            'enctype' => 'multipart/form-data',
            'model'   => $record
        ]);

        return view('backend.apps.edit', compact('form'));
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
        $form = $this->form(AppForm::class);

        // It will automatically use current request, get the rules, and do the validation
        if ( ! $form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        AppService::updateWithForm($record, $request, $form);

        flash()->success(trans('backend/apps.updated'));

        return redirect('backend/apps');
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
        AppService::delete($record);

        flash()->success(trans('backend/apps.deleted'));

        return redirect('backend/apps');
    }
}
