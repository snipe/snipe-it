<?php

use Lang;

final class Company extends Elegant
{
    protected $table = 'companies';

    // Declare the rules for the form validation
    protected $rules = ['name' => 'required|alpha_space|min:2|max:255|unique:companies,name,{id}'];

    public static function getSelectList()
    {
        $select_company = Lang::get('admin/companies/general.select_company');
        return ['0' => $select_company] + DB::table('companies')->orderBy('name', 'ASC')->lists('name', 'id');
    }

    public static function getIdFromInput($input)
    {
        $escapedInput = e($input);

        if ($escapedInput == '0') { return NULL;          }
        else                      { return $escapedInput; }
    }
}
