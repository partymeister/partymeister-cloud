<?php

namespace App\Forms\Backend;

use App\Models\Project;
use Kris\LaravelFormBuilder\Form;

class ProjectNavigationForm extends Form
{
    public function buildForm()
    {
        $clients = config('motor-backend.models.client')::pluck('name', 'id')->toArray();
        $this
            ->add('parent_id', 'hidden')
            ->add('previous_sibling_id', 'hidden')
            ->add('next_sibling_id', 'hidden')
            ->add('name', 'text', ['label' => trans('backend/project_navigations.name'), 'rules' => 'required'])
            ->add('icon', 'text', ['label' => trans('backend/project_navigations.icon'), 'rules' => 'required'])
            ->add('page', 'text', ['label' => trans('backend/project_navigations.page'), 'rules' => 'required'])
            ->add('url', 'text', ['label' => trans('backend/project_navigations.url')])
            ->add('function', 'text', ['label' => trans('backend/project_navigations.function')])
            ->add('is_protected', 'checkbox', ['label' => trans('backend/project_navigations.is_protected')])
            ->add('is_hidden_when_logged_in', 'checkbox', ['label' => trans('backend/project_navigations.is_hidden_when_logged_in')])
            ->add('is_visible_for_at_home', 'checkbox', ['label' => trans('backend/project_navigations.is_visible_for_at_home')])
            ->add('submit', 'submit', ['attr' => ['class' => 'btn btn-primary'], 'label' => trans('backend/project_navigations.save')]);
    }
}
