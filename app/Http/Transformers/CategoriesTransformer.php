<?php
namespace App\Http\Transformers;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Gate;

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
                'id' => e($category->id),
                'name' => e($category->name),
                'type' => e($category->category_type),
                'use_default_eula' => ($category->use_default_eula =='1') ? true : false,
                'require_acceptance' => ($category->require_acceptance =='1') ? true : false,
                'assets_count' => $category->assets_count,
                'accessories_count' => $category->accessories_count,
                'consumables_count' => $category->consumables_count,
                'components_count' => $category->components_count,
            ];

            $permissions_array['available_actions'] = [
                'update' => Gate::allows('admin') ? true : false,
                'delete' => Gate::allows('admin') ? true : false,
            ];

            $array += $permissions_array;

            return $array;
        }


    }



}
