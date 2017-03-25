<?php

namespace App\Services;

use App\Models\Website;
use Motor\Backend\Services\BaseService;

class WebsiteService extends BaseService
{

    protected $model = Website::class;


    public function filters()
    {
        $this->filter->addClientFilter();
    }
}
