<?php

namespace App\Services;

use App\Models\Project;
use Illuminate\Support\Str;
use Motor\Backend\Services\BaseService;

class ProjectService extends BaseService
{

    protected $model = Project::class;


    public function filters()
    {
        $this->filter->addClientFilter();
    }


    public function beforeCreate()
    {
        $this->record->api_token = Str::random(60);
    }
}
