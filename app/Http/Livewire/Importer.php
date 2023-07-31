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

    // Make these variables public - we set the properties in the constructor so we can localize them (versus the old static arrays)
    public $accessories_fields;
    public $assets_fields;
    public $users_fields;
    public $licenses_fields;
    public $locations_fields;
    public $consumables_fields;
    public $components_fields;
    public $aliases_fields;

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



    private function getColumns($type)
    {
        switch ($type) {
            case 'asset':
                $results = $this->assets_fields;
                break;
            case 'accessory':
                $results = $this->accessories_fields;
                break;
            case 'consumable':
                $results = $this->consumables_fields;
                break;
            case 'component':
                $results = $this->components_fields;
                break;
            case 'license':
                $results = $this->licenses_fields;
                break;
            case 'user':
                $results = $this->users_fields;
                break;
            case 'location':
                $results = $this->locations_fields;
                break;
            default:
                $results = [];
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
                        // and we'll hope that the $aliases_fields or something else picks it up.
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
                // if you got here, we didn't find a match. Try the $aliases_fields
                foreach ($this->aliases_fields as $key => $alias_values) {
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

        /**
         * These are the item-type specific columns
         */
        $this->accessories_fields  = [
            'company' => trans('general.company'),
            'location' => trans('general.location'),
            'quantity' => trans('general.qty'),
            'item_name' => trans('general.item_name_var', ['item' => trans('general.accessory')]),
            'model_number' => trans('general.model_no'),
            'notes' => trans('general.notes'),
            'category' => trans('general.category'),
            'supplier' => trans('general.supplier'),
            'min_amt' => trans('mail.min_QTY'),
            'purchase_cost' => trans('general.purchase_cost'),
            'purchase_date' => trans('general.purchase_date'),
            'manufacturer' => trans('general.manufacturer'),
            'order_number' => trans('general.order_number'),
        ];

        $this->assets_fields = [
            'company' => trans('general.company'),
            'location' => trans('general.location'),
            'item_name' => trans('general.item_name_var', ['item' => trans('general.asset')]),
            'asset_tag' => trans('general.asset_tag'),
            'asset_model' => trans('general.model_name'),
            'byod' => trans('general.byod'),
            'model_number' => trans('general.model_no'),
            'status' => trans('general.status'),
            'warranty_months' => trans('admin/hardware/form.warranty'),
            'category' => trans('general.category'),
            'requestable' => trans('admin/hardware/general.requestable'),
            'serial' => trans('general.serial_number'),
            'supplier' => trans('general.supplier'),
            'purchase_cost' => trans('general.purchase_cost'),
            'purchase_date' => trans('general.purchase_date'),
            'purchase_order' => trans('admin/licenses/form.purchase_order'),
            'asset_notes' => trans('general.item_notes', ['item' => trans('admin/hardware/general.asset')]),
            'model_notes' => trans('general.item_notes', ['item' => trans('admin/hardware/form.model')]),
            'manufacturer' => trans('general.manufacturer'),
            'order_number' => trans('general.order_number'),
            'image' => trans('general.importer.image_filename'),
            /**
             * Checkout fields:
             * Assets can be checked out to other assets, people, or locations, but we currently
             * only support checkout to people and locations in the importer
             **/
            'checkout_class' => trans('general.importer.checkout_type'),
            'first_name' => trans('general.importer.checked_out_to_first_name'),
            'last_name' => trans('general.importer.checked_out_to_last_name'),
            'full_name' => trans('general.importer.checked_out_to_fullname'),
            'email' => trans('general.importer.checked_out_to_email'),
            'username' => trans('general.importer.checked_out_to_username'),
            'checkout_location' => trans('general.importer.checkout_location'),
        ];

        $this->consumables_fields = [
            'company' => trans('general.company'),
            'location' => trans('general.location'),
            'quantity' => trans('general.qty'),
            'item_name' => trans('general.item_name_var', ['item' => trans('general.consumable')]),
            'model_number' => trans('general.model_no'),
            'notes' => trans('general.notes'),
            'min_amt' => trans('mail.min_QTY'),
            'category' => trans('general.category'),
            'purchase_cost' => trans('general.purchase_cost'),
            'purchase_date' => trans('general.purchase_date'),
            'checkout_class' => trans('general.importer.checkout_type'),
            'supplier' => trans('general.supplier'),
            'manufacturer' => trans('general.manufacturer'),
            'order_number' => trans('general.order_number'),
            'item_no' => trans('admin/consumables/general.item_no'),
        ];

        $this->components_fields = [
            'company' => trans('general.company'),
            'location' => trans('general.location'),
            'quantity' => trans('general.qty'),
            'item_name' => trans('general.item_name_var', ['item' => trans('general.component')]),
            'model_number' => trans('general.model_no'),
            'notes' => trans('general.notes'),
            'category' => trans('general.category'),
            'supplier' => trans('general.supplier'),
            'min_amt' => trans('mail.min_QTY'),
            'purchase_cost' => trans('general.purchase_cost'),
            'purchase_date' => trans('general.purchase_date'),
            'manufacturer' => trans('general.manufacturer'),
            'order_number' => trans('general.order_number'),
            'serial' => trans('general.serial_number'),
        ];

        $this->licenses_fields = [
            'company' => trans('general.company'),
            'location' => trans('general.location'),
            'item_name' => trans('general.item_name_var', ['item' => trans('general.license')]),
            'asset_tag' => trans('general.importer.checked_out_to_tag'),
            'expiration_date' => trans('admin/licenses/form.expiration'),
            'full_name' => trans('general.importer.checked_out_to_fullname'),
            'license_email' => trans('admin/licenses/form.to_email'),
            'license_name' => trans('admin/licenses/form.to_name'),
            'purchase_order' => trans('admin/licenses/form.purchase_order'),
            'reassignable' => trans('admin/licenses/form.reassignable'),
            'seats' => trans('admin/licenses/form.seats'),
            'notes' => trans('general.notes'),
            'category' => trans('general.category'),
            'supplier' => trans('general.supplier'),
            'purchase_cost' => trans('general.purchase_cost'),
            'purchase_date' => trans('general.purchase_date'),
            'maintained' => trans('admin/licenses/form.maintained'),
            'checkout_class' => trans('general.importer.checkout_type'),
            'serial' => trans('general.license_serial'),
            'email' => trans('general.importer.checked_out_to_email'),
            'username' => trans('general.importer.checked_out_to_username'),
            'manufacturer' => trans('general.manufacturer'),
        ];

        $this->users_fields  = [
            'id' => trans('general.id'),
            'company' => trans('general.company'),
            'location' => trans('general.location'),
            'department' => trans('general.department'),
            'first_name' => trans('general.first_name'),
            'last_name' => trans('general.last_name'),
            'notes' => trans('general.notes'),
            'username' => trans('admin/users/table.username'),
            'jobtitle' => trans('admin/users/table.title'),
            'phone_number' => trans('admin/users/table.phone'),
            'manager_first_name' => trans('general.importer.manager_first_name'),
            'manager_last_name' => trans('general.importer.manager_last_name'),
            'activated' => trans('general.activated'),
            'address' => trans('general.address'),
            'city' => trans('general.city'),
            'state' => trans('general.state'),
            'country' => trans('general.country'),
            'zip' => trans('general.zip'),
            'vip' => trans('general.importer.vip'),
            'remote' => trans('admin/users/general.remote'),
            'email' => trans('admin/users/table.email'),
            'website' => trans('general.website'),
            'avatar' => trans('general.image'),
            'gravatar' => trans('general.importer.gravatar'),
            'start_date'    => trans('general.start_date'),
            'end_date'   => trans('general.end_date'),
            'employee_num'   => trans('general.employee_number'),
        ];

        $this->locations_fields  = [
            'name' => trans('general.item_name_var', ['item' => trans('general.location')]),
            'address' => trans('general.address'),
            'address2' => trans('general.importer.address2'),
            'city' => trans('general.city'),
            'state' => trans('general.state'),
            'country' => trans('general.country'),
            'zip' => trans('general.zip'),
            'currency' => trans('general.importer.currency'),
            'ldap_ou' => trans('admin/locations/table.ldap_ou'),
            'manager_username' => trans('general.importer.manager_username'),
            'manager' => trans('general.importer.manager_full_name'),
            'parent_location' => trans('admin/locations/table.parent'),
        ];

        // "real fieldnames" to a list of aliases for that field
        $this->aliases_fields = [
            'item_name' =>
                [
                    'item name',
                    'asset name',
                    'accessory name',
                    'user name',
                    'consumable name',
                    'component name',
                    'name',
                ],
            'item_no' => [
                'item number',
                'item no.',
                'item #',
            ],
            'asset_model' =>
                [
                    'model name',
                    'model',
                ],
            'gravatar' =>
                [
                    'gravatar',
                ],
            'currency' =>
                [
                    '$',
                ],
            'jobtitle' =>
                [
                    'job title for user',
                    'job title',
                ],
            'username' =>
                [
                    'user name',
                    'username',
                    trans('general.importer.checked_out_to_username'),
                ],
            'first_name' =>
                [
                    'first name',
                    trans('general.importer.checked_out_to_first_name'),
                ],
            'last_name' =>
                [
                    'last name',
                    'lastname',
                    trans('general.importer.checked_out_to_last_name'),
                ],
            'email' =>
                [
                    'email',
                    'e-mail',
                    trans('general.importer.checked_out_to_email'),
                ],
            'phone_number' =>
                [
                    'phone',
                    'phone number',
                    'phone num',
                    'telephone number',
                    'telephone',
                    'tel.',
                ],
            'serial' =>
                [
                    'serial number',
                    'serial no.',
                    'serial no',
                    'product key',
                    'key',
                ],
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
                    'Post Code',
                    'Zip Code'
                ],
            'min_amt' =>
                [
                    'Min Amount',
                    'Minimum Amount',
                    'Min Quantity',
                    'Minimum Quantity',
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
