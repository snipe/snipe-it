<?php

namespace App\Models\Builders;

use Illuminate\Database\Eloquent\Builder;

class CompanyQueryBuilder extends Builder
{
    public function orderParent(string $order): static
    {
        return $this
            ->leftJoin('companies as parent_co', 'companies.parent_id', '=', 'parent_co.id')
            ->addSelect('companies.*')
            ->orderBy('parent_co.name', $order);
    }

    public function orderByCreatedBy(string $order): static
    {
        return $this
            ->leftJoin('users as admin_sort', 'companies.created_by', '=', 'admin_sort.id')
            ->addSelect('companies.*')
            ->orderBy('admin_sort.first_name', $order)
            ->orderBy('admin_sort.last_name', $order);
    }
}
