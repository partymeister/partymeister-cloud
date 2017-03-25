<?php

namespace App\Transformers;

use League\Fractal;
use App\Models\Project;

class ProjectTransformer extends Fractal\TransformerAbstract
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
     * @param Project $record
     *
     * @return array
     */
    public function transform(Project $record)
    {
        return [
            'id'        => (int) $record->id
        ];
    }
}
