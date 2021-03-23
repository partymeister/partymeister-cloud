<?php

namespace App\Http\Controllers\Backend;

use Motor\Backend\Http\Controllers\Controller;

use App\Models\Website;
use App\Http\Requests\Backend\WebsiteRequest;
use App\Services\WebsiteService;
use App\Grids\WebsiteGrid;
use App\Forms\Backend\WebsiteForm;

use Kris\LaravelFormBuilder\FormBuilderTrait;

class WebsitesController extends Controller
{
    use FormBuilderTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $grid = new WebsiteGrid(Website::class);

        $service = WebsiteService::collection($grid);
        $grid->setFilter($service->getFilter());
        $paginator    = $service->getPaginator();

        return view('backend.websites.index', compact('paginator', 'grid'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $form = $this->form(WebsiteForm::class, [
            'method'  => 'POST',
            'route'   => 'backend.websites.store',
            'enctype' => 'multipart/form-data'
        ]);

        return view('backend.websites.create', compact('form'));
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
        $form = $this->form(WebsiteForm::class);

        // It will automatically use current request, get the rules, and do the validation
        if ( ! $form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        WebsiteService::createWithForm($request, $form);

        flash()->success(trans('backend/websites.created'));

        return redirect('backend/websites');
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
    public function edit(Website $record)
    {
        $form = $this->form(WebsiteForm::class, [
            'method'  => 'PATCH',
            'url'     => route('backend.websites.update', [ $record->id ]),
            'enctype' => 'multipart/form-data',
            'model'   => $record
        ]);

        return view('backend.websites.edit', compact('form'));
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
        $form = $this->form(WebsiteForm::class);

        // It will automatically use current request, get the rules, and do the validation
        if ( ! $form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        WebsiteService::updateWithForm($record, $request, $form);

        flash()->success(trans('backend/websites.updated'));

        return redirect('backend/websites');
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
        WebsiteService::delete($record);

        flash()->success(trans('backend/websites.deleted'));

        return redirect('backend/websites');
    }
}
