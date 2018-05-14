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
use League\Csv\Reader;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Artisan;
use App\Models\Asset;

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
     * Process and store a CSV upload file.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
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
                    return response()->json(Helper::formatStandardApiResponse('error', null, $results['error']), 500);
                }

                //TODO: is there a lighter way to do this?
                if (! ini_get("auto_detect_line_endings")) {
                    ini_set("auto_detect_line_endings", '1');
                }
                $reader = Reader::createFromFileObject($file->openFile('r')); //file pointer leak?
                $import->header_row = $reader->fetchOne(0);

                //duplicate headers check
                $duplicate_headers = [];

                for($i = 0; $i<count($import->header_row); $i++) {
                    $header = $import->header_row[$i];
                    if(in_array($header, $import->header_row)) {
                        $found_at = array_search($header, $import->header_row);
                        if($i > $found_at) {
                            //avoid reporting duplicates twice, e.g. "1 is same as 17! 17 is same as 1!!!"
                            //as well as "1 is same as 1!!!" (which is always true)
                            //has to be > because otherwise the first result of array_search will always be $i itself(!)
                            array_push($duplicate_headers,"Duplicate header '$header' detected, first at column: ".($found_at+1).", repeats at column: ".($i+1));
                        }
                    }
                }
                if(count($duplicate_headers) > 0) {
                    return response()->json(Helper::formatStandardApiResponse('error',null, implode("; ",$duplicate_headers)), 500); //should this be '4xx'?
                }

                // Grab the first row to display via ajax as the user picks fields
                $import->first_row = $reader->fetchOne(1);

                $date = date('Y-m-d-his');
                $fixed_filename = str_slug($file->getClientOriginalName());
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
                'files' => $results,
            ];
        }
        return response()->json(Helper::formatStandardApiResponse('error', null, trans('general.feature_disabled')), 500);
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
        // Run a backup immediately before processing
        Artisan::call('backup:run');
        $errors = $request->import(Import::find($import_id));
        $redirectTo = "hardware.index";
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
            case "user":
                $redirectTo = "users.index";
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
            return response()->json(Helper::formatStandardApiResponse('success', null, trans('admin/hardware/message.import.file_delete_success')));
        } catch (\Exception $e) {
            return response()->json(Helper::formatStandardApiResponse('error', null, trans('admin/hardware/message.import.file_delete_error')), 500);
        }
    }
}
