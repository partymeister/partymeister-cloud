<?php

namespace App\Transformers;

use League\Fractal;
use App\Models\ProjectNavigationTree;

class ProjectNavigationTreeTransformer extends Fractal\TransformerAbstract
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
     * @param ProjectNavigationTree $record
     *
     * @return array
     */
    public function transform(ProjectNavigationTree $record)
    {
        return [
            'id'        => (int) $record->id
        ];
    }
}
