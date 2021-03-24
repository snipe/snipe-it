<!-- Purchase Cost -->
<style>
    @import 'star-rating';

    :root {
        --gl-star-empty: url(/img/star-empty.svg);
        --gl-star-full: url(/img/star-full.svg);
        --gl-star-size: 32px;
    }
</style>
<div class="form-group {{ $errors->has('quality') ? ' has-error' : '' }}">
    <label for="quality" class="col-md-3 control-label">Состояние</label>
    <div class="col-md-9">
        <div class="input-group col-md-4" style="padding-left: 0px;">
            <select class="star-rating" name="quality" id="quality">
                @if ($quality = Input::old('quality', (isset($item)) ? $item->quality : ''))
                    @if ($quality == 1)
                        <option value="">Оцените состояние</option>
                        <option value="5">Новое запакованное</option>
                        <option value="4">В отличном состоянии, но использовалось</option>
                        <option value="3">Рабочее, но с небольшими следами повреждений, небольшим загрязнением</option>
                        <option value="2">Частично рабочее или сильно загрязненное</option>
                        <option  selected value="1">Полностью не рабочее</option>
                    @elseif ($quality ==2 )
                        <option value="">Оцените состояние</option>
                        <option value="5">Новое запакованное</option>
                        <option value="4">В отличном состоянии, но использовалось</option>
                        <option value="3">Рабочее, но с небольшими следами повреждений, небольшим загрязнением</option>
                        <option selected value="2">Частично рабочее или сильно загрязненное</option>
                        <option value="1">Полностью не рабочее</option>
                    @elseif ($quality ==3 )
                        <option value="">Оцените состояние</option>
                        <option value="5">Новое запакованное</option>
                        <option value="4">В отличном состоянии, но использовалось</option>
                        <option selected value="3">Рабочее, но с небольшими следами повреждений, небольшим загрязнением</option>
                        <option value="2">Частично рабочее или сильно загрязненное</option>
                        <option value="1">Полностью не рабочее</option>
                    @elseif ($quality ==4 )
                        <option value="">Оцените состояние</option>
                        <option value="5">Новое запакованное</option>
                        <option selected value="4">В отличном состоянии, но использовалось</option>
                        <option value="3">Рабочее, но с небольшими следами повреждений, небольшим загрязнением</option>
                        <option value="2">Частично рабочее или сильно загрязненное</option>
                        <option value="1">Полностью не рабочее</option>
                    @elseif ($quality ==5 )
                        <option value="">Оцените состояние</option>
                        <option selected value="5">Новое запакованное</option>
                        <option value="4">В отличном состоянии, но использовалось</option>
                        <option value="3">Рабочее, но с небольшими следами повреждений, небольшим загрязнением</option>
                        <option value="2">Частично рабочее или сильно загрязненное</option>
                        <option value="1">Полностью не рабочее</option>
                    @else
                        <option selected value="">Оцените состояние</option>
                        <option value="5">Новое запакованное</option>
                        <option value="4">В отличном состоянии, но использовалось</option>
                        <option value="3">Рабочее, но с небольшими следами повреждений, небольшим загрязнением</option>
                        <option value="2">Частично рабочее или сильно загрязненное</option>
                        <option value="1">Полностью не рабочее</option>
                    @endif
                @else
                    <option selected value="">Оцените состояние</option>
                    <option value="5">Новое запакованное</option>
                    <option value="4">В отличном состоянии, но использовалось</option>
                    <option value="3">Рабочее, но с небольшими следами повреждений, небольшим загрязнением</option>
                    <option value="2">Частично рабочее или сильно загрязненное</option>
                    <option value="1">Полностью не рабочее</option>
                @endif
{{--                    <option value="">Оцените состояние</option>--}}
{{--                    <option value="5">Новое запакованное</option>--}}
{{--                    <option value="4">В отличном состоянии, но использовалось</option>--}}
{{--                    <option value="3">Рабочее, но с небольшими следами повреждений, небольшим загрязнением</option>--}}
{{--                    <option value="2">Частично рабочее или сильно загрязненное</option>--}}
{{--                    <option value="1">Полностью не рабочее</option>--}}
            </select>
            {{--            <input class="form-control" type="text" name="quality" aria-label="quality" id="quality" value="{{ Input::old('depreciable_cost', \App\Helpers\Helper::formatCurrencyOutput($item->depreciable_cost)) }}" />--}}
        </div>
        <div class="col-md-9" style="padding-left: 0px;">
            {!! $errors->first('quality', '<span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span>') !!}
        </div>
    </div>
</div>
