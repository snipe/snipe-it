<?php
namespace App\Http\Controllers;

use App\Models\Company;
use Input;
use Lang;
use Redirect;
use View;
use Illuminate\Http\Request;
use Image;
use App\Http\Requests\ImageUploadRequest;

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
    * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $this->authorize('view', Company::class);

        return view('companies/index');
    }

    /**
    * Returns view to create a new company.
    *
    * @author [Abdullah Alansari] [<ahimta@gmail.com>]
    * @since [v1.8]
    * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $this->authorize('create', Company::class);

        return view('companies/edit')->with('item', new Company);
    }

    /**
     * Save data from new company form.
     *
     * @author [Abdullah Alansari] [<ahimta@gmail.com>]
     * @since [v1.8]
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ImageUploadRequest $request)
    {
        $this->authorize('create', Company::class);

        $company = new Company;
        $company->name = $request->input('name');

        $company = $request->handleImages($company,600, public_path().'/uploads/companies');

        if ($company->save()) {
            return redirect()->route('companies.index')
                ->with('success', trans('admin/companies/message.create.success'));
        }
        return redirect()->back()->withInput()->withErrors($company->getErrors());
    }


    /**
    * Return form to edit existing company.
    *
    * @author [Abdullah Alansari] [<ahimta@gmail.com>]
    * @since [v1.8]
    * @param int $companyId
    * @return \Illuminate\Contracts\View\View
     */
    public function edit($companyId)
    {
        if (is_null($item = Company::find($companyId))) {
            return redirect()->route('companies.index')
                ->with('error', trans('admin/companies/message.does_not_exist'));
        }

        $this->authorize('update', $item);

        return view('companies/edit')->with('item', $item);
    }

    /**
     * Save data from edit company form.
     *
     * @author [Abdullah Alansari] [<ahimta@gmail.com>]
     * @since [v1.8]
     * @param Request $request
     * @param int $companyId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ImageUploadRequest $request, $companyId)
    {
        if (is_null($company = Company::find($companyId))) {
            return redirect()->route('companies.index')->with('error', trans('admin/companies/message.does_not_exist'));
        }

        $this->authorize('update', $company);

        $company->name = $request->input('name');

        // Set the model's image property to null if the image is being deleted
        if ($request->input('image_delete') == 1) {
            $company->image = null;
        }

        $company = $request->handleImages($company,600, public_path().'/uploads/companies');


        if ($company->save()) {
            return redirect()->route('companies.index')
                ->with('success', trans('admin/companies/message.update.success'));
        }
        return redirect()->route('companies.edit', ['company' => $companyId])
            ->with('error', trans('admin/companies/message.update.error'));
    }

    /**
    * Delete company
    *
    * @author [Abdullah Alansari] [<ahimta@gmail.com>]
    * @since [v1.8]
    * @param int $companyId
    * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($companyId)
    {
        if (is_null($company = Company::find($companyId))) {
            return redirect()->route('companies.index')
                ->with('error', trans('admin/companies/message.not_found'));
        } else {

            $this->authorize('delete', $company);

            try {
                $company->delete();
                return redirect()->route('companies.index')
                    ->with('success', trans('admin/companies/message.delete.success'));
            } catch (\Illuminate\Database\QueryException $exception) {
            /*
                 * NOTE: This happens when there's a foreign key constraint violation
                 * For example when rows in other tables are referencing this company
                 */
                if ($exception->getCode() == 23000) {
                    return redirect()->route('companies.index')
                        ->with('error', trans('admin/companies/message.assoc_users'));
                } else {
                    throw $exception;
                }
            }
        }
    }

    public function show($id) {
        $this->authorize('view', Company::class);

        if (is_null($company = Company::find($id))) {
            return redirect()->route('companies.index')
                ->with('error', trans('admin/companies/message.not_found'));
        } else {
            return view('companies/view')->with('company',$company);
        }

    }
}
