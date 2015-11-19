<?php

use \Illuminate\Database\Eloquent\Builder;
use \Illuminate\Database\Eloquent\ScopeInterface;

final class CompanyableChildScope implements ScopeInterface
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @return void
     */
    public function apply(Builder $builder)
    {
        $model = $builder->getModel();
        return Company::scopeCompanyableChildren($model->getCompanyableParents(), $builder);
    }

    /**
     * @todo IMPLEMENT
     * Remove the scope from the given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @return void
     */
    public function remove(Builder $builder)
    {
    }
}
