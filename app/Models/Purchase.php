<?php


namespace App\Models;


use App\Http\Traits\UniqueUndeletedTrait;
use App\Models\Traits\Searchable;
use App\Presenters\Presentable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Watson\Validating\ValidatingTrait;

class Purchase extends SnipeModel
{
    protected $presenter = 'App\Presenters\PurchasePresenter';
    use Presentable;
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'purchases';
    protected $rules = array(
        'invoice_number'        => 'required|min:1|max:255|unique_undeleted',
        'final_price'        => 'required',
        'supplier_id'        => 'required',
        'comment'        => 'required',
        'currency'        => 'required',
        'legal_person_id'=> 'required',
        'invoice_type_id'=> 'required',
        'invoice_file'=> 'required',
        'bitrix_id'  => 'min:1|max:10|nullable'
    );

    /**
     * Whether the model should inject it's identifier to the unique
     * validation rules before attempting validation. If this property
     * is not set in the model it will default to true.
     *
     * @var boolean
     */
    protected $injectUniqueIdentifier = true;
    use ValidatingTrait;
    use UniqueUndeletedTrait;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'invoice_number',
        'invoice_file',
        'bitrix_id',
        'final_price',
        'paid',
        'supplier_id',
        'legal_person_id',
        'invoice_type_id',
        'comment',
        "currency"
    ];

    use Searchable;

    /**
     * The attributes that should be included when searching the model.
     *
     * @var array
     */
    protected $searchableAttributes = ['invoice_number', 'bitrix_id', 'supplier_id', 'created_at'];

    /**
     * The relations and their attributes that should be included when searching the model.
     *
     * @var array
     */
    protected $searchableRelations = [
        'parent' => ['name']
    ];


    public function assets()
    {
        return $this->hasMany('\App\Models\Asset', 'purchase_id')
            ->whereHas('assetstatus', function ($query) {
                $query->where('status_labels.deployable', '=', 1)
                    ->orWhere('status_labels.pending', '=', 1)
                    ->orWhere('status_labels.archived', '=', 0);
            });
    }

    public function supplier()
    {
        return $this->belongsTo('\App\Models\Supplier');
    }

    public function invoice_type()
    {
        return $this->belongsTo('\App\Models\InvoiceType');
    }

    public function legal_person()
    {
        return $this->belongsTo('\App\Models\LegalPerson');
    }


    public function getInvoiceFile()
    {
        if ($this->invoice_file && !empty($this->invoice_file)) {
            return url('/').'/uploads/purchases/'.$this->invoice_file;
        }
        return false;
    }

}