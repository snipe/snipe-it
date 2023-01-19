@foreach ($permissions as $area => $permissionsArray)
  @if (count($permissionsArray) == 1)
    <?php $localPermission = $permissionsArray[0]; ?>
    <tbody class="permissions-group">
    <tr class="header-row permissions-row">
      <td class="col-md-5 tooltip-base permissions-item"
        data-toggle="tooltip"
        data-placement="right"
        title="{{ $localPermission['note'] }}"
      >
        @unless (empty($localPermission['label']))
         <h2>{{ $area . ': ' . $localPermission['label'] }}</h2>
        @else
          <h2>{{ $area }}</h2>
        @endunless
      </td>

      <td class="col-md-1 permissions-item">
        <label class="sr-only" for="{{ 'permission['.$localPermission['permission'].']' }}">{{ 'permission['.$localPermission['permission'].']' }}</label>
        @if (($localPermission['permission'] == 'superuser') && (!Auth::user()->isSuperUser()))
          {{ Form::radio('permission['.$localPermission['permission'].']', '1',$userPermissions[$localPermission['permission'] ] == '1',['disabled'=>"disabled", 'class'=>'minimal', 'aria-label'=> 'permission['.$localPermission['permission'].']']) }}
        @elseif (($localPermission['permission'] == 'admin') && (!Auth::user()->hasAccess('admin')))
          {{ Form::radio('permission['.$localPermission['permission'].']', '1',$userPermissions[$localPermission['permission'] ] == '1',['disabled'=>"disabled", 'class'=>'minimal', 'aria-label'=> 'permission['.$localPermission['permission'].']']) }}
        @else
          {{ Form::radio('permission['.$localPermission['permission'].']', '1',$userPermissions[$localPermission['permission'] ] == '1',['value'=>"grant", 'class'=>'minimal',  'aria-label'=> 'permission['.$localPermission['permission'].']']) }}
        @endif

        
      </td>
      <td class="col-md-1 permissions-item">
        <label class="sr-only" for="{{ 'permission['.$localPermission['permission'].']' }}">{{ 'permission['.$localPermission['permission'].']' }}</label>
        @if (($localPermission['permission'] == 'superuser') && (!Auth::user()->isSuperUser()))
          {{ Form::radio('permission['.$localPermission['permission'].']', '-1',$userPermissions[$localPermission['permission'] ] == '-1',['disabled'=>"disabled", 'class'=>'minimal', 'aria-label'=> 'permission['.$localPermission['permission'].']']) }}
        @elseif (($localPermission['permission'] == 'admin') && (!Auth::user()->hasAccess('admin')))
          {{ Form::radio('permission['.$localPermission['permission'].']', '-1',$userPermissions[$localPermission['permission'] ] == '-1',['disabled'=>"disabled", 'class'=>'minimal', 'aria-label'=> 'permission['.$localPermission['permission'].']']) }}
        @else
          {{ Form::radio('permission['.$localPermission['permission'].']', '-1',$userPermissions[$localPermission['permission'] ] == '-1',['value'=>"deny", 'class'=>'minimal',  'aria-label'=> 'permission['.$localPermission['permission'].']']) }}
        @endif
      </td>
      <td class="col-md-1 permissions-item">
        <label class="sr-only" for="{{ 'permission['.$localPermission['permission'].']' }}">
           {{ 'permission['.$localPermission['permission'].']' }}</label>
        @if (($localPermission['permission'] == 'superuser') && (!Auth::user()->isSuperUser()))
          {{ Form::radio('permission['.$localPermission['permission'].']','0',$userPermissions[$localPermission['permission'] ] == '0',['disabled'=>"disabled",'class'=>'minimal',  'aria-label'=> 'permission['.$localPermission['permission'].']'] ) }}
        @elseif (($localPermission['permission'] == 'admin') && (!Auth::user()->hasAccess('admin')))
          {{ Form::radio('permission['.$localPermission['permission'].']','0',$userPermissions[$localPermission['permission'] ] == '0',['disabled'=>"disabled",'class'=>'minimal',  'aria-label'=> 'permission['.$localPermission['permission'].']'] ) }}
        @else
          {{ Form::radio('permission['.$localPermission['permission'].']','0',$userPermissions[$localPermission['permission'] ] == '0',['value'=>"inherit", 'class'=>'minimal',  'aria-label'=> 'permission['.$localPermission['permission'].']'] ) }}
        @endif
      </td>
    </tr>
  </tbody>

  @else <!-- count($permissionsArray) == 1-->
  <tbody class="permissions-group">
    <tr class="header-row permissions-row">
      <td class="col-md-5 header-name">
        <h2> {{ $area }}</h2>
      </td>
      <td class="col-md-1 permissions-item">
        <label for="{{ $area }}" class="sr-only">{{ $area }}</label>
        {{ Form::radio("$area", '1',false,['value'=>"grant", 'class'=>'minimal', 'data-checker-group' => str_slug($area), 'aria-label' => $area]) }}
      </td>
      <td class="col-md-1 permissions-item">
        <label for="{{ $area }}" class="sr-only">{{ $area }}</label>
        {{ Form::radio("$area", '-1',false,['value'=>"deny", 'class'=>'minimal', 'data-checker-group' => str_slug($area), 'aria-label' => $area]) }}
      </td>
      <td class="col-md-1 permissions-item">
        <label for="{{ $area }}" class="sr-only">{{ $area }}</label>
        {{ Form::radio("$area", '0',false,['value'=>"inherit", 'class'=>'minimal', 'data-checker-group' => str_slug($area), 'aria-label' => $area] ) }}
      </td>
    </tr>

    @foreach ($permissionsArray as $index => $permission)
      <tr class="permissions-row">
        @if ($permission['display'])
          <td
            class="col-md-5 tooltip-base permissions-item"
            data-toggle="tooltip"
            data-placement="right"
            title="{{ $permission['note'] }}"
          >
            {{ $permission['label'] }}
          </td>
          <td class="col-md-1 permissions-item">
            <label class="sr-only" for="{{ 'permission['.$permission['permission'].']' }}">{{ 'permission['.$permission['permission'].']' }}</label>

            @if (($permission['permission'] == 'superuser') && (!Auth::user()->isSuperUser()))
              {{ Form::radio('permission['.$permission['permission'].']', '1', $userPermissions[$permission['permission'] ] == '1', ["value"=>"grant", 'disabled'=>'disabled', 'class'=>'minimal radiochecker-'.str_slug($area), 'aria-label'=>'permission['.$permission['permission'].']']) }}
            @else
              {{ Form::radio('permission['.$permission['permission'].']', '1', $userPermissions[ $permission['permission'] ] == '1', ["value"=>"grant",'class'=>'minimal radiochecker-'.str_slug($area), 'aria-label' =>'permission['.$permission['permission'].']']) }}
            @endif
          </td>
          <td class="col-md-1 permissions-item">
            @if (($permission['permission'] == 'superuser') && (!Auth::user()->isSuperUser()))
              {{ Form::radio('permission['.$permission['permission'].']', '-1', $userPermissions[$permission['permission'] ] == '-1', ["value"=>"deny", 'disabled'=>'disabled', 'class'=>'minimal radiochecker-'.str_slug($area), 'aria-label'=>'permission['.$permission['permission'].']']) }}
            @else
              {{ Form::radio('permission['.$permission['permission'].']', '-1', $userPermissions[$permission['permission'] ] == '-1', ["value"=>"deny",'class'=>'minimal radiochecker-'.str_slug($area), 'aria-label'=>'permission['.$permission['permission'].']']) }}
            @endif
          </td>
          <td class="col-md-1 permissions-item">
            @if (($permission['permission'] == 'superuser') && (!Auth::user()->isSuperUser()))
              {{ Form::radio('permission['.$permission['permission'].']', '0', $userPermissions[$permission['permission']] =='0', ["value"=>"inherit", 'disabled'=>'disabled', 'class'=>'minimal radiochecker-'.str_slug($area), 'aria-label'=>'permission['.$permission['permission'].']']) }}
            @else
              {{ Form::radio('permission['.$permission['permission'].']', '0', $userPermissions[$permission['permission']] =='0', ["value"=>"inherit", 'class'=>'minimal radiochecker-'.str_slug($area), 'aria-label'=>'permission['.$permission['permission'].']']) }}
            @endif
          </td>
        @endif
      </tr>
    @endforeach
    </tbody>
  @endif
@endforeach
