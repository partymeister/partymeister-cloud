<?php

namespace App\Grids;

use Motor\Backend\Grid\Grid;

class ProjectNavigationTreeGrid extends Grid
{

    protected function setup()
    {
        $this->addColumn('client.name', trans(trans('motor-backend::backend/clients.client')));
        $this->addColumn('name', trans('backend/project_navigation_trees.name'));
        $this->addColumn('project.name', trans('backend/projects.project'));
        $this->addAction(trans('backend/project_navigation_trees.show_nodes'), 'backend.project_navigations.index', ['class' => 'btn-primary']);
        $this->addEditAction(trans('motor-backend::backend/global.edit'), 'backend.project_navigation_trees.edit')->onCondition('parent_id', null);
        $this->addDeleteAction(trans('motor-backend::backend/global.delete'), 'backend.project_navigation_trees.destroy')->onCondition('parent_id', null);
    }
}
