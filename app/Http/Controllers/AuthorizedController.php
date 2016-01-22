<?php

class AuthorizedController extends Controller
{
    /**
     * Whitelisted auth routes.
     *
     * @var array
     */
    protected $whitelist = array();

    /**
     * Initializer.
     *
     * @return void
     */
    public function __construct()
    {
        // Apply the auth filter
        $this->beforeFilter('auth', array('except' => $this->whitelist));

        // Call parent
        parent::__construct();
    }
}
