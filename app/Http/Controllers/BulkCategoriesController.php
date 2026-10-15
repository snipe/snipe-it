<?php

namespace App\Http\Controllers;

use App\Actions\Categories\DestroyCategoryAction;
use App\Exceptions\Handler;
use App\Exceptions\ItemStillHasAccessories;
use App\Exceptions\ItemStillHasAssetModels;
use App\Exceptions\ItemStillHasAssets;
use App\Exceptions\ItemStillHasComponents;
use App\Exceptions\ItemStillHasConsumables;
use App\Exceptions\ItemStillHasLicenses;
use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BulkCategoriesController extends Controller
{
    public function edit(Request $request): View|RedirectResponse
    {
        $categories_raw_array = $request->input('ids');

        if (! is_array($categories_raw_array) || count($categories_raw_array) === 0) {
            return redirect()->route('categories.index')
                ->with('error', trans('admin/categories/message.bulkedit.no_selection'));
        }

        if ($request->input('bulk_actions') === 'delete') {
            return $this->destroy($request);
        }

        $this->authorize('update', Category::class);

        $categories = Category::whereIn('id', $categories_raw_array)
            ->withCount([
                'assets as assets_count',
                'models as models_count',
                'accessories as accessories_count',
                'consumables as consumables_count',
                'components as components_count',
                'licenses as licenses_count',
            ])
            ->orderBy('name', 'ASC')
            ->get();

        return view('categories/bulk-edit', compact('categories'));
    }

    public function update(Request $request): RedirectResponse
    {
        $this->authorize('update', Category::class);

        $categories_raw_array = $request->input('ids');

        if (! is_array($categories_raw_array) || count($categories_raw_array) === 0) {
            return redirect()->route('categories.index')
                ->with('error', trans('admin/categories/message.bulkedit.no_selection'));
        }

        $update_array = [];

        foreach (['require_acceptance', 'use_default_eula', 'checkin_email', 'alert_on_response'] as $boolean_field) {
            $value = $request->input($boolean_field);
            if ($value !== null && $value !== '') {
                $update_array[$boolean_field] = (int) $value;
            }
        }

        if ($request->filled('tag_color')) {
            $update_array['tag_color'] = $request->input('tag_color');
        }

        if (count($update_array) === 0) {
            return redirect()->route('categories.index')
                ->with('warning', trans('admin/categories/message.bulkedit.no_changes'));
        }

        $updated = Category::whereIn('id', $categories_raw_array)->update($update_array);

        return redirect()->route('categories.index')
            ->with('success', trans_choice('admin/categories/message.bulkedit.success', $updated, ['count' => $updated]));
    }

    public function destroy(Request $request)
    {
        $this->authorize('delete', Category::class);

        $errors = [];
        $success_count = 0;

        foreach ($request->ids as $id) {
            $category = Category::find($id);
            if (is_null($category)) {
                $errors[] = trans('admin/categories/message.does_not_exist');

                continue;
            }
            try {
                DestroyCategoryAction::run(category: $category);
                $success_count++;
            } catch (ItemStillHasAccessories $e) {
                $errors[] = trans('general.bulk_delete_associations.assoc_assets_no_count', ['item_name' => $category->name, 'item' => trans('general.category')]);
            } catch (ItemStillHasAssetModels) {
                $errors[] = trans('general.bulk_delete_associations.assoc_asset_models_no_count', ['item_name' => $category->name, 'item' => trans('general.category')]);
            } catch (ItemStillHasAssets) {
                $errors[] = trans('general.bulk_delete_associations.assoc_assets_no_count', ['item_name' => $category->name, 'item' => trans('general.category')]);
            } catch (ItemStillHasComponents) {
                $errors[] = trans('general.bulk_delete_associations.assoc_components_no_count', ['item_name' => $category->name, 'item' => trans('general.category')]);
            } catch (ItemStillHasConsumables) {
                $errors[] = trans('general.bulk_delete_associations.assoc_consumables_no_count', ['item_name' => $category->name, 'item' => trans('general.category')]);
            } catch (ItemStillHasLicenses) {
                $errors[] = trans('general.bulk_delete_associations.assoc_licenses_no_count', ['item_name' => $category->name, 'item' => trans('general.category')]);
            } catch (\Throwable $e) {
                Handler::reportOrRethrow($e);
                $errors[] = trans('general.something_went_wrong');
            }
        }
        if (count($errors) > 0) {
            if ($success_count > 0) {
                return redirect()->route('categories.index')->with('success', trans_choice('admin/categories/message.delete.partial_success', $success_count, ['count' => $success_count]))->with('multi_error_messages', $errors);
            }

            return redirect()->route('categories.index')->with('multi_error_messages', $errors);
        } else {
            return redirect()->route('categories.index')->with('success', trans_choice('admin/categories/message.delete.bulk_success', $success_count, ['count' => $success_count]));
        }
    }
}
