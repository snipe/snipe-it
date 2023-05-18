<?php

namespace App\Http\Livewire;

use App\Models\CustomField;
use Livewire\Component;

use App\Models\Import;
use Storage;

use Log;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class Importer extends Component
{
    use AuthorizesRequests;

    public $files;

    public $progress; //upload progress - '-1' means don't show
    public $progress_message;
    public $progress_bar_class;

    public $message; //status/error message?
    public $message_type; //success/error?

    //originally from ImporterFile
    public $import_errors; //
    public ?Import $activeFile = null;
    public $importTypes;
    public $columnOptions;
    public $statusType;
    public $statusText;
    public $update;
    public $send_welcome;
    public $run_backup;
    public $field_map; // we need a separate variable for the field-mapping, because the keys in the normal array are too complicated for Livewire to understand
    public $file_id; // TODO: I can't figure out *why* we need this, but it really seems like we do. I can't seem to pull the id from the activeFile for some reason?

    protected $rules = [
        'files.*.file_path' => 'required|string',
        'files.*.created_at' => 'required|string',
        'files.*.filesize' => 'required|integer',
        'activeFile' => 'Import',
        'activeFile.import_type' => 'string',
        'activeFile.field_map' => 'array',
        'activeFile.header_row' => 'array',
        'field_map' => 'array'
    ];

    public function generate_field_map()
    {
        \Log::debug("header row is: ".print_r($this->activeFile->header_row,true));
        \Log::debug("Field map is: ".print_r($this->field_map,true));
        $tmp = array_combine($this->activeFile->header_row, $this->field_map);
        return json_encode(array_filter($tmp));
    }

    // all of these 'statics', alas, may have to change to something else to handle translations?
    // I'm not sure. Maybe I use them to 'populate' the translations? TBH, I don't know yet.
    static $general = [
        'category' => 'Category',
        'company' => 'Company',
        'email' => 'Email',
        'item_name' => 'Item Name',
        'location' => 'Location',
        'maintained' => 'Maintained',
        'manufacturer' => 'Manufacturer',
        'order_number' => 'Order Number',
        'purchase_cost' => 'Purchase Cost',
        'purchase_date' => 'Purchase Date',
        'quantity' => 'Quantity',
        'requestable' => 'Requestable',
        'serial' => 'Serial Number',
        'supplier' => 'Supplier',
        'username' => 'Username',
        'department' => 'Department',
    ];

    static $accessories = [
        'model_number' => 'Model Number',
        'notes' => 'Notes',
    ];

    static $assets = [
        'asset_tag' => 'Asset Tag',
        'asset_model' => 'Model Name',
        'asset_notes' => 'Asset Notes',
        'model_notes' => 'Model Notes',
        'byod' => 'BYOD',
        'checkout_class' => 'Checkout Type',
        'checkout_location' => 'Checkout Location',
        'image' => 'Image Filename',
        'model_number' => 'Model Number',
        'full_name' => 'Full Name',
        'status' => 'Status',
        'warranty_months' => 'Warranty Months',
        'asset_eol_date' => 'EOL Date',
    ];

    static $consumables = [
        'item_no' => "Item Number",
        'model_number' => "Model Number",
        'notes' => 'Notes',
        'min_amt' => "Minimum Quantity",
    ];

    static $licenses = [
        'asset_tag' => 'Assigned To Asset',
        'expiration_date' => 'Expiration Date',
        'full_name' => 'Full Name',
        'license_email' => 'Licensed To Email',
        'license_name' => 'Licensed To Name',
        'purchase_order' => 'Purchase Order',
        'reassignable' => 'Reassignable',
        'seats' => 'Seats',
        'notes' => 'Notes',
    ];

    static $users = [
        'employee_num' => 'Employee Number',
        'first_name' => 'First Name',
        'last_name' => 'Last Name',
        'notes' => 'Notes',
        'jobtitle' => 'Job Title',
        'phone_number' => 'Phone Number',
        'manager_first_name' => 'Manager First Name',
        'manager_last_name' => 'Manager Last Name',
        'activated' => 'Activated',
        'address' => 'Address',
        'city' => 'City',
        'state' => 'State',
        'country' => 'Country',
        'zip' => 'Zip',
        'vip' => 'VIP',
        'remote' => 'Remote',
    ];

    static $locations = [
        'name' => 'Name',
        'address' => 'Address',
        'address2' => 'Address 2',
        'city' => 'City',
        'state' => 'State',
        'country' => 'Country',
        'zip' => 'Zip',
        'currency' => 'Currency',
        'ldap_ou' => 'LDAP OU',
        'manager_username' => 'Manager Username',
        'manager' => 'Manager',
        'parent_location' => 'Parent Location',
        'notes' => 'Notes',
    ];

    //array of "real fieldnames" to a list of aliases for that field
    static $aliases = [
        'model_number' =>
            [
                'model',
                'model no',
                'model no.',
                'model number',
                'model num',
                'model num.'
            ],
        'warranty_months' =>
            [
                'Warranty',
                'Warranty Months'
            ],
        'qty' =>
            [
                'QTY',
                'Quantity'
            ],
        'zip' =>
            [
                'Postal Code',
                'Post Code'
            ],
        'min_amt' =>
            [
                'Min Amount',
                'Min QTY'
            ],
        'next_audit_date' =>
            [
                'Next Audit',
            ],
        'address2' =>
            [
                'Address 2',
                'Address2',
            ],
        'ldap_ou' =>
            [
                'LDAP OU',
                'OU',
            ],
        'parent_location' =>
            [
                'Parent',
                'Parent Location',
            ],
        'manager' =>
            [
                'Managed By',
                'Manager Name',
                'Manager Full Name',
            ],
        'manager_username' =>
            [
                'Manager Username',
            ],


    ];

    private function getColumns($type)
    {
        switch ($type) {
            case 'asset':
                $results = self::$general + self::$assets;
                break;
            case 'accessory':
                $results = self::$general + self::$accessories;
                break;
            case 'consumable':
                $results = self::$general + self::$consumables;
                break;
            case 'license':
                $results = self::$general + self::$licenses;
                break;
            case 'user':
                $results = self::$general + self::$users;
                break;
            case 'location':
                $results = self::$general + self::$locations;
                break;
            default:
                $results = self::$general;
        }
        asort($results, SORT_FLAG_CASE | SORT_STRING);
        if ($type == "asset") {
            // add Custom Fields after a horizontal line
            $results['-'] = "———" . trans('admin/custom_fields/general.custom_fields') . "———’";
            foreach (CustomField::orderBy('name')->get() as $field) {
                $results[$field->db_column_name()] = $field->name;
            }
        }
        return $results;
    }

    public function updating($name, $new_import_type)
    {
        if ($name == "activeFile.import_type") {
            \Log::debug("WE ARE CHANGING THE import_type!!!!! TO: " . $new_import_type);
            \Log::debug("so, what's \$this->>field_map at?: " . print_r($this->field_map, true));
            // go through each header, find a matching field to try and map it to.
            foreach ($this->activeFile->header_row as $i => $header) {
                // do we have something mapped already?
                if (array_key_exists($i, $this->field_map)) {
                    // yes, we do. Is it valid for this type of import?
                    // (e.g. the import type might have been changed...?)
                    if (array_key_exists($this->field_map[$i], $this->columnOptions[$new_import_type])) {
                        //yes, this key *is* valid. Continue on to the next field.
                        continue;
                    } else {
                        //no, this key is *INVALID* for this import type. Better set it to null
                        // and we'll hope that the aliases or something else picks it up.
                        $this->field_map[$i] = null; // fingers crossed! But it's not likely, tbh.
                    } // TODO - strictly speaking, this isn't necessary here I don't think.
                }
                // first, check for exact matches
                foreach ($this->columnOptions[$new_import_type] as $value => $text) {
                    if (strcasecmp($text, $header) === 0) { // case-INSENSITIVe on purpose!
                        $this->field_map[$i] = $value;
                        continue 2; //don't bother with the alias check, go to the next header
                    }
                }
                // if you got here, we didn't find a match. Try the aliases
                foreach (self::$aliases as $key => $alias_values) {
                    foreach ($alias_values as $alias_value) {
                        if (strcasecmp($alias_value, $header) === 0) { // aLsO CaSe-INSENSitiVE!
                            // Make *absolutely* sure that this key actually _exists_ in this import type -
                            // you can trigger this by importing accessories with a 'Warranty' column (which don't exist
                            // in "Accessories"!)
                            if (array_key_exists($key, $this->columnOptions[$new_import_type])) {
                                $this->field_map[$i] = $key;
                                continue 3; // bust out of both of these loops; as well as the surrounding one - e.g. move on to the next header
                            }
                        }
                    }
                }
                // and if you got here, we got nothing. Let's recommend 'null'
                $this->field_map[$i] = null; // Booooo :(
            }
        }
    }

    public function boot() { // FIXME - delete or undelete.
        ///////$this->activeFile = null; // I do *not* understand why I have to do this, but, well, whatever.
    }


    public function mount()
    {
        $this->authorize('import');
        $this->progress = -1; // '-1' means 'don't show the progressbar'
        $this->progress_bar_class = 'progress-bar-warning';
        $this->importTypes = [
            'asset' =>      trans('general.assets'),
            'accessory' =>  trans('general.accessories'),
            'consumable' => trans('general.consumables'),
            'component' =>  trans('general.components'),
            'license' =>    trans('general.licenses'),
            'user' =>       trans('general.users'),
            'location' =>    trans('general.locations'),
        ];

        $this->columnOptions[''] = $this->getColumns(''); //blank mode? I don't know what this is supposed to mean
        foreach($this->importTypes AS $type => $name) {
            $this->columnOptions[$type] = $this->getColumns($type);
        }
        if ($this->activeFile) {
            $this->field_map = $this->activeFile->field_map ? array_values($this->activeFile->field_map) : [];
        }
    }

    public function selectFile($id)
    {

        $this->activeFile = Import::find($id);
        $this->field_map = null;
        foreach($this->activeFile->header_row as $element) {
            if(isset($this->activeFile->field_map[$element])) {
                $this->field_map[] = $this->activeFile->field_map[$element];
            } else {
                $this->field_map[] = null; // re-inject the 'nulls' if a file was imported with some 'Do Not Import' settings
            }
        }
        $this->file_id = $id;
        $this->import_errors = null;
        $this->statusText = null;

    }

    public function destroy($id)
    {
        // TODO: why don't we just do File::find($id)? This seems dumb.
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
