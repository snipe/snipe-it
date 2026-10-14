<?php

namespace App\Models\Builders;

use Illuminate\Database\Eloquent\Builder;

class LicenseSeatQueryBuilder extends Builder
{
    public function orderDepartments(string $order): static
    {
        return $this
            ->leftJoin('users as license_seat_users', 'license_seats.assigned_to', '=', 'license_seat_users.id')
            ->leftJoin('departments as license_user_dept', 'license_user_dept.id', '=', 'license_seat_users.department_id')
            ->whereNotNull('license_seats.assigned_to')
            ->orderBy('license_user_dept.name', $order);
    }

    public function orderCompany(string $order): static
    {
        return $this
            ->leftJoin('users as license_seat_users', 'license_seats.assigned_to', '=', 'license_seat_users.id')
            ->leftJoin('companies as license_user_company', 'license_user_company.id', '=', 'license_seat_users.company_id')
            ->whereNotNull('license_seats.assigned_to')
            ->orderBy('license_user_company.name', $order);
    }

    public function byAssigned(): static
    {
        return $this->where(function ($query) {
            $query->whereNotNull('assigned_to')
                ->orWhereNotNull('asset_id');
        });
    }
}
