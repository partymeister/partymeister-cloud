<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Motor\Backend\Models\Client;
use Motor\Core\Traits\Searchable;
use Motor\Core\Traits\Filterable;
use Culpa\Traits\Blameable;
use Culpa\Traits\CreatedBy;
use Culpa\Traits\DeletedBy;
use Culpa\Traits\UpdatedBy;

class App extends Model
{

    use Searchable;
    use Filterable;
    use Blameable, CreatedBy, UpdatedBy, DeletedBy;

    /**
     * Columns for the Blameable trait
     *
     * @var array
     */
    protected $blameable = [ 'created', 'updated', 'deleted' ];

    /**
     * Searchable columns for the searchable trait
     *
     * @var array
     */
    protected $searchableColumns = [
        'client.name',
        'project.name',
        'name',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'client_id',
        'project_id',
        'deinetickets_api_url',
        'deinetickets_api_token',
        'menu_type_url',
        'menu_structure_url'
    ];


    public function client()
    {
        return $this->belongsTo(Client::class);
    }


    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
