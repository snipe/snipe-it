<?php namespace Controllers\Admin;

use AdminController;
use Input;
use Lang;
use Category;
use Redirect;
use Setting;
use DB;
use Sentry;
use Str;
use Validator;
use View;

class AssignmentDefinitionsController extends AdminController
{
     public function getIndex() 
    {
        // Grab all the categories
        $assignmentdefinitions = AssignmentDefinition::orderBy('created_at', 'DESC')->paginate(Setting::getSettings()->per_page);

        // Show the page
        return View::make('backend/assignmentdefinitions/index', compact('assignmentdefinitions'));
    }
}