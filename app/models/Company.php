<?php

final class Company extends Elegant
{
    protected $table = 'companies';

    // Declare the rules for the form validation
    protected $rules = ['name' => 'required|alpha_space|min:2|max:255|unique:companies,name,{id}'];

    public static function getSelectList()
    {
        return array('' => '') + DB::table('companies')->orderBy('name', 'ASC')->lists('name', 'id');
    }
}
