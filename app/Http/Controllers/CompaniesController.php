<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageUploadRequest;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
     * @throws \Illuminate\Auth\Access\AuthorizationException
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
     * @throws \Illuminate\Auth\Access\AuthorizationException
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
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(ImageUploadRequest $request)
    {
        $this->authorize('create', Company::class);

        $company = new Company;
        $company->name = $request->input('name');

        $company = $request->handleImages($company);

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
     * @throws \Illuminate\Auth\Access\AuthorizationException
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
     * @param ImageUploadRequest $request
     * @param int $companyId
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(ImageUploadRequest $request, $companyId)
    {
        if (is_null($company = Company::find($companyId))) {
            return redirect()->route('companies.index')->with('error', trans('admin/companies/message.does_not_exist'));
        }

        $this->authorize('update', $company);

        $company->name = $request->input('name');

        $company = $request->handleImages($company);

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
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy($companyId)
    {
        if (is_null($company = Company::find($companyId))) {
            return redirect()->route('companies.index')
                ->with('error', trans('admin/companies/message.not_found'));
        }

        $this->authorize('delete', $company);
        if (! $company->isDeletable()) {
            return redirect()->route('companies.index')
                    ->with('error', trans('admin/companies/message.assoc_users'));
        }

        if ($company->image) {
            try {
                Storage::disk('public')->delete('companies'.'/'.$company->image);
            } catch (\Exception $e) {
                \Log::debug($e);
            }
        }

        $company->delete();

        return redirect()->route('companies.index')
            ->with('success', trans('admin/companies/message.delete.success'));
    }

    public function show($id)
    {
        $this->authorize('view', Company::class);

        if (is_null($company = Company::find($id))) {
            return redirect()->route('companies.index')
                ->with('error', trans('admin/companies/message.not_found'));
        }

        return view('companies/view')->with('company', $company);
    }
}
