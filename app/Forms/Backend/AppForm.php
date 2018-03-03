<?php

namespace App\Forms\Backend;

use App\Models\App;
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

            ->add('onesignal_ios', 'text', ['label' => trans('backend/apps.onesignal_ios')])
            ->add('onesignal_android', 'text', ['label' => trans('backend/apps.onesignal_android')])

            ->add('website_api_base_url', 'text', ['label' => trans('backend/apps.website_api_base_url')])
            ->add('local_api_base_url', 'text', ['label' => trans('backend/apps.local_api_base_url')])

            ->add('intro_text_1', 'htmleditor', ['label' => trans('backend/apps.intro_text_1'), 'format' => true])
            ->add('intro_text_2', 'htmleditor', ['label' => trans('backend/apps.intro_text_2'), 'format' => true])
            ->add('intro_text_3', 'htmleditor', ['label' => trans('backend/apps.intro_text_3'), 'format' => true])
            ->add('intro_text_4', 'htmleditor', ['label' => trans('backend/apps.intro_text_4'), 'format' => true])

            //->add('menu_type_url', 'text', ['label' => trans('backend/apps.menu_type_url')])
            //->add('menu_structure_url', 'text', ['label' => trans('backend/apps.menu_structure_url')])

            ->add('logo', 'file_image', ['label' =>  trans('backend/apps.logo'), 'model' => App::class])
            ->add('menu_header', 'file_image', ['label' =>  trans('backend/apps.menu_header'), 'model' => App::class])
            ->add('menu_bg', 'file_image', ['label' =>  trans('backend/apps.menu_bg'), 'model' => App::class])
            ->add('page_bg', 'file_image', ['label' =>  trans('backend/apps.page_bg'), 'model' => App::class])
            ->add('intro_bg_1', 'file_image', ['label' =>  trans('backend/apps.intro_bg_1'), 'model' => App::class])
            ->add('intro_bg_2', 'file_image', ['label' =>  trans('backend/apps.intro_bg_2'), 'model' => App::class])
            ->add('intro_bg_3', 'file_image', ['label' =>  trans('backend/apps.intro_bg_3'), 'model' => App::class])
            ->add('intro_bg_4', 'file_image', ['label' =>  trans('backend/apps.intro_bg_4'), 'model' => App::class])

            ->add('submit', 'submit', ['attr' => ['class' => 'btn btn-primary'], 'label' => trans('backend/apps.save')]);
    }
}
