<?php

namespace App\Models\Builders;

use Illuminate\Database\Eloquent\Builder;

class DepartmentQueryBuilder extends Builder
{
    public function orderLocation(string $order): static
    {
        return $this
            ->leftJoin('locations as department_location', 'departments.location_id', '=', 'department_location.id')
            ->orderBy('department_location.name', $order);
    }

    public function orderManager(string $order): static
    {
        return $this
            ->leftJoin('users as department_user', 'departments.manager_id', '=', 'department_user.id')
            ->orderBy('department_user.first_name', $order)
            ->orderBy('department_user.last_name', $order);
    }

    public function orderCompany(string $order): static
    {
        return $this
            ->leftJoin('companies as company_sort', 'departments.company_id', '=', 'company_sort.id')
            ->orderBy('company_sort.name', $order);
    }

    public function orderByCreatedBy(string $order): static
    {
        return $this
            ->leftJoin('users as admin_sort', 'departments.created_by', '=', 'admin_sort.id')
            ->addSelect('departments.*')
            ->orderBy('admin_sort.first_name', $order)
            ->orderBy('admin_sort.last_name', $order);
    }
}
