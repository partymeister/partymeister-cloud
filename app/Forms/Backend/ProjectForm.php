<?php

namespace App\Forms\Backend;

use Kris\LaravelFormBuilder\Form;

class ProjectForm extends Form
{
    public function buildForm()
    {
        $clients = config('motor-backend.models.client')::pluck('name', 'id')->toArray();
        $this
            ->add('client_id', 'select', ['label' => trans('motor-backend::backend/clients.client'), 'rules' => 'required', 'choices' => $clients])
            ->add('name', 'text', ['label' => trans('motor-backend::backend/global.name'), 'rules' => 'required'])

            ->add('subdomain', 'text', ['label' => trans('backend/projects.subdomain')])
            ->add('api_token', 'static', ['label' => trans('backend/projects.api_token')])

            ->add('submit', 'submit', ['attr' => ['class' => 'btn btn-primary'], 'label' => trans('backend/projects.save')]);
    }
}
