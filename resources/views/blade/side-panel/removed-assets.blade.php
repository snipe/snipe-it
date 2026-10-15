@props([
    'items',
    'message',
    'title' => trans('general.notification_warning'),
])

{{-- Warning side-panel used by bulk checkin/checkout to explain which assets
     were pulled from the selection (because they were already assigned on
     checkout, or already unassigned on checkin) and can't be included in
     the operation. Only renders when the caller has at least one item to
     show. Component intentionally doesn't set a col-md-* on its root so the
     caller can wrap it in whatever column width fits their page layout.
     Table layout mirrors the sibling checkout-target-panel so the two side
     panels read consistently when stacked in the same column. --}}
@if ($items->isNotEmpty())
    <div class="box box-warning" id="removed-assets-warning">
        <div class="box-header with-border">
            <h2 class="box-title">
                <x-icon type="warning" /> {{ $title }}
            </h2>
        </div>
        <div class="box-body">
            <p>{{ $message }}</p>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col"></th>
                        <th scope="col">{{ trans('general.name') }}</th>
                        <th scope="col">{{ trans('admin/hardware/form.tag') }}</th>
                        <th scope="col">{{ trans('admin/hardware/form.serial') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td>
                                @if ($item->image_url ?? null)
                                    <img src="{{ $item->image_url }}" style="max-height: {{ $snipeSettings->thumbnail_max_h }}px; width: auto;" alt="">
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('hardware.show', $item->id) }}">
                                    {{ $item->name }}
                                </a>
                            </td>
                            <td>{{ $item->asset_tag }}</td>
                            <td>{{ $item->serial }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif
