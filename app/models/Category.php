<?php

class Category extends Eloquent {

	/**
	 * Deletes a blog post and all the associated comments.
	 *
	 * @return bool
	 */
	public function delete()
	{
		

		// Delete the blog post
		//return parent::delete();
	}

	/**
	 * Returns a formatted post content entry, this ensures that
	 * line breaks are returned.
	 *
	 * @return string
	 */
	public function name()
	{
		return nl2br($this->name);
	}


}
