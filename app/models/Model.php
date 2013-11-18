<?php

class Model extends Elegant {

		// Declare the rules for the form validation
		protected $rules = array(
			'name'   => 'required|min:3',
		);

}
