<?php
namespace App\Http\Controllers\Api;

use View;
use App\Models\CustomFieldset;
use App\Models\CustomField;
use Input;
use Validator;
use Redirect;
use App\Models\AssetModel;
use Lang;
use Auth;
use Illuminate\Http\Request;
use Log;
use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use App\Http\Transformers\CustomFieldsTransformer;
use App\Http\Transformers\CustomFieldsetsTransformer;
use App\Http\Requests\AssetRequest;

/**
 * This controller handles all actions related to Custom Asset Fieldsets for
 * the Snipe-IT Asset Management application.
 *
 * @todo Improve documentation here.
 * @todo Check for raw DB queries and try to convert them to query builder statements
 * @version    v2.0
 * @author [Brady Wetherington] [<uberbrady@gmail.com>]
 * @author [Josh Gibson]
 */

class CustomFieldsetsController extends Controller
{

    /**
    * Shows the given fieldset and its fields
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @author [Josh Gibson]
    * @param int $id
    * @since [v1.8]
    * @return View
    */
    public function index()
    {
        $this->authorize('index', CustomFieldset::class);
        $fieldsets = CustomFieldset::withCount(['fields', 'models'])->get();
        return (new CustomFieldsetsTransformer)->transformCustomFieldsets($fieldsets, $fieldsets->count());

    }

    /**
    * Shows the given fieldset and its fields
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @author [Josh Gibson]
    * @param int $id
    * @since [v1.8]
    * @return View
    */
    public function show($id)
    {
      $this->authorize('show', CustomFieldset::class);
        if ($fieldset = CustomFieldset::find($id)) {
            return (new CustomFieldsetsTransformer)->transformCustomFieldset($fieldset);
        }

        return response()->json(Helper::formatStandardApiResponse('error', null, trans('admin/custom_fields/message.fieldset.does_not_exist')), 200);

    }


     /**
     * Update the specified resource in storage.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->authorize('edit', CustomFieldset::class);
        $fieldset = CustomFieldset::findOrFail($id);
        $fieldset->fill($request->all());

        if ($fieldset->save()) {
            return response()->json(Helper::formatStandardApiResponse('success', $fieldset, trans('admin/custom_fields/message.fieldset.update.success')));
        }

        return response()->json(Helper::formatStandardApiResponse('error', null, $fieldset->getErrors()));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', CustomFieldset::class);
        $fieldset = new CustomFieldset;
        $fieldset->fill($request->all());

        if ($fieldset->save()) {
            return response()->json(Helper::formatStandardApiResponse('success', $fieldset, trans('admin/custom_fields/message.fieldset.create.success')));
        }
        return response()->json(Helper::formatStandardApiResponse('error', null, $fieldset->getErrors()));

    }


    /**
     * Delete a custom fieldset.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     * @return Redirect
     */
    public function destroy($id)
    {
        $this->authorize('delete', CustomFieldset::class);
        $fieldset = CustomFieldset::findOrFail($id);

        $modelsCount = $fieldset->models->count();
        $fieldsCount = $fieldset->fields->count();

        if (($modelsCount > 0) || ($fieldsCount > 0) ){
            return response()->json(Helper::formatStandardApiResponse('error', null, 'Fieldset is in use.'));
        }

         if ($fieldset->delete()) {
             return response()->json(Helper::formatStandardApiResponse('success', null,  trans('admin/custom_fields/message.fieldset.delete.success')));
         }

        return response()->json(Helper::formatStandardApiResponse('error', null, 'Unspecified error'));



    }

    /**
     * Return JSON containing a list of fields belonging to a fieldset.
     *
     * @author [V. Cordes] [<volker@fdatek.de>]
     * @since [v4.1.10]
     * @param $fieldsetId
     * @return string JSON
     */
    public function fields($id)
    {
        $this->authorize('view', CustomFieldset::class);
        $set = CustomFieldset::findOrFail($id);
        $fields = $set->fields;
        return (new CustomFieldsTransformer)->transformCustomFields($fields, $fields->count());
    }

    /**
     * Return JSON containing a list of fields belonging to a fieldset with the
     * default values for a given model
     *
     * @param $modelId
     * @param $fieldsetId
     * @return string JSON
     */
    public function fieldsWithDefaultValues($fieldsetId, $modelId)
    {
        $this->authorize('view', CustomFieldset::class);

        $set = CustomFieldset::findOrFail($fieldsetId);

        $fields = $set->fields;

        return (new CustomFieldsTransformer)->transformCustomFieldsWithDefaultValues($fields, $modelId, $fields->count());
    }
}
