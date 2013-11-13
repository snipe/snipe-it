<?php namespace Controllers\Admin;

use AdminController;
use Input;
use Lang;
use Post;
use Redirect;
use Sentry;
use Str;
use Validator;
use View;

class BlogsController extends AdminController {

	/**
	 * Show a list of all the blog posts.
	 *
	 * @return View
	 */
	public function getIndex()
	{
		// Grab all the blog posts
		$posts = Post::orderBy('created_at', 'DESC')->paginate(10);

		// Show the page
		return View::make('backend/blogs/index', compact('posts'));
	}

	/**
	 * Blog post create.
	 *
	 * @return View
	 */
	public function getCreate()
	{
		// Show the page
		return View::make('backend/blogs/create');
	}

	/**
	 * Blog post create form processing.
	 *
	 * @return Redirect
	 */
	public function postCreate()
	{
		// Declare the rules for the form validation
		$rules = array(
			'title'   => 'required|min:3',
			'content' => 'required|min:3',
		);

		// Create a new validator instance from our validation rules
		$validator = Validator::make(Input::all(), $rules);

		// If validation fails, we'll exit the operation now.
		if ($validator->fails())
		{
			// Ooops.. something went wrong
			return Redirect::back()->withInput()->withErrors($validator);
		}

		// Create a new blog post
		$post = new Post;

		// Update the blog post data
		$post->title            = e(Input::get('title'));
		$post->slug             = e(Str::slug(Input::get('title')));
		$post->content          = e(Input::get('content'));
		$post->meta_title       = e(Input::get('meta-title'));
		$post->meta_description = e(Input::get('meta-description'));
		$post->meta_keywords    = e(Input::get('meta-keywords'));
		$post->user_id          = Sentry::getId();

		// Was the blog post created?
		if($post->save())
		{
			// Redirect to the new blog post page
			return Redirect::to("admin/blogs/$post->id/edit")->with('success', Lang::get('admin/blogs/message.create.success'));
		}

		// Redirect to the blog post create page
		return Redirect::to('admin/blogs/create')->with('error', Lang::get('admin/blogs/message.create.error'));
	}

	/**
	 * Blog post update.
	 *
	 * @param  int  $postId
	 * @return View
	 */
	public function getEdit($postId = null)
	{
		// Check if the blog post exists
		if (is_null($post = Post::find($postId)))
		{
			// Redirect to the blogs management page
			return Redirect::to('admin/blogs')->with('error', Lang::get('admin/blogs/message.does_not_exist'));
		}

		// Show the page
		return View::make('backend/blogs/edit', compact('post'));
	}

	/**
	 * Blog Post update form processing page.
	 *
	 * @param  int  $postId
	 * @return Redirect
	 */
	public function postEdit($postId = null)
	{
		// Check if the blog post exists
		if (is_null($post = Post::find($postId)))
		{
			// Redirect to the blogs management page
			return Redirect::to('admin/blogs')->with('error', Lang::get('admin/blogs/message.does_not_exist'));
		}

		// Declare the rules for the form validation
		$rules = array(
			'title'   => 'required|min:3',
			'content' => 'required|min:3',
		);

		// Create a new validator instance from our validation rules
		$validator = Validator::make(Input::all(), $rules);

		// If validation fails, we'll exit the operation now.
		if ($validator->fails())
		{
			// Ooops.. something went wrong
			return Redirect::back()->withInput()->withErrors($validator);
		}

		// Update the blog post data
		$post->title            = e(Input::get('title'));
		$post->slug             = e(Str::slug(Input::get('title')));
		$post->content          = e(Input::get('content'));
		$post->meta_title       = e(Input::get('meta-title'));
		$post->meta_description = e(Input::get('meta-description'));
		$post->meta_keywords    = e(Input::get('meta-keywords'));

		// Was the blog post updated?
		if($post->save())
		{
			// Redirect to the new blog post page
			return Redirect::to("admin/blogs/$postId/edit")->with('success', Lang::get('admin/blogs/message.update.success'));
		}

		// Redirect to the blogs post management page
		return Redirect::to("admin/blogs/$postId/edit")->with('error', Lang::get('admin/blogs/message.update.error'));
	}

	/**
	 * Delete the given blog post.
	 *
	 * @param  int  $postId
	 * @return Redirect
	 */
	public function getDelete($postId)
	{
		// Check if the blog post exists
		if (is_null($post = Post::find($postId)))
		{
			// Redirect to the blogs management page
			return Redirect::to('admin/blogs')->with('error', Lang::get('admin/blogs/message.not_found'));
		}

		// Delete the blog post
		$post->delete();

		// Redirect to the blog posts management page
		return Redirect::to('admin/blogs')->with('success', Lang::get('admin/blogs/message.delete.success'));
	}

}
