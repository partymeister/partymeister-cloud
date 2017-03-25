<?php

namespace App\Transformers;

use League\Fractal;
use App\Models\App;

class AppTransformer extends Fractal\TransformerAbstract
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
     * @param App $record
     *
     * @return array
     */
    public function transform(App $record)
    {
        return [
            'id'        => (int) $record->id
        ];
    }
}
