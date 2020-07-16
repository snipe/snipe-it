<!-- quantity Cost -->
<div class="form-group {{ $errors->has('nds') ? ' has-error' : '' }}">
    <label for="quantity" class="col-md-3 control-label">Количество</label>
    <div class="col-md-9">
        <div class="input-group col-md-4" style="padding-left: 0px;">
            <input class="form-control" type="number" min="1" max="{{ $consumable->numRemaining() }}" step="1" name="quantity" aria-label="quantity" id="quantity" value="1" />
        </div>
        <div class="col-md-9" style="padding-left: 0px;">
            {!! $errors->first('quantity', '<span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span>') !!}
        </div>
    </div>

</div>