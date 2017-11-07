<?php
namespace App\Http\Transformers;

use App\Models\Company;
use Illuminate\Database\Eloquent\Collection;
use Gate;
use App\Helpers\Helper;

class CompaniesTransformer
{

    public function transformCompanies (Collection $companies, $total)
    {
        $array = array();
        foreach ($companies as $company) {
            $array[] = self::transformCompany($company);
        }
        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }

    public function transformCompany (Company $company = null)
    {
        if ($company) {

            $array = [
                'id' => (int) $company->id,
                'name' => e($company->name),
                'image' =>   ($company->image) ? app('companies_upload_url').e($company->image) : null,
                "created_at" => Helper::getFormattedDateObject($company->created_at, 'datetime'),
                "updated_at" => Helper::getFormattedDateObject($company->updated_at, 'datetime'),
                "assets_count" => (int) $company->assets_count,
                "licenses_count" => (int) $company->licenses_count,
                "accessories_count" => (int) $company->accessories_count,
                "consumables_count" => (int) $company->consumables_count,
                "components_count" => (int) $company->components_count,
                "users_count" => (int) $company->users_count
            ];

            $permissions_array['available_actions'] = [
                'update' => Gate::allows('update', Company::class) ? true : false,
                'delete' => Gate::allows('delete', Company::class) ? true : false,
            ];

            $array += $permissions_array;

            return $array;
        }


    }



}
