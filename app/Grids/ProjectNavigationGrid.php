<?php

namespace App\Grids;

use Motor\Backend\Grid\Grid;
use Motor\Backend\Grid\Renderers\BooleanRenderer;
use Motor\Backend\Grid\Renderers\TreeRenderer;

class ProjectNavigationGrid extends Grid
{

    protected function setup()
    {
        $this->addColumn('name', trans('motor-cms::backend/navigations.name'))->renderer(TreeRenderer::class);
        $this->addColumn('is_protected', trans('backend/project_navigations.is_protected'))->renderer(BooleanRenderer::class);
        $this->addColumn('is_hidden_when_logged_in', trans('backend/project_navigations.is_hidden_when_logged_in'))->renderer(BooleanRenderer::class);
        $this->addColumn('is_visible_for_at_home', trans('backend/project_navigations.is_visible_for_at_home'))->renderer(BooleanRenderer::class);

        $this->addEditAction(trans('motor-backend::backend/global.edit'), 'backend.project_navigations.edit')->onCondition('parent_id', null, '!=');
        $this->addDeleteAction(trans('motor-backend::backend/global.delete'), 'backend.project_navigations.destroy')->onCondition('parent_id', null, '!=');
    }
}
