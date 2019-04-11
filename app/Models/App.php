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

use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class App extends Model implements HasMedia
{

    use HasMediaTrait;
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
        'onesignal_ios',
        'onesignal_android',
        'website_api_base_url',
        'local_api_base_url',
        'intro_text_1',
        'intro_text_2',
        'intro_text_3',
        'intro_text_4',
        'menu_type_url',
        'menu_structure_url'
    ];


    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')->width(400)->height(400)->nonQueued();
        $this->addMediaConversion('preview')->width(400)->height(400)->format('png')->nonQueued();
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }


    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}