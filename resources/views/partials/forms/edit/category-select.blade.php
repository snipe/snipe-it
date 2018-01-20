<!-- Asset Model -->
<div id="{{ $fieldname }}" class="form-group{{ $errors->has($fieldname) ? ' has-error' : '' }}">

    {{ Form::label($fieldname, $translated_name, array('class' => 'col-md-3 control-label')) }}

    <div class="col-md-7{{  ((isset($required)) && ($required=='true')) ? ' required' : '' }}">
        <select class="js-data-ajax" data-endpoint="categories/{{ (isset($category_type)) ? $category_type : 'assets' }}" name="{{ $fieldname }}" style="width: 100%" id="category_select_id">
            @if ($category_id = Input::old($fieldname, (isset($item)) ? $item->{$fieldname} : ''))
                <option value="{{ $category_id }}" selected="selected">
                    {{ (\App\Models\Category::find($category_id)) ? \App\Models\Category::find($category_id)->name : '' }}
                </option>
            @else
                <option value="">{{ trans('general.select_category') }}</option>
            @endif

        </select>
    </div>
    <div class="col-md-1 col-sm-1 text-left">
        @can('create', \App\Models\Category::class)
            @if ((!isset($hide_new)) || ($hide_new!='true'))
                <a href='{{ route('modal.category',['category_type' => isset($category_type) ? $category_type : 'assets' ]) }}' data-toggle="modal"  data-target="#createModal" data-select='category_select_id' class="btn btn-sm btn-default">New</a>
            @endif
        @endcan
    </div>


    {!! $errors->first($fieldname, '<div class="col-md-8 col-md-offset-3"><span class="alert-msg"><i class="fa fa-times"></i> :message</span></div>') !!}
</div>
