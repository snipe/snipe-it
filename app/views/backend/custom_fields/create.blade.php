@extends('backend/layouts/default')
@section('content')


<?= Form::open(['url' => '/custom_fieldsets']) ?>
  Name: <input type='text' name='name'><br />
  <input type='submit'>
</form>
<br><a href='/custom_fieldsets'>Back to Custom Fieldset List</a>
@stop
