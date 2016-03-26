<?php
namespace App\Helpers;

use DB;
use App\Models\Statuslabel;
use App\Models\Location;
use App\Models\Company;
use App\Models\User;
use App\Models\Manufacturer;
use App\Models\Supplier;
use App\Models\Category;
use App\Models\Depreciation;
use App\Models\CustomFieldset;
use App\Models\CustomField;
use App\Models\Component;
use App\Models\Accessory;
use App\Models\Consumable;
use App\Models\Asset;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Helper
{

   // This doesn't do anything yet
    public static function parseEmailList($emails)
    {
        $emails_array = explode(',', $emails);
        return array_walk($emails_array, 'trim_value');
    }

   // This doesn't do anything yet
    public static function trim_value(&$value)
    {
        return trim($value);
    }

    public static function ParseFloat($floatString)
    {
        // use comma for thousands until local info is property used
        $LocaleInfo = localeconv();
        $floatString = str_replace(",", "", $floatString);
        $floatString = str_replace($LocaleInfo["decimal_point"], ".", $floatString);
        return floatval($floatString);
    }


    public static function modelList()
    {
        $model_list = array('' => trans('general.select_model')) + DB::table('models')
        ->select(DB::raw('IF (modelno="" OR modelno IS NULL,name,concat(name, " / ",modelno)) as name, id'))
        ->orderBy('name', 'asc')
        ->whereNull('deleted_at')
        ->pluck('name', 'id');
        return $model_list;
    }

    public static function companyList()
    {
        $company_list = array('0' => trans('general.select_company')) + DB::table('companies')
        ->orderBy('name', 'asc')
        ->pluck('name', 'id');
        return $company_list;
    }


    public static function categoryList()
    {
        $category_list = array('' => '') + Category::orderBy('name', 'asc')
        ->whereNull('deleted_at')
        ->orderBy('name', 'asc')
        ->pluck('name', 'id')->toArray();
        return $category_list;
    }

    public static function suppliersList()
    {
        $supplier_list = array('' => trans('general.select_supplier')) + Supplier::orderBy('name', 'asc')
        ->orderBy('name', 'asc')
        ->pluck('name', 'id')->toArray();
        return $supplier_list;
    }

    public static function statusLabelList()
    {
        $statuslabel_list = array('' => trans('general.select_statuslabel')) + Statuslabel::orderBy('name', 'asc')
        ->pluck('name', 'id')->toArray();
        return $statuslabel_list;
    }

    public static function locationsList()
    {
        $location_list = array('' => trans('general.select_location')) + Location::orderBy('name', 'asc')
        ->pluck('name', 'id')->toArray();
        return $location_list;
    }

    public static function manufacturerList()
    {
        $manufacturer_list = array('' => 'Select One') +
        Manufacturer::orderBy('name', 'asc')
        ->pluck('name', 'id')->toArray();
        return $manufacturer_list;
    }

    public static function statusTypeList()
    {
        $statuslabel_types = array('' => trans('admin/hardware/form.select_statustype')) + array('undeployable' => trans('admin/hardware/general.undeployable')) + array('pending' => trans('admin/hardware/general.pending')) + array('archived' => trans('admin/hardware/general.archived')) + array('deployable' => trans('admin/hardware/general.deployable'));
        return $statuslabel_types;
    }

    public static function managerList()
    {
        $manager_list = array('' => '') + User::select(DB::raw('concat(last_name,", ",first_name," (",username,")") as full_name, id'))
        ->whereNull('deleted_at', 'and')
        ->orderBy('last_name', 'asc')
        ->orderBy('first_name', 'asc')
        ->pluck('full_name', 'id')->toArray();
        return $manager_list;
    }

    public static function depreciationList()
    {
        $depreciation_list = ['' => 'Do Not Depreciate'] + Depreciation::orderBy('name', 'asc')
        ->pluck('name', 'id')->toArray();
        return $depreciation_list;
    }

    public static function categoryTypeList()
    {
         $category_types = array('' => '','accessory' => 'Accessory', 'asset' => 'Asset', 'consumable' => 'Consumable','component' => 'Component');
         return $category_types;
    }

    public static function usersList()
    {
        $users_list = array('' => trans('general.select_user')) + DB::table('users')
        ->select(DB::raw('concat(last_name,", ",first_name," (",username,")") as full_name, id'))
        ->whereNull('deleted_at')
        ->orderBy('last_name', 'asc')
        ->orderBy('first_name', 'asc')
        ->pluck('full_name', 'id');
        return $users_list;
    }

    public static function assetsList()
    {
        $assets_list = array('' => trans('general.select_asset')) + Asset::orderBy('name', 'asc')
        ->whereNull('deleted_at')
        ->pluck('name', 'id')->toArray();
        return $assets_list;
    }


    public static function customFieldsetList()
    {
        $customfields = array('' => trans('admin/models/general.no_custom_field')) + CustomFieldset::pluck('name', 'id')->toArray();
        return  $customfields;
    }

    public static function predefined_formats()
    {
        $keys=array_keys(CustomField::$PredefinedFormats);
        $stuff=array_combine($keys, $keys);
        return $stuff+["" => "Custom Format..."];
    }

    public static function barcodeDimensions($barcode_type = 'QRCODE')
    {
        if ($barcode_type == 'C128') {
            $size['height'] = '-1';
            $size['width'] = '-10';
        } elseif ($barcode_type == 'PDF417') {
            $size['height'] = '-3';
            $size['width'] = '-10';
        } else {
            $size['height'] = '-3';
            $size['width'] = '-3';
        }
        return $size;
    }

    public static function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

  /**
  * This nasty little method gets the low inventory info for the
  * alert dropdown
  **/
    public static function checkLowInventory()
    {
        $consumables = Consumable::with('users')->whereNotNull('min_amt')->get();
        $accessories = Accessory::with('users')->whereNotNull('min_amt')->get();
        $components = Component::with('assets')->whereNotNull('min_amt')->get();

        $avail_consumables = 0;
        $items_array = array();
        $all_count = 0;

        foreach ($consumables as $consumable) {
            $avail = $consumable->numRemaining();
            if ($avail < ($consumable->min_amt) + 3) {
                $percent = number_format((($consumable->numRemaining() / $consumable->qty) * 100), 0);
                $items_array[$all_count]['id'] = $consumable->id;
                $items_array[$all_count]['name'] = $consumable->name;
                $items_array[$all_count]['type'] = 'consumables';
                $items_array[$all_count]['percent'] = $percent;
                $items_array[$all_count]['remaining']=$consumable->numRemaining();
                $items_array[$all_count]['min_amt']=$consumable->min_amt;
                $all_count++;
            }


        }

        foreach ($accessories as $accessory) {
            $avail = $accessory->numRemaining();
            if ($avail < ($accessory->min_amt) + 3) {
                $percent = number_format((($accessory->numRemaining() / $accessory->qty) * 100), 0);
                $items_array[$all_count]['id'] = $accessory->id;
                $items_array[$all_count]['name'] = $accessory->name;
                $items_array[$all_count]['type'] = 'accessories';
                $items_array[$all_count]['percent'] = $percent;
                $items_array[$all_count]['remaining']=$accessory->numRemaining();
                $items_array[$all_count]['min_amt']=$accessory->min_amt;
                $all_count++;
            }

        }

        foreach ($components as $component) {
            $avail = $component->numRemaining();
            if ($avail < ($component->min_amt) + 3) {
                $percent = number_format((($component->numRemaining() / $component->total_qty) * 100), 0);
                $items_array[$all_count]['id'] = $component->id;
                $items_array[$all_count]['name'] = $component->name;
                $items_array[$all_count]['type'] = 'components';
                $items_array[$all_count]['percent'] = $percent;
                $items_array[$all_count]['remaining']=$component->numRemaining();
                $items_array[$all_count]['min_amt']=$component->min_amt;
                $all_count++;
            }

        }



        return $items_array;


    }


    public static function checkUploadIsImage($file)
    {
        // Check if the file is an image, so we can show a preview
        $finfo = @finfo_open(FILEINFO_MIME_TYPE); // return mime type ala mimetype extension
        $filetype = @finfo_file($finfo, $file);
        finfo_close($finfo);

        if (($filetype=="image/jpeg") || ($filetype=="image/jpg")   || ($filetype=="image/png") || ($filetype=="image/bmp") || ($filetype=="image/gif")) {
            return $filetype;
        }

        return false;
    }
}
