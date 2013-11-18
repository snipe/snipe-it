<?php

class Depreciation extends Elegant {

		// Declare the rules for the form validation
		protected $rules = array(
			'name'   => 'required|min:3',
			'months'   => 'required|min:1|integer',
		);


}
