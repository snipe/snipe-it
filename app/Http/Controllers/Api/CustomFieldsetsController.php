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
    public function index(Request $request)
    {
        $this->authorize('index', CustomFieldset::class);
        $fields = CustomFieldset::all();

        $total = count($fields);
        return (new CustomFieldsetsTransformer)->transformCustomFieldsets($fields, $total);

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
        if ($fieldset = CustomFieldset::find($id)) {
            $this->authorize('show', CustomFieldset::class);
            return (new CustomFieldsetsTransformer)->transformCustomFieldset($fieldset);
        }

        return response()->json(Helper::formatStandardApiResponse('error', null, trans('admin/custom_fields/message.fieldset.does_not_exist')), 200);

    }

}
