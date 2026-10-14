<?php

namespace App\Models\Builders;

use Illuminate\Database\Eloquent\Builder;

class PredefinedKitQueryBuilder extends Builder
{
    public function orderByCreatedBy(string $order): static
    {
        return $this
            ->leftJoin('users as admin_sort', 'kits.created_by', '=', 'admin_sort.id')
            ->addSelect('kits.*')
            ->orderBy('admin_sort.first_name', $order)
            ->orderBy('admin_sort.last_name', $order);
    }
}
