<?php

namespace App\Models\Builders;

use Illuminate\Database\Eloquent\Builder;

class CategoryQueryBuilder extends Builder
{
    public function requiresAcceptance(): static
    {
        return $this->where('require_acceptance', '=', true);
    }

    public function orderByCreatedBy(string $order): static
    {
        return $this
            ->leftJoin('users as admin_sort', 'categories.created_by', '=', 'admin_sort.id')
            ->addSelect('categories.*')
            ->orderBy('admin_sort.first_name', $order)
            ->orderBy('admin_sort.last_name', $order);
    }
}
