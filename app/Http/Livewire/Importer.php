<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\Import;
use Storage;

use Log;

class Importer extends Component
{
    public $files;
    public $processDetails;
    public $forcerefresh;

    public $progress; //upload progress - '-1' means don't show
    public $progress_message; //progress message
    public $progress_bar_class;

    public $message; //status/error message?
    public $message_type; //success/error?

    protected $rules = [
        'files.*.file_path' => 'required|string',
        'files.*.created_at' => 'required|string',
        'files.*.filesize' => 'required|integer'
    ];

    protected $listeners = ['hideDetails' => 'hideDetails'];

    public function mount()
    {
        //$this->files = Import::all(); // this *SHOULD* be how it works, but...it doesn't? (note orderBy/get, below)
        //$this->forcerefresh = 0;
        $this->progress = -1; // '-1' means 'don't show the progressbar'
        $this->progress_bar_class = 'progress-bar-warning';
    }

    public function hideMessages()
    {
        $this->message='';
    }

    public function toggleEvent($id)
    {
        Log::error("toggled on: ".$id);
        $this->processDetails = Import::find($id);
    }

    public function hideDetails()
    {
        Log::error("hiding details!");
        $this->processDetails = null;
    }

    public function destroy($id)
    {
        foreach($this->files as $file) {
            \Log::debug("File id is: ".$file->id);
            //\Log::debug("File is: ".print_r($file,true));
            if($id == $file->id) {
                // FIXME - should I do a try/catch on this and use the file_delete_failure or whatever, if needed?
                \Log::debug("I FOUND IT!!!!");
                Storage::delete('imports/'.$file->file_path); // FIXME - last time I ran this, it *didn't* delete the file?!
                $file->delete();

                $this->message = trans('admin/hardware/message.import.file_delete_success');
                $this->message_type = 'success'; // uhm, I mean, I guess?
            }
        }
    }

    public function render()
    {
        $this->files = Import::orderBy('id','desc')->get(); //HACK - slows down renders.
        return view('livewire.importer');
    }
}
