<div>
    <div class="form-group ">
        <label for="name" class="col-md-3 control-label">Asignar a:</label>
        <div class="col-md-6 col-sm-12">
            <select name="selectUser" id="selectUser" class="form-control select2"  >
                <option value="">Seleccione</option>
                @forEach($users as $user)
                <option value="{{$user['id']}}">{{$user['last_name'] .', '.$user['first_name']}} - ({{$user['username']}}) - #{{$user['id']}}</option>
                @endForEach
            </select>
        </div>
    </div>
</div>

@push('js')
<script>
    $(document).ready(function() {
        window.initSelectCompanyDrop=()=>{
            $('#selectUser').select2({
                placeholder: 'Seleccione',
                allowClear: true});
        }
        initSelectCompanyDrop();
        $('#selectUser').on('change', function (e) {
            livewire.emit('setSelectedUser', e.target.value)
        });
        window.livewire.on('select2',()=>{
            initSelectCompanyDrop();
        });
    });
</script>
@endPush