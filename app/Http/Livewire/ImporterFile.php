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
        return json_encode($tmp);
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
    ];

    private function getColumns($type)
    {
        $customFields = [];
        foreach($this->customFields AS $field) {
            $customFields[$field->id] = $field->name;
        }

        switch($type) {
            case 'asset':
                $results = self::$general + self::$assets + $customFields;
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
        asort($results); // FIXME - this isn't sorting right yet.
        return $results;
    }

    public function mount()
    {
        $this->customFields = CustomField::all();

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
        $this->increment = 0;
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
