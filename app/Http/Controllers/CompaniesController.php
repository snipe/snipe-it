<?php
/**
 * This controller handles all actions related to Company support for
 * the Snipe-IT Asset Management application.
 *
 * PHP version 5.5.9
 * @package    Snipe-IT
 * @version    v2.0
 */
 namespace App\Http\Controllers;

use App\Models\Company;
use Input;
use Lang;
use Redirect;
use View;

final class CompaniesController extends Controller
{
    public function getIndex()
    {
        return View::make('companies/index')->with('companies', Company::all());
    }

    public function getCreate()
    {
        return View::make('companies/edit')->with('company', new Company);
    }

    public function postCreate()
    {
        $company = new Company;

            $company->name = e(Input::get('name'));

        if ($company->save()) {
            return Redirect::to('admin/settings/companies')
                ->with('success', Lang::get('admin/companies/message.create.success'));
        } else {
            return Redirect::back()->withInput()->withErrors($company->getErrors());
        }

    }

    public function getEdit($companyId)
    {
        if (is_null($company = Company::find($companyId))) {
            return Redirect::to('admin/settings/companies')
                ->with('error', Lang::get('admin/companies/message.does_not_exist'));
        } else {
            return View::make('companies/edit')->with('company', $company);
        }
    }

    public function postEdit($companyId)
    {
        if (is_null($company = Company::find($companyId))) {
            return Redirect::to('admin/settings/companies')->with('error', Lang::get('admin/companies/message.does_not_exist'));
        } else {


            $company->name = e(Input::get('name'));

            if ($company->save()) {
                return Redirect::to('admin/settings/companies')
                    ->with('success', Lang::get('admin/companies/message.update.success'));
            } else {
                return Redirect::to("admin/settings/companies/$companyId/edit")
                    ->with('error', Lang::get('admin/companies/message.update.error'));
            }

        }
    }

    public function postDelete($companyId)
    {
        if (is_null($company = Company::find($companyId))) {
            return Redirect::to('admin/settings/companies')
                ->with('error', Lang::get('admin/companies/message.not_found'));
        } else {
            try {
                $company->delete();
                return Redirect::to('admin/settings/companies')
                    ->with('success', Lang::get('admin/companies/message.delete.success'));
            } catch (\Illuminate\Database\QueryException $exception) {
            /*
                 * NOTE: This happens when there's a foreign key constraint violation
                 * For example when rows in other tables are referencing this company
                 */
                if ($exception->getCode() == 23000) {
                    return Redirect::to('admin/settings/companies')
                        ->with('error', Lang::get('admin/companies/message.assoc_users'));
                } else {
                    throw $exception;
                }
            }
        }
    }
}
