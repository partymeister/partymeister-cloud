<?php

namespace App\Transformers;

use League\Fractal;
use App\Models\Website;

class WebsiteTransformer extends Fractal\TransformerAbstract
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
     * @param Website $record
     *
     * @return array
     */
    public function transform(Website $record)
    {
        return [
            'id'        => (int) $record->id
        ];
    }
}
