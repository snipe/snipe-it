          <!-- Improvement Title -->
          <div class="form-group {{ $errors->has('title') ? ' has-error' : '' }}">
            <label for="title" class="col-md-3 control-label">{{ trans('admin/asset_maintenances/form.title') }}
            </label>
            <div class="col-md-7{{  (Helper::checkIfRequired($item, 'title')) ? ' required' : '' }}">
                {{ Form::select('title', $title , old('title', $item->title), ['class'=>'select2', 'style'=>'min-width:350px', 'aria-label'=>'title', 'id' => 'title-select']) }}
                {!! $errors->first('title', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
            </div>
        </div>

        <!-- Title -->
        <div class="form-group {{ $errors->has('title') ? ' has-error' : '' }}">
            <label for="title" class="col-md-3 control-label">
                {{ trans('admin/asset_maintenances/form.other_title') }}
            </label>
            <div class="col-md-7{{  (Helper::checkIfRequired($item, 'title')) ? ' required' : '' }}">
                <input class="form-control" type="text" name="title" id="title-input" value="{{ old('title', $item->title) }}" />
                {!! $errors->first('title', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
            </div>
            @include ('partials.more-info', ['helpText' => trans('help.maintenance_title_help'), 'helpPosition' => 'right'])
        </div>