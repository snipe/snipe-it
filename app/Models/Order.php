<?php

namespace App\Models;

//use App\Http\Requests\Request;
use Illuminate\Http\Request; //FIXME - which request to use?!?!!?
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['order_number'];

    //TODO - should this go in a formrequest or something?
    //TODO - I feel slightly oogie having a *model* that's looking at a *request* ...
    public static function ensure(Request $request, $input_name): ?int
    {
        if($request->input($input_name) == '') {
            return null;
        }
        if($request->input($input_name) && $request->input($input_name) != -1) {
            return $request->input($input_name);
        }
        return Order::firstOrCreate(['order_number' => $request->input($input_name."_new_order")])->id;
    }


    function assets() {
        return $this->hasMany(Asset::class);
    }

    function components() {
        return $this->hasMany(Component::class);
    }

    function licenses() {
        return $this->hasMany(License::class);
    }

    function  accessories() {
        return $this->hasMany(Accessory::class);
    }

    function consumables() {
        return $this->hasMany(Consumable::class);
    }
}
