{{-- Some room for the modals --}}
<div class="modal fade" id="createModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Modal title</h4>
            </div>
            <div class="modal-body">
                <div class="dynamic-form-row">
                    <div class="col-md-4 col-xs-12"><label for="modal-name">{{ trans('general.name') }}:
                        </label></div>
                    <div class="col-md-8 col-xs-12 required"><input type='text' id='modal-name' class="form-control"></div>
                </div>

                <div class="dynamic-form-row">
                    <div class="col-md-4 col-xs-12"><label for="modal-manufacturer_id">{{ trans('general.manufacturer') }}:
                        </label></div>
                    <div class="col-md-8 col-xs-12 required">{{ Form::select('modal-manufacturer', $manufacturer , '', array('class'=>'select2 parent', 'style'=>'width:100%','id' =>'modal-manufacturer_id')) }}</div>
                </div>

                <div class="dynamic-form-row">
                    <div class="col-md-4 col-xs-12"><label for="modal-category_id">{{ trans('general.category') }}:
                        </label></div>
                    <div class="col-md-8 col-xs-12 required">{{ Form::select('modal-category', $category ,'', array('class'=>'select2 parent', 'style'=>'width:100%','id' => 'modal-category_id')) }}</div>
                </div>

                <div class="dynamic-form-row">
                    <div class="col-md-4 col-xs-12"><label for="modal-model_number">{{ trans('general.model_no') }}:</label></div>
                    <div class="col-md-8 col-xs-12"><input type='text' id='modal-model_number' class="form-control"></div>
                </div>

                <div class="dynamic-form-row">
                    <div class="col-md-4 col-xs-12"><label for="modal-statuslabel_types">{{ trans('admin/statuslabels/table.status_type') }}:
                        </label></div>
                    <div class="col-md-8 col-xs-12 required">{{ Form::select('modal-statuslabel_types', $statuslabel_types, '', array('class'=>'select2', 'style'=>'width:90%','id' =>'modal-statuslabel_types')) }}</div>
                </div>

                <div class="dynamic-form-row">
                    <div class="col-md-4 col-xs-12"><label for="modal-city">{{ trans('general.city') }}:</label></div>
                    <div class="col-md-8 col-xs-12 required"><input type='text' id='modal-city' class="form-control"></div>
                </div>

                <div class="dynamic-form-row">
                    <div class="col-md-4 col-xs-12 country"><label for="modal-country">{{ trans('general.country') }}:</label></div>
                    <div class="col-md-8 col-xs-12">{!! Form::countries('country', Input::old('country'), 'select2 country',"modal-country") !!}</div>
                </div>

                <div class="dynamic-form-row">
                    <div class="col-md-4 col-xs-12"><label for="modal-fieldset_id">{{ trans('admin/models/general.fieldset') }}:</label></div>
                    <div class="col-md-8 col-xs-12">{{ Form::select('custom_fieldset', \App\Helpers\Helper::customFieldsetList(),Input::old('custom_fieldset'), array('class'=>'select2', 'id'=>'modal-fieldset_id', 'style'=>'width:350px')) }}</div>
                </div>

                <div class="dynamic-form-row">
                    <div class="col-md-4 col-xs-12"><label for="modal-first_name">{{ trans('general.first_name') }}:</label></div>
                    <div class="col-md-8 col-xs-12 required"><input type='text' id='modal-first_name' class="form-control"></div>
                </div>

                <div class="dynamic-form-row">
                    <div class="col-md-4 col-xs-12"><label for="modal-last_name">{{ trans('general.last_name') }}:</label></div>
                    <div class="col-md-8 col-xs-12"><input type='text' id='modal-last_name' class="form-control"> </div>
                </div>

                <div class="dynamic-form-row">
                    <div class="col-md-4 col-xs-12"><label for="modal-username">{{ trans('admin/users/table.username') }}:</label></div>
                    <div class="col-md-8 col-xs-12 required"><input type='text' id='modal-username' class="form-control"></div>
                </div>

                <div class="dynamic-form-row">
                    <div class="col-md-4 col-xs-12"><label for="modal-password">{{ trans('admin/users/table.password') }}:</label></div>
                    <div class="col-md-8 col-xs-12 required"><input type='password' id='modal-password' class="form-control">
                        <a href="#" class="left" id="genPassword">Generate</a>
                    </div>
                </div>

                <div class="dynamic-form-row">
                    <div class="col-md-4 col-xs-12"><label for="modal-password_confirm">{{ trans('admin/users/table.password_confirm') }}:</label></div>
                    <div class="col-md-8 col-xs-12 required"><input type='password' id='modal-password_confirm' class="form-control">
                        <div id="generated-password"></div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('button.cancel') }}</button>
                <button type="button" class="btn btn-primary" id="modal-save">{{ trans('general.save') }}</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
