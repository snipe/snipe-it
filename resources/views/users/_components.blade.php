<!-- checked out components table -->
<div class="row">
    <div class="col-md-12">
        @if($components->count() > 0)
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>{{ __('general.name') }}</th>
                    <th>{{ __('general.qty') }}</th>
                    <th>{{ trans('admin/hardware/form.checkedout_to') }}</th>
                    <th>{{ __('general.category') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($components as $component)
                    <tr>
                        <td>
                            <a href="{{ route('components.show', $component->id) }}">{{ $component->name }}</a>
                        </td>
                        <td>{{ $component->pivot->assigned_qty }}</td>
                        <td>
                            @if($component->asset_tag)
                                <a href="{{ route('hardware.show', $component->pivot->asset_id) }}">
                                    {{ $component->asset_tag }}
                                </a>
                                &nbsp; &ndash; &nbsp;
                                <a href="{{ route('models.show', $component->asset_model->id) }}">
                                    {{ $component->asset_model->name }}
                                </a>
                            @else
                                &nbsp;
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('categories.show', $component->category->id) }}">
                                {{ $component->category->name }}
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <div class="alert alert-info alert-block">
                <i class="fa fa-info-circle"></i>
                {{ trans('general.no_results') }}
            </div>
        @endif
    </div>
</div>
