<?php

namespace App\Http\Controllers;

use App\Models\Insurance;
use App\Http\Requests\ImageUploadRequest;


class InsuranceController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        parent::__construct();
    }


    /**
     * Returns a view that displays a list of insurance policies
     *
     * @author [M. Bowker] [<github@matthewbowker.net>]
     * @since [v4.3]
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $this->authorize('view', Insurance::class);
        return view('insurance.index', compact('insurance'));
    }


    /**
     * Returns a view that displays information about an insurance policy
     *
     * @author [M. Bowker] [<github@matthewbowker.net>]
     * @since [v4.3]
     * @param int $id ID Number of insurance policy
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $this->authorize('view', Insurance::class);
        if ($insurance = Insurance::find($id)) {
            return view('insurance.view')->with('insurance', $insurance);
        }

        return redirect()->route('insurance.index')->with('error', trans('admin/insurance/message.does_not_exist', compact('id')));
    }


    /**
     * Returns a view that displays a form to create a new insurance.
     *
     * @author [M. Bowker] [<github@matthewbowker.net>]
     * @see InsuranceController::store()
     * @since [v4.3]
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $this->authorize('create', Insurance::class);
        return view('insurance/edit')->with('item', new Insurance);
    }

    /**
     * Returns a view that displays a form to edit an insurance policy.
     *
     * @author [M. Bowker] [<github@matthewbowker.net>]
     * @see InsuranceController::update()
     * @param int $id
     * @since [v4.3]
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id = null)
    {
        $this->authorize('edit', Insurance::class);
        // Check if the manufacturer exists
        if (is_null($item = Insurance::find($id))) {
            return redirect()->route('insurance.index')->with('error', trans('admin/insurance/message.does_not_exist'));
        }
        // Show the page
        return view('insurance/edit', compact('item'));
    }


    /**
     * Validates and stores the data for a new manufacturer.
     *
     * @author [M. Bowker] [<github@matthewbowker.net>]
     * @see InsuranceController::create()
     * @since [v4.3]
     * @param ImageUploadRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ImageUploadRequest $request)
    {

        $this->authorize('create', Insurance::class);
        $insurance = new Insurance;
        $insurance->name     = $request->input('name');
        $insurance->provider     = $request->input('provider');
        $insurance->policy_number     = $request->input('policy_number');
        $insurance->started_at     = $request->input('started_at');
        $insurance->ended_at     = $request->input('ended_at');
        $insurance->notes    = $request->input('notes');

/*
 * TODO: Handle file uploads properly
        if ($request->file('image')) {
            $image = $request->file('image');
            $file_name = str_slug($image->getClientOriginalName()).".".$image->getClientOriginalExtension();
            $path = public_path('uploads/manufacturers/'.$file_name);
            Image::make($image->getRealPath())->resize(200, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save($path);
            $manufacturer->image = $file_name;
        }*/



        if ($insurance->save()) {
            return redirect()->route('insurance.index')->with('success', trans('admin/insurance/message.create.success'));
        }
        return redirect()->back()->withInput()->withErrors($insurance->getErrors());
    }


    /**
     * Validates and stores the updated insurance policy data.
     *
     * @author [M. Bowker] [<github@matthewbowker.net>]
     * @see InsuranceController::edit()
     * @param ImageUploadRequest $request
     * @param int $insuranceId
     * @return \Illuminate\Http\RedirectResponse
     * @since [v4.3]
     */
    public function update(ImageUploadRequest $request, $insuranceId = null)
    {
        $this->authorize('edit', Insurance::class);
        // Check if the manufacturer exists
        if (is_null($insurance = Insurance::find($insuranceId))) {
            // Redirect to the manufacturer  page
            return redirect()->route('insurance.index')->with('error', trans('admin/insurance/message.does_not_exist'));
        }

        // Save the  data
        $insurance->name     = $request->input('name');
        $insurance->provider     = $request->input('provider');
        $insurance->policy_number     = $request->input('policy_number');
        $insurance->started_at     = $request->input('started_at');
        $insurance->ended_at     = $request->input('ended_at');
        $insurance->notes    = $request->input('notes');
/*
 * TODO: Proper file upload support
        $old_image = $manufacturer->image;

        // Set the model's image property to null if the image is being deleted
        if ($request->input('image_delete') == 1) {
            $manufacturer->image = null;
        }

        if ($request->file('image')) {
            $image = $request->file('image');
            $file_name = $manufacturer->id.'-'.str_slug($image->getClientOriginalName()) . "." . $image->getClientOriginalExtension();

            if ($image->getClientOriginalExtension()!='svg') {
                Image::make($image->getRealPath())->resize(500, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->save(app('manufacturers_upload_path').$file_name);
            } else {
                $image->move(app('manufacturers_upload_path'), $file_name);
            }
            $manufacturer->image = $file_name;

        }

        if ((($request->file('image')) && (isset($old_image)) && ($old_image!='')) || ($request->input('image_delete') == 1)) {
            try  {
                unlink(app('manufacturers_upload_path').$old_image);
            } catch (\Exception $e) {
                \Log::error($e);
            }
        }

*/
        if ($insurance->save()) {
            return redirect()->route('insurance.index')->with('success', trans('admin/insurance/message.update.success'));
        }
        return redirect()->back()->withInput()->withErrors($insurance->getErrors());
    }

    public function destroy($insuranceId = null) {
        $this->authorize('destroy', Insurance::class);
        if (is_null($insurance = Insurance::find($insuranceId))) {
            // Redirect to the manufacturer  page
            return redirect()->route('insurance.index')->with('error', trans('admin/insurance/message.does_not_exist'));
        }

/*
        if ($insurance->image) {
            try  {
                unlink(public_path().'/uploads/insurance/'.$insurance->image);
            } catch (\Exception $e) {
                \Log::error($e);
            }
        }
*/

        try  {
            $insurance->delete();
        } catch (\Exception $e) {
            \Log::error($e);
        }
        return redirect()->route('insurance.index')->with('success', trans('admin/insurance/message.delete.success'));
    }
}