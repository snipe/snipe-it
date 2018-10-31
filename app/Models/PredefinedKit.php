<?php
namespace App\Models;

use App\Http\Traits\UniqueUndeletedTrait;
use App\Models\SnipeModel;
use App\Models\Traits\Searchable;
use App\Presenters\Presentable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Watson\Validating\ValidatingTrait;

/**
 * Model for Categories. Categories are a higher-level group
 * than Asset Models, and handle things like whether or not
 * to require acceptance from the user, whether or not to
 * send a EULA to the user, etc.
 *
 * @version    v1.0
 */
class PredefinedKit extends SnipeModel
{
    protected $presenter = 'App\Presenters\PredefinedKitPresenter';
    use Presentable;
    protected $table = 'kits';

    /**
    * Category validation rules
    */
    public $rules = array(
        'name'   => 'required|min:1|max:255|unique'
    );

    use ValidatingTrait;

    public $modelRules = [
        'model_id' => 'required|exists:models,id',
        'quantity' => 'required|integer|min:1',
        'pivot_id' => 'integer|exists:kits_models,id'
    ];

    public $licenseRules = [
        'license_id' => 'required|exists:licenses,id',
        'quantity' => 'required|integer|min:1',
        'pivot_id' => 'integer|exists:kits_licenses,id'
    ];


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    use Searchable;
    
    /**
     * The attributes that should be included when searching the model.
     * 
     * @var array
     */
    protected $searchableAttributes = ['name'];

    /**
     * The relations and their attributes that should be included when searching the model.
     * 
     * @var array
     */
    protected $searchableRelations = [];


    /**
     * Establishes the kits -> models relationship
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v2.0]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function models()
    {
        return $this->belongsToMany('\App\Models\AssetModel', 'kits_models', 'kit_id', 'model_id')->withPivot('id', 'quantity');
    }

    /**
     * Establishes the kits -> licenses relationship
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.3]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function licenses()
    {
        return $this->belongsToMany('\App\Models\License', 'kits_licenses', 'kit_id', 'license_id')->withPivot('id', 'quantity');
    }



    /**
     * -----------------------------------------------
     * BEGIN QUERY SCOPES
     * -----------------------------------------------
     **/

}
