<?php
namespace App\Models;

use App\Http\Traits\UniqueUndeletedTrait;
use App\Models\SnipeModel;
use App\Models\Traits\Searchable;
use App\Presenters\Presentable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Watson\Validating\ValidatingTrait;
use Illuminate\Validation\Rule;

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
        // 'model_id' => [
        //     'required',
        //     'exists:models,id',
        //     Rule::unique('kits_models')->where('model_id', $model_id)->whereNot('kit_id', $this->id)
        // ],
        'quantity' => 'required|integer|min:1',
        'pivot_id' => 'integer|exists:kits_models,id'
    ];

    public function makeModelRules($model_id, $new = false) {
        // return [
        //     // 'model_id' => 'required|exists:models,id',
        //     'model_id' => [
        //         'required',
        //         'exists:models,id',
        //         Rule::unique('kits_models')->whereNot('model_id', $model_id)->where('kit_id', $this->id)
        //     ],
        //     'quantity' => 'required|integer|min:1',
        //     'pivot_id' => 'integer|exists:kits_models,id'
        // ];
        return $this->_makeRuleHelper('licenses', 'kits_licenses', 'license_id', $license_id, $new);
    }

    public function makeLicenseRules($license_id, $new = false) {
        return $this->_makeRuleHelper('licenses', 'kits_licenses', 'license_id', $license_id, $new);
    }

    public function makeAccessoriesRules($accessoriy_id, $new = false) {
        return $this->_makeRuleHelper('accessories', 'kits_accessories', 'accessoriy_id', $accessoriy_id, $new);
    }
    
    public function makeConsumablesRules($consumable_id, $new = false) {
        return $this->_makeRuleHelper('consumables', 'kits_consumables', 'consumable_id', $consumable_id, $new);
    }

    protected function _makeRuleHelper($table, $pivot_table, $pivot_elem_key, $element_id, $new) {
        // return [
        //     $pivot_elem_key => [
        //         'required',
        //         "exists:$table,id",
        //         Rule::unique($pivot_table)->whereNot($pivot_elem_key, $element_id)->where('kit_id', $this->id)
        //     ],
        //     'quantity' => 'required|integer|min:1',
        //     'pivot_id' => "integer|exists:$pivot_table,id"
        // ];
        $rule = [
            $pivot_elem_key => [
                'required',
                "exists:$table,id",
                Rule::unique($pivot_table)->whereNot($pivot_elem_key, $element_id)->where('kit_id', $this->id)
            ],
            'quantity' => 'required|integer|min:1'
        ];
        if(!$new) {
            $rule['pivot_id'] = "integer|exists:$pivot_table,id";
            
        }
        return $rule;
    }

    // public $licenseRules = [
    //     'license_id' => 'required|exists:licenses,id',
    //     'quantity' => 'required|integer|min:1',
    //     'pivot_id' => 'integer|exists:kits_licenses,id'
    // ];


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

    public function assets()
    {
        return $this->hasManyThrough('\App\Models\Asset', '\App\Models\AssetModel', 'country_id', 'user_id');
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
     * Establishes the kits -> licenses relationship
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.3]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function consumables()
    {
        return $this->belongsToMany('\App\Models\Consumable', 'kits_consumables', 'kit_id', 'consumable_id')->withPivot('id', 'quantity');
    }

    /**
    * Establishes the kits -> licenses relationship
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v4.3]
    * @return \Illuminate\Database\Eloquent\Relations\Relation
    */
    public function accessories()
    {
        return $this->belongsToMany('\App\Models\Accessory', 'kits_accessories', 'kit_id', 'accessory_id')->withPivot('id', 'quantity');
    }

    /**
     * -----------------------------------------------
     * BEGIN QUERY SCOPES
     * -----------------------------------------------
     **/

}
