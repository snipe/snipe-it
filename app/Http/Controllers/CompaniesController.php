<?php
namespace App\Http\Controllers;

use App\Models\Company;
use Input;
use Lang;
use Redirect;
use View;

/**
 * This controller handles all actions related to Companies for
 * the Snipe-IT Asset Management application.
 *
 * @version    v1.0
 */

final class CompaniesController extends Controller
{

    /**
    * Returns view to display listing of companies.
    *
    * @author [Abdullah Alansari] [<ahimta@gmail.com>]
    * @since [v1.8]
    * @return View
    */
    public function getIndex()
    {
        return View::make('companies/index')->with('companies', Company::all());
    }

    /**
    * Returns view to create a new company.
    *
    * @author [Abdullah Alansari] [<ahimta@gmail.com>]
    * @since [v1.8]
    * @return View
    */
    public function getCreate()
    {
        return View::make('companies/edit')->with('item', new Company);
    }

    /**
    * Save data from new company form.
    *
    * @author [Abdullah Alansari] [<ahimta@gmail.com>]
    * @since [v1.8]
    * @return Redirect
    */
    public function postCreate()
    {
        $company = new Company;

            $company->name = e(Input::get('name'));

        if ($company->save()) {
            return redirect()->to('admin/settings/companies')
                ->with('success', trans('admin/companies/message.create.success'));
        } else {
            return redirect()->back()->withInput()->withErrors($company->getErrors());
        }

    }


    /**
    * Return form to edit existing company.
    *
    * @author [Abdullah Alansari] [<ahimta@gmail.com>]
    * @since [v1.8]
    * @param int $companyId
    * @return View
    */
    public function getEdit($companyId)
    {
        if (is_null($item = Company::find($companyId))) {
            return redirect()->to('admin/settings/companies')
                ->with('error', trans('admin/companies/message.does_not_exist'));
        } else {
            return View::make('companies/edit')->with('item', $item);
        }
    }

    /**
    * Save data from edit company form.
    *
    * @author [Abdullah Alansari] [<ahimta@gmail.com>]
    * @since [v1.8]
    * @param int $companyId
    * @return Redirect
    */
    public function postEdit($companyId)
    {
        if (is_null($company = Company::find($companyId))) {
            return redirect()->to('admin/settings/companies')->with('error', trans('admin/companies/message.does_not_exist'));
        } else {


            $company->name = e(Input::get('name'));

            if ($company->save()) {
                return redirect()->to('admin/settings/companies')
                    ->with('success', trans('admin/companies/message.update.success'));
            } else {
                return redirect()->to("admin/settings/companies/$companyId/edit")
                    ->with('error', trans('admin/companies/message.update.error'));
            }

        }
    }

    /**
    * Delete company
    *
    * @author [Abdullah Alansari] [<ahimta@gmail.com>]
    * @since [v1.8]
    * @param int $companyId
    * @return Redirect
    */
    public function postDelete($companyId)
    {
        if (is_null($company = Company::find($companyId))) {
            return redirect()->to('admin/settings/companies')
                ->with('error', trans('admin/companies/message.not_found'));
        } else {
            try {
                $company->delete();
                return redirect()->to('admin/settings/companies')
                    ->with('success', trans('admin/companies/message.delete.success'));
            } catch (\Illuminate\Database\QueryException $exception) {
            /*
                 * NOTE: This happens when there's a foreign key constraint violation
                 * For example when rows in other tables are referencing this company
                 */
                if ($exception->getCode() == 23000) {
                    return redirect()->to('admin/settings/companies')
                        ->with('error', trans('admin/companies/message.assoc_users'));
                } else {
                    throw $exception;
                }
            }
        }
    }
}
