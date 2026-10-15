<?php

namespace App\Models;

use App\Presenters\MaintenanceTypePresenter;
use App\Presenters\Presentable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Gate;
use Watson\Validating\ValidatingTrait;

/**
 * @mixin IdeHelperMaintenanceType
 */
class MaintenanceType extends SnipeModel
{
    use HasFactory;
    use Presentable;
    use SoftDeletes;
    use ValidatingTrait;

    protected $presenter = MaintenanceTypePresenter::class;

    protected $table = 'maintenance_types';

    protected $rules = [
        'name' => 'required|max:100|unique:maintenance_types,name,NULL,id,deleted_at,NULL',
    ];

    protected $injectUniqueIdentifier = true;

    protected $fillable = ['name', 'tag_color'];

    public function isDeletable(): bool
    {
        return Gate::allows('delete', $this)
            && ($this->deleted_at == '')
            && $this->maintenances()->doesntExist();
    }

    public function maintenances()
    {
        return $this->hasMany(Maintenance::class, 'maintenance_type_id');
    }

    public function adminuser()
    {
        return $this->belongsTo(User::class, 'created_by')->withTrashed();
    }

    public function getDisplayNameAttribute(): string
    {
        return $this->name;
    }
}
