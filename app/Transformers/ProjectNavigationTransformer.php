<?php

namespace App\Transformers;

use League\Fractal;
use App\Models\ProjectNavigation;

class ProjectNavigationTransformer extends Fractal\TransformerAbstract
{

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [];


    /**
     * Transform record to array
     *
     * @param ProjectNavigation $record
     *
     * @return array
     */
    public function transform(ProjectNavigation $record)
    {
        $data = [
            'name'                     => $record->name,
            'icon'                     => $record->icon,
            'url'                      => $record->url,
            'page'                     => $record->page,
            'call_function'            => $record->function,
            'is_default'               => (bool) $record->is_default,
            'is_protected'             => (bool) $record->is_protected,
            'is_hidden_when_logged_in' => (bool) $record->is_hidden_when_logged_in,
            'is_visible_for_at_home'   => (bool) $record->is_visible_for_at_home,
            'items'                    => []
        ];
        foreach ($record->children()->orderBy('_lft')->get() as $child) {
            $data['items'][] = $this->transform($child);
        }

        return $data;
    }
}
