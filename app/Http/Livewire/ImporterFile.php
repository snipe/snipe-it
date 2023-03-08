<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\CustomField;

use Log;

class ImporterFile extends Component
{
    public $activeFile; //this gets automatically populated on instantiation
    public $importTypes;
    public $columnOptions;
    public $statusType;
    public $statusText;
    public $update;
    public $send_welcome;
    public $run_backup;
    public $field_map; // we need a separate variable for the field-mapping, because the keys in the normal array are too complicated for Livewire to understand

    protected $rules = [
        'activeFile.import_type' => 'string',
        'activeFile.field_map' => 'array',
        'activeFile.header_row' => 'array',
        'field_map' => 'array'
    ];


    public function generate_field_map()
    {
        $tmp = array_combine($this->activeFile->header_row, $this->field_map);
        return json_encode(array_filter($tmp));
    }

    static $general = [
        'category' => 'Category',
        'company' => 'Company',
        'email' => 'Email',
        'item_name' => 'Item Name',
        'location' => 'Location',
        'maintained' => 'Maintained',
        'manufacturer' => 'Manufacturer',
        'notes' => 'Notes',
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
    ];

    static $assets = [
        'asset_tag' => 'Asset Tag',
        'asset_model' => 'Model Name',
        'byod' => 'BYOD',
        'checkout_class' => 'Checkout Type',
        'checkout_location' => 'Checkout Location',
        'image' => 'Image Filename',
        'model_number' => 'Model Number',
        'full_name' => 'Full Name',
        'status' => 'Status',
        'warranty_months' => 'Warranty Months',
    ];

    static $consumables = [
        'item_no' => "Item Number",
        'model_number' => "Model Number",
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
    ];

    static $users = [
        'employee_num' => 'Employee Number',
        'first_name' => 'First Name',
        'jobtitle' => 'Job Title',
        'last_name' => 'Last Name',
        'phone_number' => 'Phone Number',
        'manager_first_name' => 'Manager First Name',
        'manager_last_name' => 'Manager Last Name',
        'activated' => 'Activated',
        'address' => 'Address',
        'city' => 'City',
        'state' => 'State',
        'country' => 'Country',
        'vip' => 'VIP'
    ];

    //array of "real fieldnames" to a list of aliases for that field
    static $aliases = [
        'model_number' => ['model', 'model no','model no.','model number', 'model num', 'model num.'],
        'warranty_months' => ['Warranty', 'Warranty Months']
    ];

    private function getColumns($type)
    {
        switch($type) {
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
            default:
                $results = self::$general;
        }
        asort($results, SORT_FLAG_CASE|SORT_STRING);
        if($type == "asset") {
            // add Custom Fields after a horizontal line
            $results['-'] = "———".trans('admin/custom_fields/general.custom_fields')."———’";
            foreach(CustomField::orderBy('name')->get() AS $field) {
                $results[$field->db_column_name()] = $field->name;
            }
        }
        return $results;
    }

    public function updating($name, $new_import_type)
    {
        if ($name == "activeFile.import_type") {
            \Log::info("WE ARE CHANGING THE import_type!!!!! TO: ".$new_import_type);
            // go through each header, find a matching field to try and map it to.
            foreach($this->activeFile->header_row as $i => $header) {
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
                foreach ($this->columnOptions[$new_import_type] AS $value => $text) {
                    if (strcasecmp($text, $header) === 0) { // case-INSENSITIVe on purpose!
                        $this->field_map[$i] = $value;
                        continue 2; //don't bother with the alias check, go to the next header
                    }
                }
                // if you got here, we didn't find a match. Try the aliases
                foreach(self::$aliases as $key => $alias_values) {
                    foreach($alias_values as $alias_value) {
                        if (strcasecmp($alias_value,$header) === 0) { // aLsO CaSe-INSENSitiVE!
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

    public function mount()
    {
        $this->importTypes = [
            'asset' =>      'Assets',      // TODO - translate!
            'accessory' =>  'Accessories',
            'consumable' => 'Consumables',
            'component' =>  'Components',
            'license' =>    'Licenses',
            'user' =>       'Users'
        ];

        $this->columnOptions[''] = $this->getColumns(''); //blank mode? I don't know what this is supposed to mean
        foreach($this->importTypes AS $type => $name) {
            $this->columnOptions[$type] = $this->getColumns($type);
        }
        $this->field_map = $this->activeFile->field_map ? array_values($this->activeFile->field_map): [];
    }

    public function postSave()
    {
        if (!$this->activeFile->import_type) {
            Log::error("didn't find an import type :(");
            $this->statusType ='error';
            $this->statusText = "An import type is required... "; // TODO - translate me!
            return false;
        }
        $this->statusType = 'pending';
        $this->statusText = "Processing...";

    }

    public function render()
    {
        return view('livewire.importer-file');
    }
}
