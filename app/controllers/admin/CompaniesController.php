<?php namespace Controllers\Admin;

use AdminController;
use Company;

use Input;
use Lang;
use Redirect;
use Validator;
use View;

final class CompaniesController extends AdminController
{
    public function getIndex()
    {
        return View::make('backend/companies/index')->with('companies', Company::all());
    }

    public function getCreate()
    {
        return View::make('backend/companies/edit')->with('company', new Company);
    }

    public function postCreate()
    {
        $company = new Company;

        if ($company->validate(Input::all()))
        {
            $company->name = e(Input::get('name'));

            if($company->save())
            {
                return Redirect::to('admin/settings/companies')
                    ->with('success', Lang::get('admin/companies/message.create.success'));
            }
            else
            {
                return Redirect::to('admin/settings/companies/create')
                    ->with('error', Lang::get('admin/companies/message.create.error'));
            }
        }
        else
        {
            return Redirect::back()->withInput()->withErrors($company->errors());
        }
    }

    public function getEdit($companyId)
    {
        if (is_null($company = Company::find($companyId)))
        {
            return Redirect::to('admin/settings/companies')
                ->with('error', Lang::get('admin/companies/message.does_not_exist'));
        }
        else
        {
            return View::make('backend/companies/edit')->with('company', $company);
        }
    }

    public function postEdit($companyId)
    {
        if (is_null($company = Company::find($companyId)))
        {
            return Redirect::to('admin/settings/companies')->with('error', Lang::get('admin/companies/message.does_not_exist'));
        }
        else
        {
            $validator = Validator::make(Input::all(), $company->validationRules($companyId));

            if ($validator->fails())
            {
                return Redirect::back()->withInput()->withErrors($validator->messages());
            }
            else
            {
                $company->name = e(Input::get('name'));

                if($company->save())
                {
                    return Redirect::to('admin/settings/companies')
                        ->with('success', Lang::get('admin/companies/message.update.success'));
                }
                else
                {
                    return Redirect::to("admin/settings/companies/$companyId/edit")
                        ->with('error', Lang::get('admin/companies/message.update.error'));
                }
            }
        }
    }

    public function postDelete($companyId)
    {
        if (is_null($company = Company::find($companyId)))
        {
            return Redirect::to('admin/settings/companies')
                ->with('error', Lang::get('admin/companies/message.not_found'));
        }
        else
        {
            try
            {
                $company->delete();
                return Redirect::to('admin/settings/companies')
                    ->with('success', Lang::get('admin/companies/message.delete.success'));
            }
            catch (\Illuminate\Database\QueryException $exception)
            {
                /*
                 * NOTE: This happens when there's a foreign key constraint violation
                 * For example when rows in other tables are referencing this company
                 */
                if ($exception->getCode() == 23000)
                {
                    return Redirect::to('admin/settings/companies')
                        ->with('error', Lang::get('admin/companies/message.assoc_users'));
                }
                else
                {
                    throw $exception;
                }
            }
        }
    }
}
