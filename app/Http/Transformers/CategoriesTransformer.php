<?php

namespace App\Http\Transformers;

use App\Helpers\Helper;
use App\Models\Category;
use Gate;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;

class CategoriesTransformer
{
    public function transformCategories(Collection $categorys, $total)
    {
        $array = [];
        foreach ($categorys as $category) {
            $array[] = self::transformCategory($category);
        }

        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }

    public function transformCategory(Category $category = null)
    {
        if ($category) {
            $array = [
                'id' => (int) $category->id,
                'name' => e($category->name),
                'image' =>   ($category->image) ? Storage::disk('public')->url('categories/'.e($category->image)) : null,
                'category_type' => ucwords(e($category->category_type)),
                'has_eula' => ($category->getEula() ? true : false),
                'use_default_eula' => ($category->use_default_eula=='1' ? true : false),
                'eula' => ($category->getEula()),
                'checkin_email' => ($category->checkin_email == '1'),
                'require_acceptance' => ($category->require_acceptance == '1'),
                'item_count' => (int) $category->itemCount(),
                'assets_count' => (int) $category->assets_count,
                'accessories_count' => (int) $category->accessories_count,
                'consumables_count' => (int) $category->consumables_count,
                'components_count' => (int) $category->components_count,
                'licenses_count' => (int) $category->licenses_count,
                'created_at' => Helper::getFormattedDateObject($category->created_at, 'datetime'),
                'updated_at' => Helper::getFormattedDateObject($category->updated_at, 'datetime'),
            ];

            $permissions_array['available_actions'] = [
                'update' => Gate::allows('update', Category::class),
                'delete' => $category->isDeletable(),
            ];

            $array += $permissions_array;

            return $array;
        }
    }
}
