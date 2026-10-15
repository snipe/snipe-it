<!-- Asset Model -->
<div id="{{ $fieldname }}" class="form-group{{ $errors->has($fieldname) ? ' has-error' : '' }}">

    <label for="{{ $fieldname }}" class="col-md-3 control-label">{{ $translated_name }}</label>

    <div class="col-md-7">
        <select class="js-data-ajax" data-endpoint="categories/{{ (isset($category_type)) ? $category_type : 'assets' }}" data-placeholder="{{ trans('general.select_category') }}" name="{{ $fieldname }}" style="width: 100%" id="category_select_id" aria-label="{{ $fieldname }}" {!!  ((isset($item)) && (Helper::checkIfRequired($item, $fieldname))) ? ' required ' : '' !!}{{ (isset($multiple) && ($multiple=='true')) ? " multiple='multiple'" : '' }}>
            @isset ($selected)
                @if (!is_iterable($selected))
                    @php
                        $selected = [$selected];
                    @endphp
                @endif
                @foreach ($selected as $category_id)
                    <option value="{{ $category_id }}" selected="selected" role="option" aria-selected="true"  role="option">
                        {{ \App\Models\Category::find($category_id)->name }}
                    </option>
                @endforeach
            @endisset
            @if ($category_id = old($fieldname, (isset($item)) ? $item->{$fieldname} : ''))
                <option value="{{ $category_id }}" selected="selected" role="option" aria-selected="true"  role="option">
                    {{ (\App\Models\Category::find($category_id)) ? \App\Models\Category::find($category_id)->name : '' }}
                </option>
            @endif

        </select>
    </div>
    <div class="col-md-1 col-sm-1 text-left">
        @can('create', \App\Models\Category::class)
            @if ((!isset($hide_new)) || ($hide_new!='true'))
                <x-button.modal-add :routeArgs="['type' => 'category', 'category_type' => isset($category_type) ? $category_type : 'assets']" target="category_select_id"/>
            @endif
        @endcan
    </div>


    <div class="col-md-8 col-md-offset-3"><x-form.error :name="$fieldname" /></div>

    <div class="col-md-8 col-md-offset-3"><x-form.error name="category_type" /></div>
</div>
