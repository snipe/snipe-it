<div class="modal-dialog modal-dialog-centered " role="document">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2 class="modal-title">Reservation</h2>

            </div>
            <div class="modal-body" style="padding-bottom:2em;">
              <form action="{{ route('api.assets.reserve') }}" method="post">
              <div class="alert alert-danger" id="modal_error_msg" style="display:none">
                </div>
                {{ csrf_field() }}
                <div class="dynamic-form-row" style="padding-bottom:10px;">
                  <div class="col-md-4 col-xs-12"><label for="modal-name">Task name:</label></div>
                  <div class="col-md-8 col-xs-12 required"><input type="text" name="name"  class="form-control" /></div>
                </div>

                <div class="dynamic-form-row"  style="padding-bottom:10px;">
                  <div class="col-md-4 col-xs-12"><label for="modal-description">Task description:</label></div>
                  <div class="col-md-8 col-xs-12 required" style="padding-bottom:10px;"><textarea name="description"  class="form-control"></textarea></div>
                </div>

                <div class="dynamic-form-row"  style="padding-bottom:10px;">
                  <div class="col-md-4 col-xs-12"><label for="modal-start_time">Start time:</label></div>
                  <div class="col-md-8 col-xs-12 required"  style="padding-bottom:10px;"><input type="text" name="task_date" class="date" /></div>
                </div>

                <div class="dynamic-form-row"  style="padding-bottom:10px;">
                  <div class="col-md-4 col-xs-12"><label for="modal-end_time">End time:</label></div>
                  <div class="col-md-8 col-xs-12 required"  ><input type="text" name="task_end_date" class="date" /></div>
                </div>
                </form>

              
            </div>
            <div class="modal-footer" style="padding-top:20px;">
                  <!-- <div class="btn btn-primary"><input type="submit" value="store" /></div> -->
                  <button type="button" class="btn btn-primary" id="modal-save" >{{ trans('general.save') }}</button>
                </div>
        </div>
        
</div>

<script src="{{ url('js/jquery-1.11.3.min.js')}}"></script>
<script src="{{ url('js/jquery-ui.min.js')}}"></script>
<script>
    $('.date').datepicker({
        autoclose: true,
        dateFormat: "yy-mm-dd"
    });
</script>