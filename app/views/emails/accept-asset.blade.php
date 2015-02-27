@extends('emails/layouts/default')

@section('content')
<p>Hello {{{ $first_name }}},</p>


<p>A new item ({{{ strtoupper($item_name) }}}) has been checked out to you. 
	
@if (($require_acceptance==1) && ($eula!=''))
	
	Please read the terms of use below, and click on the link at the bottom to confirm that you read and agree to the terms of use, and have received the asset.

@elseif (($require_acceptance==1) && ($eula==''))

	Please click on the link at the bottom to confirm that you have received the asset.

@elseif (($require_acceptance==0) && ($eula!=''))

	Please read the terms of use below.

@endif
	
</p>


<p>{{ $eula }}</p>

@if ($require_acceptance==1)
<p><strong><a href="{{{ Config::get('app.url') }}}/account/accept-asset/{{ $log_id }}">I have read and agree to the terms of use, and have received this item.</a></strong></p>
@endif

<p>{{{ Setting::getSettings()->site_name }}}</p>
@stop
