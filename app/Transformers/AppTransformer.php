<?php

namespace App\Transformers;

use App\Models\ProjectNavigation;
use League\Fractal;
use App\Models\App;
use Motor\Backend\Helpers\MediaHelper;

class AppTransformer extends Fractal\TransformerAbstract
{

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [ 'remote_navigation', 'local_navigation' ];

    protected $defaultIncludes = [ 'remote_navigation', 'local_navigation' ];


    /**
     * Transform record to array
     *
     * @param App $record
     *
     * @return array
     */
    public function transform(App $record)
    {
        return [
            'name'                 => $record->name,
            'name_slug'            => str_slug($record->name),
            'onesignal_ios'        => $record->onesignal_ios,
            'onesignal_android'    => $record->onesignal_android,
            'website_api_base_url' => $record->website_api_base_url,
            'local_api_base_url'   => $record->local_api_base_url,
            'intro_text_1'         => $record->intro_text_1,
            'intro_text_2'         => $record->intro_text_2,
            'intro_text_3'         => $record->intro_text_3,
            'intro_text_4'         => $record->intro_text_4,
            'logo'                 => MediaHelper::getFileInformation($record, 'logo'),
            'menu_header'          => MediaHelper::getFileInformation($record, 'menu_header'),
            'menu_bg'              => MediaHelper::getFileInformation($record, 'menu_bg'),
            'page_bg'              => MediaHelper::getFileInformation($record, 'page_bg'),
            'intro_bg_1'           => MediaHelper::getFileInformation($record, 'intro_bg_1'),
            'intro_bg_2'           => MediaHelper::getFileInformation($record, 'intro_bg_2'),
            'intro_bg_3'           => MediaHelper::getFileInformation($record, 'intro_bg_3'),
            'intro_bg_4'           => MediaHelper::getFileInformation($record, 'intro_bg_4'),
        ];
    }


    /**
     * Include remote navigation
     *
     * @return \League\Fractal\Resource\Collection
     */
    public function includeRemoteNavigation(App $record)
    {
        $remoteNavigation = ProjectNavigation::where('project_id', $record->project_id)->where('scope',
            'remote_navigation')->where('parent_id', null)->first();

        if ( ! is_null($remoteNavigation)) {
            return $this->collection($remoteNavigation->children, new ProjectNavigationTransformer());
        }
    }


    /**
     * Include local navigation
     *
     * @return \League\Fractal\Resource\Collection
     */
    public function includeLocalNavigation(App $record)
    {
        // HARDCODED FOR REVISION 2019 / 2020 ANDROID APP!
        $localNavigation = ProjectNavigation::where('project_id', 1)->where('scope',
            'local_navigation')->where('parent_id', null)->first();

        if ( ! is_null($localNavigation)) {
            return $this->collection($localNavigation->children()->orderBy('_lft')->get(), new ProjectNavigationTransformer());
        }
    }
}
