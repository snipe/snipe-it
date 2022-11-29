<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends SnipeModel
{
    use HasFactory;

        /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'purchase_orders';

        /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

        /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';


    /**
     * Category validation rules
     */
    public $rules = [        
        'suplier_id'    => 'required|integer|exists:suppliers,id',
        'name'          => 'required|min:1|max:255',
        'state'         => 'required'
    ];


     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id',
        'location_id'          
    ];


        /**
     * Get the post that owns the comment.
     */
    public function suppiler()
    {
        return $this->belongsTo(Supplier::class);
    }

}