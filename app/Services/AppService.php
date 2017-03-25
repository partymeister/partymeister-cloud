<?php

namespace App\Services;

use App\Models\App;
use Motor\Backend\Services\BaseService;

class AppService extends BaseService
{

    protected $model = App::class;


    public function filters()
    {
        $this->filter->addClientFilter();
    }
}
