<?php
namespace App\Http\Transformers;

use App\Models\Import;
use App\Models\Setting;
use Illuminate\Database\Eloquent\Collection;

class ImportsTransformer
{

    public function transformImports($imports)
    {
        $array = array();
        foreach ($imports as $import) {
            $array[] = self::transformImport($import);
        }
        return $array;
    }

    public function transformImport(Import $import)
    {
        $array = [
            'id' => $import->id,
            'file_path' => $import->file_path,
            'filesize' => Setting::fileSizeConvert($import->filesize),
            'name' => $import->name,
            'import_type' => $import->import_type,
            'created_at' => $import->created_at->diffForHumans(),
            'header_row' => $import->header_row,
            'first_row'  => $import->first_row,

        ];

        return $array;
    }

    public function transformImportsDatatable($imports)
    {
        return (new DatatablesTransformer)->transformDatatables($imports);
    }
}
