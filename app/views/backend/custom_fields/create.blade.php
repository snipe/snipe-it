@extends('backend/layouts/default')
@section('content')

<?= Form::open(['route' => 'admin.custom_fields.store']) ?>
  Name: {{Form::text("name",Input::old('name'))}}<span class="alert-msg"><?= $errors->first('name'); ?></span><br />
  <input type='submit'>
</form>
<br>{{ link_to_route('admin.custom_fields.index',"Back to Custom Fieldset List")}}
@stop
