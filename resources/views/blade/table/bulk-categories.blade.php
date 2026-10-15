@canany(['update', 'delete'], \App\Models\Category::class)
    <x-table.bulk-actions
        name="category"
        :action_route="route('categories.bulk.edit')"
        model_name="category"
        :actions="[
            'edit' => ['label' => trans('general.bulk_edit')],
            'delete' => ['label' => trans('general.bulk_delete')],
        ]"
    />
@endcanany
