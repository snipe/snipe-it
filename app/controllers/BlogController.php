<?php

class BlogController extends BaseController {

	/**
	 * Returns all the blog posts.
	 *
	 * @return View
	 */
	public function getIndex()
	{
		// Get all the blog posts
		$posts = Post::with(array(
			'author' => function($query)
			{
				$query->withTrashed();
			},
		))->orderBy('created_at', 'DESC')->paginate();

		// Show the page
		return View::make('frontend/blog/index', compact('posts'));
	}

	/**
	 * View a blog post.
	 *
	 * @param  string  $slug
	 * @return View
	 * @throws NotFoundHttpException
	 */
	public function getView($slug)
	{
		// Get this blog post data
		$post = Post::with(array(
			'author' => function($query)
			{
				$query->withTrashed();
			},
			'comments',
		))->where('slug', $slug)->first();

		// Check if the blog post exists
		if (is_null($post))
		{
			// If we ended up in here, it means that a page or a blog post
			// don't exist. So, this means that it is time for 404 error page.
			return App::abort(404);
		}

		// Get this post comments
		$comments = $post->comments()->with(array(
			'author' => function($query)
			{
				$query->withTrashed();
			},
		))->orderBy('created_at', 'DESC')->get();

		// Show the page
		return View::make('frontend/blog/view-post', compact('post', 'comments'));
	}

	/**
	 * View a blog post.
	 *
	 * @param  string  $slug
	 * @return Redirect
	 */
	public function postView($slug)
	{
		// The user needs to be logged in, make that check please
		if ( ! Sentry::check())
		{
			return Redirect::to("blog/$slug#comments")->with('error', 'You need to be logged in to post comments!');
		}

		// Get this blog post data
		$post = Post::where('slug', $slug)->first();

		// Declare the rules for the form validation
		$rules = array(
			'comment' => 'required|min:3',
		);

		// Create a new validator instance from our dynamic rules
		$validator = Validator::make(Input::all(), $rules);

		// If validation fails, we'll exit the operation now
		if ($validator->fails())
		{
			// Redirect to this blog post page
			return Redirect::to("blog/$slug#comments")->withInput()->withErrors($validator);
		}

		// Save the comment
		$comment = new Comment;
		$comment->user_id = Sentry::getUser()->id;
		$comment->content = e(Input::get('comment'));

		// Was the comment saved with success?
		if($post->comments()->save($comment))
		{
			// Redirect to this blog post page
			return Redirect::to("blog/$slug#comments")->with('success', 'Your comment was successfully added.');
		}

		// Redirect to this blog post page
		return Redirect::to("blog/$slug#comments")->with('error', 'There was a problem adding your comment, please try again.');
	}

}
