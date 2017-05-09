<?php
namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Accessory;
use App\Models\Actionlog;
use App\Models\Asset;
use App\Models\AssetMaintenance;
use App\Models\AssetModel;
use App\Models\Company;
use App\Models\CustomField;
use App\Models\License;
use App\Models\Location;
use App\Models\Setting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Input;
use League\Csv\Reader;
use Redirect;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * This controller handles all actions related to Reports for
 * the Snipe-IT Asset Management application.
 *
 * @version    v1.0
 */
class ReportsController extends Controller
{

    /**
    * Returns a view that displays the accessories report.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v1.0]
    * @return View
    */
    public function getAccessoryReport()
    {
        $accessories = Accessory::orderBy('created_at', 'DESC')->with('company')->get();

        return View::make('reports/accessories', compact('accessories'));
    }

    /**
    * Exports the accessories to CSV
    *
    * @deprecated Server-side exports have been replaced by datatables export since v2.
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see ManufacturersController::getDatatable() method that generates the JSON response
    * @since [v1.0]
    * @return \Illuminate\Http\Response
    */
    public function exportAccessoryReport()
    {
        $accessories = Accessory::orderBy('created_at', 'DESC')->get();

        $rows = array();
        $header = array(
            trans('admin/accessories/table.title'),
            trans('admin/accessories/general.accessory_category'),
            trans('admin/accessories/general.total'),
            trans('admin/accessories/general.remaining')
        );
        $header = array_map('trim', $header);
        $rows[] = implode($header, ', ');

        // Row per accessory
        foreach ($accessories as $accessory) {
            $row = array();
            $row[] = e($accessory->accessory_name);
            $row[] = e($accessory->accessory_category);
            $row[] = e($accessory->total);
            $row[] = e($accessory->remaining);

            $rows[] = implode($row, ',');
        }

        $csv = implode($rows, "\n");
        $response = Response::make($csv, 200);
        $response->header('Content-Type', 'text/csv');
        $response->header('Content-disposition', 'attachment;filename=report.csv');

        return $response;
    }

    /**
    * Display asset report view.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v1.0]
    * @return View
    */
    public function getAssetsReport()
    {
        $settings = \App\Models\Setting::first();
        return View::make('reports/asset', compact('assets'))->with('settings', $settings);
    }



    /**
    * Exports the assets to CSV
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v1.0]
    * @return \Illuminate\Http\Response
    */
    public function exportAssetReport()
    {

         \Debugbar::disable();

        $customfields = CustomField::get();

        $response = new StreamedResponse(function() use ($customfields) {
            // Open output stream
            $handle = fopen('php://output', 'w');

            Asset::with('assigneduser', 'assetloc','defaultLoc','assigneduser.userloc','model','supplier','assetstatus','model.manufacturer')->orderBy('created_at', 'DESC')->chunk(500, function($assets) use($handle, $customfields) {
                $headers=[
                    trans('general.company'),
                    trans('admin/hardware/table.asset_tag'),
                    trans('admin/hardware/form.manufacturer'),
                    trans('admin/hardware/form.model'),
                    trans('general.model_no'),
                    trans('general.name'),
                    trans('admin/hardware/table.serial'),
                    trans('general.status'),
                    trans('admin/hardware/table.purchase_date'),
                    trans('admin/hardware/table.purchase_cost'),
                    trans('admin/hardware/form.order'),
                    trans('admin/hardware/form.supplier'),
                    trans('admin/hardware/table.checkoutto'),
                    trans('admin/hardware/table.checkout_date'),
                    trans('admin/hardware/table.location'),
                    trans('general.notes'),
                ];
                foreach($customfields as $field) {
                    $headers[]=$field->name;
                }
                fputcsv($handle, $headers);

                foreach ($assets as $asset) {
                    // Add a new row with data
                    $values=[
                        ($asset->company) ? $asset->company->name : '',
                        $asset->asset_tag,
                        ($asset->model->manufacturer) ? $asset->model->manufacturer->name : '',
                        ($asset->model) ? $asset->model->name : '',
                        ($asset->model->model_number) ? $asset->model->model_number : '',
                        ($asset->name) ? $asset->name : '',
                        ($asset->serial) ? $asset->serial : '',
                        ($asset->assetstatus) ? e($asset->assetstatus->name) : '',
                        ($asset->purchase_date) ? e($asset->purchase_date) : '',
                        ($asset->purchase_cost > 0) ? Helper::formatCurrencyOutput($asset->purchase_cost) : '',
                        ($asset->order_number) ? e($asset->order_number) : '',
                        ($asset->supplier) ? e($asset->supplier->name) : '',
                        ($asset->assigneduser) ? e($asset->assigneduser->fullName()) : '',
                        ($asset->last_checkout!='') ? e($asset->last_checkout) : '',
                        ($asset->assigneduser && $asset->assigneduser->userloc!='') ?
                            e($asset->assigneduser->userloc->name) : ( ($asset->defaultLoc!='') ? e($asset->defaultLoc->name) : ''),
                        ($asset->notes) ? e($asset->notes) : '',
                    ];
                    foreach($customfields as $field) {
                        $values[]=$asset->{$field->db_column_name()};
                    }
                    fputcsv($handle, $values);
                }
            });

            // Close the output stream
            fclose($handle);
        }, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="assets-'.date('Y-m-d-his').'.csv"',
        ]);

