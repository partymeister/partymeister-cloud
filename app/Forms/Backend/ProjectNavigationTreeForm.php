<?php

namespace App\Forms\Backend;

use App\Models\Project;
use Kris\LaravelFormBuilder\Form;

class ProjectNavigationTreeForm extends Form
{
    public function buildForm()
    {
        $clients = config('motor-backend.models.client')::pluck('name', 'id')->toArray();
        $this
            ->add('client_id', 'select', ['label' => trans('motor-backend::backend/clients.client'), 'choices' => $clients, 'empty_value' => trans('motor-backend::backend/global.please_choose')])
            ->add('project_id', 'select', ['label' => trans('backend/projects.project'), 'choices' => Project::pluck('name', 'id')->toArray(), 'empty_value' => trans('motor-backend::backend/global.please_choose')])
            ->add('name', 'text', ['label' => trans('backend/project_navigations.name'), 'rules' => 'required'])
            ->add('scope', 'text', ['label' => trans('backend/project_navigation_trees.scope'), 'rules' => 'required'])
            ->add('submit', 'submit', ['attr' => ['class' => 'btn btn-primary'], 'label' => trans('backend/project_navigation_trees.save')]);
    }
}
