<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ItemImportRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }

    public function import()
    {
        $filename = config('app.private_uploads') . '/imports/assets/' . $this->get('filename');

        $importerClass = Importer::class;
        switch ($this->get('import-type')) {
            case "asset":
                $importerClass = 'App\Importer\AssetImporter';
                break;
            case "accessory":
                $importerClass = 'App\Importer\AccessoryImporter';
                break;
            case "component":
                die("This is not implemented yet");
                $importerClass = ComponentImporter::class;
                break;
            case "consumable":
                $importerClass = 'App\Importer\ConsumableImporter';
                break;
        }
        $importer = new $importerClass(
            $filename,
            [$this, 'log'],
            [$this, 'progress'],
            [$this, 'errorCallback'],
            false, /*testrun*/
            Auth::id(),
            $this->has('import-update'),
            'firstname.lastname'
        );

        $importer->import();
        return $this->errors;
    }

    public function log($string)
    {
        return; // FUTURE IMPLEMENTATION
    }

    public function progress($count)
    {
        // Open for future
        return;
    }
    public function errorCallback($item, $field, $errorString)
    {
        $this->errors[$item->name][$field] = $errorString;
    }

    private $errors;
}
