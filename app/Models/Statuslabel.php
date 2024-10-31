<?php

namespace App\Models;

use App\Http\Traits\UniqueUndeletedTrait;
use App\Models\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Watson\Validating\ValidatingTrait;

class Statuslabel extends SnipeModel
{
    use HasFactory;
    use SoftDeletes;
    use ValidatingTrait;
    use UniqueUndeletedTrait;

    protected $injectUniqueIdentifier = true;

    protected $table = 'status_labels';
    protected $hidden = ['user_id', 'deleted_at'];

    protected $rules = [
        'name'  => 'required|string|unique_undeleted',
        'notes'   => 'string|nullable',
        'status_type' => 'required|in:deployable,pending,archived,undeployable1',
    ];

    protected $fillable = [
        'status_type',
        'name',
        'notes',
        'color',
        'show_in_nav',
        'default_label',
    ];

    use Searchable;

    /**
     * The attributes that should be included when searching the model.
     *
     * @var array
     */
    protected $searchableAttributes = ['name', 'notes'];

    /**
     * The relations and their attributes that should be included when searching the model.
     *
     * @var array
     */
    protected $searchableRelations = [];

    /**
     * Establishes the status label -> assets relationship
     *
     * @author A. Gianotto <snipe@snipe.net>
     * @since [v1.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function assets()
    {
        return $this->hasMany(\App\Models\Asset::class, 'status_id');
    }

    public function adminuser()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by');
    }

    /**
     * Gets the status label type
     *
     * @author A. Gianotto <snipe@snipe.net>
     * @since [v1.0]
     * @return string
     */

    /**
     * Query builder scope for undeployable status types
     *
     * @return \Illuminate\Database\Query\Builder Modified query builder
     */
    public function scopeUndeployable()
    {
        return $this->whereNot('status_type', '=', 'deployable');
    }



    public function scopeOrderByCreatedBy($query, $order)
    {
        return $query->leftJoin('users as admin_sort', 'status_labels.created_by', '=', 'admin_sort.id')->select('status_labels.*')->orderBy('admin_sort.first_name', $order)->orderBy('admin_sort.last_name', $order);
    }
}
