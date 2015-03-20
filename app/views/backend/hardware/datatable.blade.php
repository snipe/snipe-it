<table id="{{ $id }}" class="{{ $class }}">
    <colgroup>
        @for ($i = 0; $i < count($columns); $i++)
        <col class="con{{ $i }}" />
        @endfor
    </colgroup>
    <thead>
    <tr>
        @foreach($columns as $i => $c)
        <th align="center" valign="middle" class="head{{ $i }}">{{ $c }}</th>
        @endforeach
    </tr>
    </thead>
    <tfoot>
    <tr>
      <td colspan="12">
	      <select name="bulk_actions">
		      <option value="edit">Edit</option>
		      <option value="labels">Generate Labels</option>
	      </select>
	      <button class="btn btn-default" id="bulkEdit" disabled>Go</button></td>
    </tr>
  </tfoot>
    <tbody>
    @foreach($data as $d)
    <tr>
        @foreach($d as $dd)
        <td>{{ $dd }}</td>
        @endforeach
    </tr>
    @endforeach
    </tbody>
</table>

@if (!$noScript)
    @include(Config::get('datatable::table.script_view'), array('id' => $id, 'options' => $options, 'callbacks' =>  $callbacks))
@endif