<?php

namespace App\Grids;

use Motor\Backend\Grid\Grid;

class ProjectGrid extends Grid
{

    protected function setup()
    {
        $this->addColumn('id', 'ID', true);
        $this->setDefaultSorting('id', 'ASC');
        $this->addColumn('client.name', trans('motor-backend::backend/clients.client'));
        $this->addColumn('name', trans('motor-backend::backend/global.name'));
        $this->addEditAction(trans('motor-backend::backend/global.edit'), 'backend.projects.edit');
        $this->addDeleteAction(trans('motor-backend::backend/global.delete'), 'backend.projects.destroy');
    }
}
