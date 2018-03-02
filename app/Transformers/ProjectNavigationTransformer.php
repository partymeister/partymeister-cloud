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
        return [
            'id'        => (int) $record->id
        ];
    }
}
