@extends('frontend/layouts/default')

{{-- Page title --}}
@section('title')
{{ $post->title }} ::
@parent
@stop

{{-- Update the Meta Title --}}
@section('meta_title')

@parent
@stop

{{-- Update the Meta Description --}}
@section('meta_description')

@parent
@stop

{{-- Update the Meta Keywords --}}
@section('meta_keywords')

@parent
@stop

{{-- Page content --}}
@section('content')
<h3>{{ $post->title }}</h3>

<p>{{ $post->content() }}</p>

<div>
	<span class="badge badge-info" title="{{ $post->created_at }}">Posted {{ $post->created_at->diffForHumans() }}</span>
</div>

<hr />

<a id="comments"></a>
<h4>{{ $comments->count() }} Comments</h4>

@if ($comments->count())
@foreach ($comments as $comment)
<div class="row">
	<div class="span1">
		<img class="thumbnail" src="{{ $comment->author->gravatar() }}" alt="">
	</div>
	<div class="span11">
		<div class="row">
			<div class="span11">
				<span class="muted">{{ $comment->author->fullName() }}</span>
				&bull;
				<span title="{{ $comment->created_at }}">{{ $comment->created_at->diffForHumans() }}</span>

				<hr />

				{{ $comment->content() }}
			</div>
		</div>
	</div>
</div>
<hr />
@endforeach
@else
<hr />
@endif

@if ( ! Sentry::check())
You need to be logged in to add comments.<br /><br />
Click <a href="{{ route('signin') }}">here</a> to login into your account.
@else
<h4>Add a Comment</h4>
<form method="post" action="{{ route('view-post', $post->slug) }}">
	<!-- CSRF Token -->
	<input type="hidden" name="_token" value="{{ csrf_token() }}" />

	<!-- Comment -->
	<div class="control-group{{ $errors->first('comment', ' error') }}">
		<textarea class="input-block-level" rows="4" name="comment" id="comment">{{ Input::old('comment') }}</textarea>
		{{ $errors->first('comment', '<span class="help-inline">:message</span>') }}
	</div>

	<!-- Form actions -->
	<div class="control-group">
		<div class="controls">
			<input type="submit" class="btn" id="submit" value="Submit" />
		</div>
	</div>
</form>
@endif
@stop
