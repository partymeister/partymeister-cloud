<?php

namespace App\Forms\Backend;

use App\Models\Project;
use Kris\LaravelFormBuilder\Form;

class WebsiteForm extends Form
{
    public function buildForm()
    {
        $clients = config('motor-backend.models.client')::pluck('name', 'id')->toArray();
        $this
            ->add('client_id', 'select', ['label' => trans('motor-backend::backend/clients.client'), 'rules' => 'required', 'choices' => $clients])
            ->add('project_id', 'select', ['label' => trans('backend/projects.project'), 'rules' => 'required', 'choices' => Project::pluck('name', 'id')->toArray()])
            ->add('name', 'text', ['label' => trans('motor-backend::backend/global.name'), 'rules' => 'required'])

            ->add('submit', 'submit', ['attr' => ['class' => 'btn btn-primary'], 'label' => trans('backend/websites.save')]);
    }
}
