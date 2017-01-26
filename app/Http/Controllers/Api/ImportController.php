<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\ItemImportRequest;
use App\Http\Transformers\ImportsTransformer;
use App\Models\Company;
use App\Models\Import;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class ImportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $imports = Import::latest()->get();
        return (new ImportsTransformer)->transformImports($imports);

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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        if (!Company::isCurrentUserAuthorized()) {
            return redirect()->route('hardware.index')->with('error', trans('general.insufficient_permissions'));
        } elseif (!config('app.lock_passwords')) {
            $files = Input::file('files');
            $path = config('app.private_uploads').'/imports';
            $results = [];
            $import = new Import;
            foreach ($files as $file) {

                if (!in_array($file->getMimeType(), array(
                    'application/vnd.ms-excel',
                    'text/csv',
                    'text/plain',
                    'text/comma-separated-values',
                    'text/tsv'))) {
                    $results['error']='File type must be CSV';
                    return $results;
                }

                $date = date('Y-m-d-his');
                $fixed_filename = str_replace(' ', '-', $file->getClientOriginalName());
                try {
                    $file->move($path, $date.'-'.$fixed_filename);
                } catch (FileException $exception) {
                    $results['error']=trans('admin/hardware/message.upload.error');
                    if (config('app.debug')) {
                        $results['error'].= ' ' . $exception->getMessage();
                    }
                    return response()->json(Helper::formatStandardApiResponse('error', null, $results['error']), 500);

                }
                $file_name = date('Y-m-d-his').'-'.$fixed_filename;
                $import->file_path = $file_name;
                $import->filesize = filesize($path.'/'.$file_name);
                $import->save();
                $results[] = $import;
            }
            $results = (new ImportsTransformer)->transformImports($results);
            return [
                'files' => $results
            ];
        }
        $results['error']=trans('general.feature_disabled');
        return $results;
    }
    /**
     * Processes the specified Import.
     *
     * @param  \App\Import  $import
     * @return \Illuminate\Http\Response
     */
    public function process(ItemImportRequest $request, $import_id)
    {
        $this->authorize('create', Asset::class);
        $errors = $request->import(Import::find($import_id));
        $redirectTo = "hardware";
        switch ($request->get('import-type')) {
            case "asset":
                $redirectTo = "hardware.index";
                break;
            case "accessory":
                $redirectTo = "accessories.index";
                break;
            case "consumable":
                $redirectTo = "consumables.index";
                break;
            case "component":
                $redirectTo = "components.index";
                break;
            case "license":
                $redirectTo = "licenses.index";
                break;
        }

        if ($errors) { //Failure
            return response()->json(Helper::formatStandardApiResponse('import-errors', null, $errors), 500);
        }
        //Flash message before the redirect
        Session::flash('success', trans('admin/hardware/message.import.success'));
        return response()->json(Helper::formatStandardApiResponse('success', null, ['redirect_url' => route($redirectTo)]));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Import  $import
     * @return \Illuminate\Http\Response
     */
    public function show(Import $import)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Import  $import
     * @return \Illuminate\Http\Response
     */
    public function edit(Import $import)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Import  $import
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Import $import)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Import  $import
     * @return \Illuminate\Http\Response
     */
    public function destroy($import_id)
    {
        $this->authorize('create', Asset::class);
        $import = Import::find($import_id);
        try {
            unlink(config('app.private_uploads').'/imports/'.$import->file_path);
            $import->delete();
            return response()->json(Helper::formatStandardApiResponse('success', null, trans('message.import.file_delete_success')));
        } catch (\Exception $e) {
            return response()->json(Helper::formatStandardApiResponse('error', null, trans('admin/hardware/message.import.file_delete_error')), 500);
        }
    }
}