        return $response;

    }

    /**
    * Show depreciation report for assets.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v1.0]
    * @return View
    */
    public function getDeprecationReport()
    {

        // Grab all the assets
        $assets = Asset::with('model', 'assigneduser', 'assetstatus', 'defaultLoc', 'assetlog', 'company')
                       ->orderBy('created_at', 'DESC')->get();

        return View::make('reports/depreciation', compact('assets'));
    }

    /**
    * Exports the depreciations to CSV
    *
    * @deprecated Server-side exports have been replaced by datatables export since v2.
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v1.0]
    * @return \Illuminate\Http\Response
    */
    public function exportDeprecationReport()
    {

        // Grab all the assets
        $assets = Asset::with('model', 'assigneduser', 'assetstatus', 'defaultLoc', 'assetlog')
                       ->orderBy('created_at', 'DESC')->get();

        $csv = \League\Csv\Writer::createFromFileObject(new \SplTempFileObject());
        $csv->setOutputBOM(Reader::BOM_UTF16_BE);

        $rows = [ ];

        // Create the header row
        $header = [
            trans('admin/hardware/table.asset_tag'),
            trans('admin/hardware/table.title'),
            trans('admin/hardware/table.serial'),
            trans('admin/hardware/table.checkoutto'),
            trans('admin/hardware/table.location'),
            trans('admin/hardware/table.purchase_date'),
            trans('admin/hardware/table.purchase_cost'),
            trans('admin/hardware/table.book_value'),
            trans('admin/hardware/table.diff')
        ];

        //we insert the CSV header
        $csv->insertOne($header);

        // Create a row per asset
        foreach ($assets as $asset) {
            $row   = [ ];
            $row[] = e($asset->asset_tag);
            $row[] = e($asset->name);
            $row[] = e($asset->serial);

            if ($asset->assigned_to > 0) {
                $user  = User::find($asset->assigned_to);
                $row[] = e($user->fullName());
            } else {
                $row[] = ''; // Empty string if unassigned
            }

            if (( $asset->assigned_to > 0 ) && ( $asset->assigneduser->location_id > 0 )) {
                $location = Location::find($asset->assigneduser->location_id);
                if ($location->city) {
                    $row[] = e($location->city) . ', ' . e($location->state);
                } elseif ($location->name) {
                    $row[] = e($location->name);
                } else {
                    $row[] = '';
                }
            } else {
                $row[] = '';  // Empty string if location is not set
            }

            if ($asset->assetloc) {
                $currency = e($asset->assetloc->currency);
            } else {
                $currency = e(Setting::first()->default_currency);
            }

            $row[] = $asset->purchase_date;
            $row[] = $currency . Helper::formatCurrencyOutput($asset->purchase_cost);
            $row[] = $currency . Helper::formatCurrencyOutput($asset->getDepreciatedValue());
            $row[] = $currency . Helper::formatCurrencyOutput(( $asset->purchase_cost - $asset->getDepreciatedValue() ));
            $csv->insertOne($row);
        }

        $csv->output('depreciation-report-' . date('Y-m-d') . '.csv');
        die;

    }

    /**
    * Displays activity report.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v1.0]
    * @return View
    */
    public function getActivityReport()
    {
        $log_actions = Actionlog::orderBy('created_at', 'DESC')
                                ->with('item')
                                ->orderBy('created_at', 'DESC')
                                ->get();

        return View::make('reports/activity', compact('log_actions'));
    }

    /**
     * Returns Activity Report JSON.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v1.0]
     * @return View
     */
    public function getActivityReportDataTable()
    {
        $activitylogs = Company::scopeCompanyables(Actionlog::with('item', 'user', 'target'))->orderBy('created_at', 'DESC');

        if (Input::has('search')) {
            $activitylogs = $activitylogs->TextSearch(e(Input::get('search')));
        }

        if (Input::has('offset')) {
            $offset = e(Input::get('offset'));
        } else {
            $offset = 0;
        }

        if (Input::has('limit')) {
            $limit = e(Input::get('limit'));
        } else {
            $limit = 50;
        }


        $allowed_columns = ['created_at'];
        $order = Input::get('order') === 'asc' ? 'asc' : 'desc';
        $sort = in_array(Input::get('sort'), $allowed_columns) ? e(Input::get('sort')) : 'created_at';


        $activityCount = $activitylogs->count();
        $activitylogs = $activitylogs->offset($offset)->limit($limit)->get();

        $rows = array();
        foreach ($activitylogs as $activity) {

            if ($activity->itemType() == "asset") {
                $activity_icons = '<i class="fa fa-barcode"></i>';
            } elseif ($activity->itemType() == "accessory") {
                $activity_icons = '<i class="fa fa-keyboard-o"></i>';
            } elseif ($activity->itemType()=="consumable") {
                $activity_icons = '<i class="fa fa-tint"></i>';
            } elseif ($activity->itemType()=="license"){
                $activity_icons = '<i class="fa fa-floppy-o"></i>';
            } elseif ($activity->itemType()=="component") {
                $activity_icons = '<i class="fa fa-hdd-o"></i>';
            } else {
                $activity_icons = '<i class="fa fa-paperclip"></i>';
            }

            if (($activity->item) && ($activity->itemType()=="asset")) {
              $activity_item = '<a href="'.route('view/hardware', $activity->item_id).'">'.e($activity->item->asset_tag).' - '. e($activity->item->showAssetName()).'</a>';
                $item_type = 'asset';
            } elseif ($activity->item) {

                if ($activity->item->deleted_at!='') {
                    $activity_item = '<del>'. e($activity->item->name).'</del>';
                } else {
                    $activity_item = '<a href="' . route('view/' . $activity->itemType(),
                    $activity->item_id) . '">' . e($activity->item->name) . '</a>';
                }

                $item_type = $activity->itemType();

            } else {
                $activity_item = "unknown (deleted)";
                $item_type = "null";
            }
            

            if (($activity->user) && ($activity->action_type=="uploaded") && ($activity->itemType()=="user")) {
                $activity_target = '<a href="'.route('view/user', $activity->target_id).'">'.$activity->user->fullName().'</a>';
            } elseif ($activity->target_type === "App\Models\Asset") {
                if($activity->target) {
                    $activity_target = '<a href="'.route('view/hardware', $activity->target_id).'">'.$activity->target->showAssetName().'</a>';
                } else {
                    $activity_target = "";
                }
            } elseif ( $activity->target_type === "App\Models\User") {
                if($activity->target) {
                   $activity_target = '<a href="'.route('view/user', $activity->target_id).'">'.$activity->target->fullName().'</a>';
                } else {
                    $activity_target = '';
                }
            } elseif (($activity->action_type=='accepted') || ($activity->action_type=='declined')) {
                $activity_target = '<a href="' . route('view/user', $activity->item->assigneduser->id) . '">' . e($activity->item->assigneduser->fullName()) . '</a>';

            } elseif ($activity->action_type=='requested') {
                if ($activity->user) {
                    $activity_target =  '<a href="'.route('view/user', $activity->user_id).'">'.$activity->user->fullName().'</a>';
                } else {
                    $activity_target = '';
                }
            } else {
                if($activity->target) {
                    $activity_target = $activity->target->id;
                } else {
                    $activity_target = "";
                }
            }

            
            $rows[] = array(
                'icon'          => $activity_icons,
                'created_at'    => date("M d, Y g:iA", strtotime($activity->created_at)),
                'action_type'              => strtolower(trans('general.'.str_replace(' ','_',$activity->action_type))),
                'admin'         =>  $activity->user ? (string) link_to('/admin/users/'.$activity->user_id.'/view', $activity->user->fullName()) : '',
                'target'          => $activity_target,
                'item'          => $activity_item,
                'item_type'     => $item_type,
                'note'     => e($activity->note),

            );
        }

        $data = array('total'=>$activityCount, 'rows'=>$rows);

        return $data;

    }

    /**
     * Displays license report
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v1.0]
     * @return View
     */
    public function getLicenseReport()
    {

        $licenses = License::with('depreciation')->orderBy('created_at', 'DESC')
                           ->with('company')
                           ->get();

        return View::make('reports/licenses', compact('licenses'));
    }

    /**
    * Exports the licenses to CSV
    *
    * @deprecated Server-side exports have been replaced by datatables export since v2.
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v1.0]
    * @return \Illuminate\Http\Response
    */
    public function exportLicenseReport()
    {
        $licenses = License::orderBy('created_at', 'DESC')->get();

        $rows     = [ ];
        $header   = [
            trans('admin/licenses/table.title'),
            trans('admin/licenses/table.serial'),
            trans('admin/licenses/form.seats'),
            trans('admin/licenses/form.remaining_seats'),
            trans('admin/licenses/form.expiration'),
            trans('general.purchase_date'),
            trans('general.depreciation'),
            trans('general.purchase_cost')
        ];

        $header = array_map('trim', $header);
        $rows[] = implode($header, ', ');

        // Row per license
        foreach ($licenses as $license) {
            $row   = [ ];
            $row[] = e($license->name);
            $row[] = e($license->serial);
            $row[] = e($license->seats);
            $row[] = $license->remaincount();
            $row[] = $license->expiration_date;
            $row[] = $license->purchase_date;
            $row[] = ($license->depreciation!='') ? '' : e($license->depreciation->name);
            $row[] = '"' . Helper::formatCurrencyOutput($license->purchase_cost) . '"';

            $rows[] = implode($row, ',');
        }

        $csv      = implode($rows, "\n");
        $response = Response::make($csv, 200);
        $response->header('Content-Type', 'text/csv');
        $response->header('Content-disposition', 'attachment;filename=report.csv');

        return $response;
    }

    /**
    * Returns a form that allows the user to generate a custom CSV report.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see ReportsController::postCustomReport() method that generates the CSV
    * @since [v1.0]
    * @return \Illuminate\Http\Response
    */
    public function getCustomReport()
    {
        $customfields = CustomField::get();
        return View::make('reports/custom')->with('customfields', $customfields);
    }

    /**
     * Exports the custom report to CSV
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @see ReportsController::getCustomReport() method that generates form view
     * @since [v1.0]
     * @return \Illuminate\Http\Response
     */
    public function postCustom()
    {
        $assets = Asset::orderBy('created_at', 'DESC')->with('company','assigneduser', 'assetloc','defaultLoc','assigneduser.userloc','model','supplier','assetstatus','model.manufacturer')->get();
        $customfields = CustomField::get();

        $rows   = [ ];
        $header = [ ];

        if (e(Input::get('company')) == '1') {
            $header[] = 'Company Name';
        }

        if (e(Input::get('asset_name')) == '1') {
            $header[] = 'Asset Name';
        }
        if (e(Input::get('asset_tag')) == '1') {
            $header[] = 'Asset Tag';
        }
        if (e(Input::get('manufacturer')) == '1') {
            $header[] = 'Manufacturer';
        }
        if (e(Input::get('model')) == '1') {
            $header[] = 'Model';
            $header[] = 'Model Number';
        }
        if (e(Input::get('category')) == '1') {
            $header[] = 'Category';
        }
        if (e(Input::get('serial')) == '1') {
            $header[] = 'Serial';
        }
        if (e(Input::get('purchase_date')) == '1') {
            $header[] = 'Purchase Date';
        }
        if (( e(Input::get('purchase_cost')) == '1' ) && ( e(Input::get('depreciation')) != '1' )) {
            $header[] = 'Purchase Cost';
        }
        if (e(Input::get('eol')) == '1') {
            $header[] = 'EOL';
        }
        if (e(Input::get('order')) == '1') {
            $header[] = 'Order Number';
        }
        if (e(Input::get('supplier')) == '1') {
            $header[] = 'Supplier';
        }
        if (e(Input::get('location')) == '1') {
            $header[] = 'Location';
        }
        if (e(Input::get('assigned_to')) == '1') {
            $header[] = 'Assigned To';
        }
        if (e(Input::get('username')) == '1') {
            $header[] = 'Username';
        }
        if (e(Input::get('employee_num')) == '1') {
            $header[] = 'Employee No.';
        }
        if (e(Input::get('status')) == '1') {
            $header[] = 'Status';
        }
        if (e(Input::get('warranty')) == '1') {
            $header[] = 'Warranty';
            $header[] = 'Warranty Expires';
        }
        if (e(Input::get('depreciation')) == '1') {
            $header[] = 'Purchase Cost';
            $header[] = 'Value';
            $header[] = 'Diff';
        }
        if (e(Input::get('expected_checkin')) == '1') {
            $header[] = trans('admin/hardware/form.expected_checkin');
        }

        if (e(Input::get('notes')) == '1') {
            $header[] = trans('general.notes');
        }


        foreach ($customfields as $customfield) {
            if (e(Input::get($customfield->db_column_name())) == '1') {
                $header[] = $customfield->name;
            }
        }


        $header = array_map('trim', $header);
        $rows[] = implode($header, ',');

        foreach ($assets as $asset) {
            $row = [ ];

            if (e(Input::get('company')) == '1') {
                $row[] = is_null($asset->company) ? '' : '"'.$asset->company->name.'"';
            }

            if (e(Input::get('asset_name')) == '1') {
                $row[] = '"' .e($asset->name) . '"';
            }
            if (e(Input::get('asset_tag')) == '1') {
                $row[] = e($asset->asset_tag);
            }
            if (e(Input::get('manufacturer')) == '1') {
                if ($asset->model->manufacturer) {
                    $row[] = '"' .e($asset->model->manufacturer->name) . '"';
                } else {
                    $row[] = '';
                }
            }
            if (e(Input::get('model')) == '1') {
                $row[] = '"' . e($asset->model->name) . '"';
                $row[] = '"' . e($asset->model->model_number) . '"';
            }
            if (e(Input::get('category')) == '1') {
                $row[] = '"' .e($asset->model->category->name) . '"';
            }

            if (e(Input::get('serial')) == '1') {
                $row[] = e($asset->serial);
            }
            if (e(Input::get('purchase_date')) == '1') {
                $row[] = e($asset->purchase_date);
            }
            if (e(Input::get('purchase_cost')) == '1' && ( e(Input::get('depreciation')) != '1' )) {
                $row[] = '"' . Helper::formatCurrencyOutput($asset->purchase_cost) . '"';
            }
            if (e(Input::get('eol')) == '1') {
                $row[] = '"' .($asset->eol_date()) ? $asset->eol_date() : ''. '"';
            }
            if (e(Input::get('order')) == '1') {
                if ($asset->order_number) {
                    $row[] = e($asset->order_number);
                } else {
                    $row[] = '';
                }
            }
            if (e(Input::get('supplier')) == '1') {
                if ($asset->supplier) {
                    $row[] = '"' .e($asset->supplier->name) . '"';
                } else {
                    $row[] = '';
                }
            }

            if (e(Input::get('location')) == '1') {
                $show_loc = '';


                if (($asset->assigned_to > 0) && ($asset->assigneduser) && ($asset->assigneduser->location)) {
                    $show_loc .= '"' .e($asset->assigneduser->location->name). '"';
                } elseif ($asset->rtd_location_id!='') {
                    $location = Location::find($asset->rtd_location_id);
                    if ($location) {
                        $show_loc .= '"' .e($location->name). '"';
                    } else {
                        $show_loc .= 'Default location '.$asset->rtd_location_id.' is invalid';
                    }
                }

                $row[] = $show_loc;

            }


            if (e(Input::get('assigned_to')) == '1') {
                if ($asset->assigneduser) {
                    $row[] = '"' .e($asset->assigneduser->fullName()). '"';
                } else {
                    $row[] = ''; // Empty string if unassigned
                }
            }

            if (e(Input::get('username')) == '1') {
                if ($asset->assigneduser) {
                    $row[] = '"' .e($asset->assigneduser->username). '"';
                } else {
                    $row[] = ''; // Empty string if unassigned
                }
            }

            if (e(Input::get('employee_num')) == '1') {
                if ($asset->assigneduser) {
                    $row[] = '"' .e($asset->assigneduser->employee_num). '"';
                } else {
                    $row[] = ''; // Empty string if unassigned
                }
            }

            if (e(Input::get('status')) == '1') {
                if (( $asset->status_id == '0' ) && ( $asset->assigned_to == '0' )) {
                    $row[] = trans('general.ready_to_deploy');
                } elseif (( $asset->status_id == '' ) && ( $asset->assigned_to == '0' )) {
                    $row[] = trans('general.pending');
                } elseif ($asset->assetstatus) {
                    $row[] = '"' .e($asset->assetstatus->name). '"';
                } else {
                    $row[] = '';
                }
            }
            if (e(Input::get('warranty')) == '1') {
                if ($asset->warranty_months) {
                    $row[] = $asset->warranty_months;
                    $row[] = $asset->warrantee_expires();
                } else {
                    $row[] = '';
                    $row[] = '';
                }
            }
            if (e(Input::get('depreciation')) == '1') {
                $depreciation = $asset->getDepreciatedValue();
                $row[]        = '"' . Helper::formatCurrencyOutput($asset->purchase_cost) . '"';
                $row[]        = '"' . Helper::formatCurrencyOutput($depreciation) . '"';
                $row[]        = '"' . Helper::formatCurrencyOutput($asset->purchase_cost) . '"';
            }
            if (e(Input::get('expected_checkin')) == '1') {
                if ($asset->expected_checkin) {
                    $row[] = '"' .e($asset->expected_checkin). '"';
                } else {
                    $row[] = ''; // Empty string if blankd
                }
            }

            if (e(Input::get('notes')) == '1') {
                if ($asset->notes) {
                    $row[] = '"' .$asset->notes . '"';
                } else {
                    $row[] = '';
                }
            }

            foreach ($customfields as $customfield) {
                $column_name = $customfield->db_column_name();
                if (e(Input::get($customfield->db_column_name())) == '1') {
                    $row[] = str_replace(",", "\,", $asset->$column_name);
                }
            }


            $rows[] = implode($row, ',');
        }

        // spit out a csv
        if (array_filter($rows)) {
            $csv      = implode($rows, "\n");
            $response = Response::make($csv, 200);
            $response->header('Content-Type', 'text/csv');
            $response->header('Content-disposition', 'attachment;filename='.date('Y-m-d-His').'-custom-asset-report.csv');

            return $response;
        } else {
            return redirect()->to("reports/custom")
                ->with('error', trans('admin/reports/message.error'));
        }
    }
    

    /**
     * getImprovementsReport
     *
     * @return View
     * @author  Vincent Sposato <vincent.sposato@gmail.com>
     * @version v1.0
     */
    public function getAssetMaintenancesReport()
    {
        // Grab all the improvements
        $assetMaintenances = AssetMaintenance::with('asset', 'supplier', 'asset.company')
                                              ->orderBy('created_at', 'DESC')
                                              ->get();

        return View::make('reports/asset_maintenances', compact('assetMaintenances'));

    }

    /**
     * exportImprovementsReport
     *
     * @return \Illuminate\Http\Response
     * @author  Vincent Sposato <vincent.sposato@gmail.com>
     * @version v1.0
     */
    public function exportAssetMaintenancesReport()
    {
        // Grab all the improvements
        $assetMaintenances = AssetMaintenance::with('asset', 'supplier')
                                             ->orderBy('created_at', 'DESC')
                                             ->get();

        $rows = [ ];

        $header = [
            trans('admin/hardware/table.asset_tag'),
            trans('admin/asset_maintenances/table.asset_name'),
            trans('general.supplier'),
            trans('admin/asset_maintenances/form.asset_maintenance_type'),
            trans('admin/asset_maintenances/form.title'),
            trans('admin/asset_maintenances/form.start_date'),
            trans('admin/asset_maintenances/form.completion_date'),
            trans('admin/asset_maintenances/form.asset_maintenance_time'),
            trans('admin/asset_maintenances/form.cost')
        ];

        $header = array_map('trim', $header);
        $rows[] = implode($header, ',');

        foreach ($assetMaintenances as $assetMaintenance) {
            $row   = [ ];
            $row[] = str_replace(',', '', e($assetMaintenance->asset->asset_tag));
            $row[] = str_replace(',', '', e($assetMaintenance->asset->name));
            $row[] = str_replace(',', '', e($assetMaintenance->supplier->name));
            $row[] = e($assetMaintenance->improvement_type);
            $row[] = e($assetMaintenance->title);
            $row[] = e($assetMaintenance->start_date);
            $row[] = e($assetMaintenance->completion_date);
            if (is_null($assetMaintenance->asset_maintenance_time)) {
                $improvementTime = intval(Carbon::now()
                                                 ->diffInDays(Carbon::parse($assetMaintenance->start_date)));
            } else {
                $improvementTime = intval($assetMaintenance->asset_maintenance_time);
            }
            $row[]  = $improvementTime;
            $row[]  = trans('general.currency') . Helper::formatCurrencyOutput($assetMaintenance->cost);
            $rows[] = implode($row, ',');
        }

        // spit out a csv
        $csv      = implode($rows, "\n");
        $response = Response::make($csv, 200);
        $response->header('Content-Type', 'text/csv');
        $response->header('Content-disposition', 'attachment;filename=report.csv');

        return $response;
    }

    /**
     * getAssetAcceptanceReport
     *
     * @return mixed
     * @author  Vincent Sposato <vincent.sposato@gmail.com>
     * @version v1.0
     */
    public function getAssetAcceptanceReport()
    {
        $assetsForReport = Asset::notYetAccepted()->with('company')->get();

        return View::make('reports/unaccepted_assets', compact('assetsForReport'));
    }

    /**
     * exportAssetAcceptanceReport
     *
     * @return \Illuminate\Http\Response
     * @author  Vincent Sposato <vincent.sposato@gmail.com>
     * @version v1.0
     */
    public function exportAssetAcceptanceReport()
    {

        // Grab all the improvements
        $assetsForReport = Actionlog::whereIn('id', $this->getAssetsNotAcceptedYet())
                                    ->get();

        $rows = [ ];

        $header = [
            trans('general.category'),
            trans('admin/hardware/form.model'),
            trans('admin/hardware/form.name'),
            trans('admin/hardware/table.asset_tag'),
            trans('admin/hardware/table.checkoutto'),
        ];

        $header = array_map('trim', $header);
        $rows[] = implode($header, ',');

        foreach ($assetsForReport as $assetItem) {
            $row    = [ ];
            $row[]  = str_replace(',', '', e($assetItem->assetlog->model->category->name));
            $row[]  = str_replace(',', '', e($assetItem->assetlog->model->name));
            $row[]  = str_replace(',', '', e($assetItem->assetlog->showAssetName()));
            $row[]  = str_replace(',', '', e($assetItem->assetlog->asset_tag));
            $row[]  = str_replace(',', '', e($assetItem->assetlog->assigneduser->fullName()));
            $rows[] = implode($row, ',');
        }

        // spit out a csv
        $csv      = implode($rows, "\n");
        $response = Response::make($csv, 200);
        $response->header('Content-Type', 'text/csv');
        $response->header('Content-disposition', 'attachment;filename=report.csv');

        return $response;

    }

    /**
     * getCheckedOutAssetsRequiringAcceptance
     *
     * @param $modelsInCategoriesThatRequireAcceptance
     *
     * @return array
     * @author  Vincent Sposato <vincent.sposato@gmail.com>
     * @version v1.0
     */
    protected function getCheckedOutAssetsRequiringAcceptance($modelsInCategoriesThatRequireAcceptance)
    {
        $assets = Asset::deployed()
                        ->inModelList($modelsInCategoriesThatRequireAcceptance)
                        ->select('id')
                        ->get()
                        ->toArray();

        return array_pluck($assets, 'id');
    }

    /**
     * getModelsInCategoriesThatRequireAcceptance
     *
     * @param $assetCategoriesRequiringAcceptance
     * @return array
     * @author  Vincent Sposato <vincent.sposato@gmail.com>
     * @version v1.0
     */
    protected function getModelsInCategoriesThatRequireAcceptance($assetCategoriesRequiringAcceptance)
    {

        return array_pluck(Model::inCategory($assetCategoriesRequiringAcceptance)
                                 ->select('id')
                                 ->get()
                                 ->toArray(), 'id');
    }

    /**
     * getCategoriesThatRequireAcceptance
     *
     * @return array
     * @author  Vincent Sposato <vincent.sposato@gmail.com>
     * @version v1.0
     */
    protected function getCategoriesThatRequireAcceptance()
    {

        return array_pluck(Category::requiresAcceptance()
                                    ->select('id')
                                    ->get()
                                    ->toArray(), 'id');
    }

    /**
     * getAssetsCheckedOutRequiringAcceptance
     *
     * @return array
     * @author  Vincent Sposato <vincent.sposato@gmail.com>
     * @version v1.0
     */
    protected function getAssetsCheckedOutRequiringAcceptance()
    {

        return $this->getCheckedOutAssetsRequiringAcceptance(
            $this->getModelsInCategoriesThatRequireAcceptance($this->getCategoriesThatRequireAcceptance())
        );
    }

    /**
     * getAssetsNotAcceptedYet
     *
     * @return array
     * @author  Vincent Sposato <vincent.sposato@gmail.com>
     * @version v1.0
     */
    protected function getAssetsNotAcceptedYet()
    {
        return Asset::unaccepted();
    }
}
