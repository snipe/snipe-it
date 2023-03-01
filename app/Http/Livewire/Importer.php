<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\Import;
use Storage;

use Log;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class Importer extends Component
{
    use AuthorizesRequests;

    public $files;
    public $processDetails;

    public $progress; //upload progress - '-1' means don't show
    public $progress_message; //progress message
    public $progress_bar_class;

    public $message; //status/error message?
    public $message_type; //success/error?

    public $import_errors; //

    protected $rules = [
        'files.*.file_path' => 'required|string',
        'files.*.created_at' => 'required|string',
        'files.*.filesize' => 'required|integer'
    ];

    protected $listeners = [
        'hideDetails' => 'hideDetails',
        'importError' => 'importError',
        'alert' => 'alert'
    ]; // TODO - try using the 'short' form of this?

    public function mount()
    {
        $this->authorize('import');
        $this->progress = -1; // '-1' means 'don't show the progressbar'
        $this->progress_bar_class = 'progress-bar-warning';
    }

    public function hideMessages()
    {
        $this->message='';
    }

    public function importError($errors)
    {
        \Log::debug("Errors fired!!!!");
        \Log::debug(" Here they are...".print_r($errors,true));
        $this->import_errors = $errors;
    }

    public function alert($obj)
    {
        \Log::debug("Alert object received: ".print_r($obj,true));
        $this->message = $obj;
        $this->message_type = "danger";
    }

    public function toggleEvent($id)
    {
        $this->processDetails = Import::find($id);
    }

    public function hideDetails()
    {
        $this->processDetails = null;
    }

    public function destroy($id)
    {
        foreach($this->files as $file) {
            \Log::debug("File id is: ".$file->id);
            if($id == $file->id) {
                if(Storage::delete('private_uploads/imports/'.$file->file_path)) {
                    $file->delete();

                    $this->message = trans('admin/hardware/message.import.file_delete_success');
                    $this->message_type = 'success';
                    return;
                } else {
                    $this->message = trans('admin/hardware/message.import.file_delete_error');
                    $this->message_type = 'danger';
                }
            }
        }
    }

    public function render()
    {
        $this->files = Import::orderBy('id','desc')->get(); //HACK - slows down renders.
        return view('livewire.importer')
                ->extends('layouts.default')
                ->section('content');
    }
}
