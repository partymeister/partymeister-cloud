<?php

namespace App\Forms\Backend;

use App\Models\Project;
use Kris\LaravelFormBuilder\Form;

class AppForm extends Form
{
    public function buildForm()
    {
        $clients = config('motor-backend.models.client')::pluck('name', 'id')->toArray();
        $this
            ->add('client_id', 'select', ['label' => trans('motor-backend::backend/clients.client'), 'rules' => 'required', 'choices' => $clients])
            ->add('project_id', 'select', ['label' => trans('backend/projects.project'), 'rules' => 'required', 'choices' => Project::pluck('name', 'id')->toArray()])
            ->add('name', 'text', ['label' => trans('motor-backend::backend/global.name'), 'rules' => 'required'])

            ->add('deinetickets_api_url', 'text', ['label' => trans('backend/apps.deinetickets_api_url')])
            ->add('deinetickets_api_token', 'text', ['label' => trans('backend/apps.deinetickets_api_token')])
            ->add('menu_type_url', 'text', ['label' => trans('backend/apps.menu_type_url')])
            ->add('menu_structure_url', 'text', ['label' => trans('backend/apps.menu_structure_url')])

            ->add('submit', 'submit', ['attr' => ['class' => 'btn btn-primary'], 'label' => trans('backend/apps.save')]);
    }
}
