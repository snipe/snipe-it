<div>
<div class="form-group" style="margin-top: 30px">
   <label for="purchase_date" class="col-md-3 control-label">Fecha estimada de devolución</label>
   <div class="input-group col-md-6">
        <div class="input-group date" data-provide="datepicker" data-date-clear-btn="true" data-date-format="yyyy-mm-dd" data-autoclose="true">
            <input type="text" wire:change="updateReturnDate" class="form-control" placeholder="Seleccione fecha (YYYY-MM-DD)" name="selectReturnDate" id="selectReturnDate"  style="background-color:inherit">
            <span class="input-group-addon"><i class="fas fa-calendar" aria-hidden="true"></i></span>
       </div>
   </div>
</div>
</div>

@push('js')
<script>
    $(document).ready(function() {
        $('#selectReturnDate').on('change', function (e) {
            livewire.emit('setReturnDate', e.target.value)
        });
    });
</script>
@endPush
