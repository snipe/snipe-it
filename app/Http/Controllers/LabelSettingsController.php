<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLabelSettingsRequest;
use App\Http\Requests\UpdateLabelSettingsRequest;
use App\Models\LabelSettings;

class LabelSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreLabelSettingsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLabelSettingsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LabelSettings  $labelSettings
     * @return \Illuminate\Http\Response
     */
    public function show(LabelSettings $labelSettings)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LabelSettings  $labelSettings
     * @return \Illuminate\Http\Response
     */
    public function edit(LabelSettings $labelSettings)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateLabelSettingsRequest  $request
     * @param  \App\Models\LabelSettings  $labelSettings
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLabelSettingsRequest $request, LabelSettings $labelSettings)
    {
        $labelSettings::find();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LabelSettings  $labelSettings
     * @return \Illuminate\Http\Response
     */
    public function destroy(LabelSettings $labelSettings)
    {
        //
    }

    /**
     * Saves settings from form.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     *
     * @since [v4.0]
     *
     * @return View
     */
    public function postLabels(Request $request)
    {
        if (is_null($label_setting = LabelSettings::getLabelSettings())) {
            return redirect()->to('admin')->with('error', trans('admin/settings/message.update.error'));
        }
        $label_setting->labels_per_page = $request->input('labels_per_page');
        $label_setting->labels_width = $request->input('labels_width');
        $label_setting->labels_height = $request->input('labels_height');
        $label_setting->labels_pmargin_left = $request->input('labels_pmargin_left');
        $label_setting->labels_pmargin_right = $request->input('labels_pmargin_right');
        $label_setting->labels_pmargin_top = $request->input('labels_pmargin_top');
        $label_setting->labels_pmargin_bottom = $request->input('labels_pmargin_bottom');
        $label_setting->labels_display_bgutter = $request->input('labels_display_bgutter');
        $label_setting->labels_display_sgutter = $request->input('labels_display_sgutter');
        $label_setting->labels_fontsize = $request->input('labels_fontsize');
        $label_setting->labels_pagewidth = $request->input('labels_pagewidth');
        $label_setting->labels_pageheight = $request->input('labels_pageheight');
        $label_setting->labels_display_company_name = $request->input('labels_display_company_name', '0');
        $label_setting->labels_display_company_name = $request->input('labels_display_company_name', '0');



        if ($request->filled('labels_display_name')) {
            $label_setting->labels_display_name = 1;
        } else {
            $label_setting->labels_display_name = 0;
        }

        if ($request->filled('labels_display_serial')) {
            $label_setting->labels_display_serial = 1;
        } else {
            $label_setting->labels_display_serial = 0;
        }

        if ($request->filled('labels_display_tag')) {
            $label_setting->labels_display_tag = 1;
        } else {
            $label_setting->labels_display_tag = 0;
        }

        if ($request->filled('labels_display_tag')) {
            $label_setting->labels_display_tag = 1;
        } else {
            $label_setting->labels_display_tag = 0;
        }

        if ($request->filled('labels_display_model')) {
            $label_setting->labels_display_model = 1;
        } else {
            $label_setting->labels_display_model = 0;
        }

        if ($label_setting->save()) {
            return redirect()->route('settings.index')
                ->with('success', trans('admin/settings/message.update.success'));
        }

        return redirect()->back()->withInput()->withErrors($label_setting->getErrors());
    }

    /**
     * Return a form to allow a super admin to update settings.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     *
     * @since [v4.0]
     *
     * @return View
     */
    public function getLabels()
    {
        $label_settings = LabelSettings::getLabelSettings();

        return view('settings.labels', compact('label_settings'));
    }
}
