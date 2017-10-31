<?php
namespace App\Http\Transformers;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Gate;
use App\Helpers\Helper;

class CategoriesTransformer
{

    public function transformCategories (Collection $categorys, $total)
    {
        $array = array();
        foreach ($categorys as $category) {
            $array[] = self::transformCategory($category);
        }
        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }

    public function transformCategory (Category $category = null)
    {
        if ($category) {

            $array = [
                'id' => (int) $category->id,
                'name' => e($category->name),
                'image' =>   ($category->image) ? e(url('/').'/uploads/categories/'.e($category->image)) : null,
                'type' => e($category->category_type),
                'eula' => ($category->getEula()) ? true : false,
                'checkin_email' => ($category->checkin_email =='1') ? true : false,
                'require_acceptance' => ($category->require_acceptance =='1') ? true : false,
                'assets_count' => $category->assets_count,
                'accessories_count' => $category->accessories_count,
                'consumables_count' => $category->consumables_count,
                'components_count' => $category->components_count,
                'created_at' => Helper::getFormattedDateObject($category->created_at, 'datetime'),
                'updated_at' => Helper::getFormattedDateObject($category->updated_at, 'datetime'),
            ];

            $permissions_array['available_actions'] = [
                'update' => Gate::allows('update', Category::class) ? true : false,
                'delete' => (Gate::allows('delete', Category::class) && ($category->assets_count == 0) && ($category->accessories_count == 0) && ($category->consumables_count == 0) && ($category->components_count == 0)) ? true : false,
            ];

            $array += $permissions_array;

            return $array;
        }


    }



}
