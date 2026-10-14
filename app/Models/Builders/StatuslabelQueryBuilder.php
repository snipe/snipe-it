<?php

namespace App\Models\Builders;

use Illuminate\Database\Eloquent\Builder;

class StatuslabelQueryBuilder extends Builder
{
    public function pending(): static
    {
        return $this->where('pending', '=', 1)
            ->where('archived', '=', 0)
            ->where('deployable', '=', 0);
    }

    public function archived(): static
    {
        return $this->where('pending', '=', 0)
            ->where('archived', '=', 1)
            ->where('deployable', '=', 0);
    }

    public function deployable(): static
    {
        return $this->where('pending', '=', 0)
            ->where('archived', '=', 0)
            ->where('deployable', '=', 1);
    }

    public function undeployable(): static
    {
        return $this->where('pending', '=', 0)
            ->where('archived', '=', 0)
            ->where('deployable', '=', 0);
    }

    public function orderByCreatedBy(string $order): static
    {
        return $this
            ->leftJoin('users as admin_sort', 'status_labels.created_by', '=', 'admin_sort.id')
            ->addSelect('status_labels.*')
            ->orderBy('admin_sort.first_name', $order)
            ->orderBy('admin_sort.last_name', $order);
    }
}
