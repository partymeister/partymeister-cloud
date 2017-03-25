<?php

namespace App\Grids;

use Motor\Backend\Grid\Grid;

class AppGrid extends Grid
{

    protected function setup()
    {
        $this->addColumn('id', 'ID', true);
        $this->setDefaultSorting('id', 'ASC');
        $this->addColumn('client.name', trans('motor-backend::backend/clients.client'));
        $this->addColumn('project.name', trans('backend/projects.project'));
        $this->addColumn('name', trans('motor-backend::backend/global.name'));
        $this->addEditAction(trans('motor-backend::backend/global.edit'), 'backend.apps.edit');
        $this->addDeleteAction(trans('motor-backend::backend/global.delete'), 'backend.apps.destroy');
    }
}
