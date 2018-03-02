<?php

namespace App\Services;

use App\Models\App;
use Motor\Backend\Services\BaseService;

class AppService extends BaseService
{

    protected $model = App::class;


    public function afterCreate()
    {
        $this->uploadMedia();
    }


    public function afterUpdate()
    {
        $this->uploadMedia();
    }


    protected function uploadMedia()
    {
        $this->uploadFile($this->request->file('logo'), 'logo');
        $this->uploadFile($this->request->file('menu_header'), 'menu_header');
        $this->uploadFile($this->request->file('menu_bg'), 'menu_bg');
        $this->uploadFile($this->request->file('page_bg'), 'page_bg');
        $this->uploadFile($this->request->file('intro_bg_1'), 'intro_bg_1');
        $this->uploadFile($this->request->file('intro_bg_2'), 'intro_bg_2');
        $this->uploadFile($this->request->file('intro_bg_3'), 'intro_bg_3');
        $this->uploadFile($this->request->file('intro_bg_4'), 'intro_bg_4');
    }


    public function filters()
    {
        $this->filter->addClientFilter();
    }
}
