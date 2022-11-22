<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\CustomField;

use Log;

global $general, $accessories, $assets, $consumables, $licenses, $users;

$general = [
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

$accessories = [
    'model_number' => 'Model Number',
];

$assets = [
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

$consumables = [
    'item_no' => "Item Number",
    'model_number' => "Model Number",
    'min_amt' => "Minimum Quantity",
];

$licenses = [
    'asset_tag' => 'Assigned To Asset',
    'expiration_date' => 'Expiration Date',
    'full_name' => 'Full Name',
    'license_email' => 'Licensed To Email',
    'license_name' => 'Licensed To Name',
    'purchase_order' => 'Purchase Order',
    'reassignable' => 'Reassignable',
    'seats' => 'Seats',
];

$users = [
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

class ImporterFile extends Component
{
    public $activeFile; //this gets automatically populated on instantiation
    public $customFields;
    public $importTypes;
    public $columnOptions;
    public $increment; // just used to force refreshes
    public $statusType;
    public $statusText;
    public $update;
    public $send_welcome;
    public $run_backup;

    protected $rules = [
        'activeFile.import_type' => 'string',
        'activeFile.field_map' => 'array', //this doesn't work because I think we would have to list all the keys?
    ];

//    protected $listeners = ['refreshComponent' => '$refresh'];

    private function getColumns($type)
    {
        global $general, $accessories, $assets, $consumables, $licenses, $users; // TODO - why is this global?

        $customFields = [];
        foreach($this->customFields AS $field) {
            $customFields[$field->id] = $field->name;
        }

        switch($type) {
            case 'asset':
                $results = $general + $assets + $customFields;
                break;
            case 'accessory':
                $results = $general + $accessories;
                break;
            case 'consumable':
                $results = $general + $consumables;
                break;
            case 'license':
                $results = $general + $licenses;
                break;
            case 'user':
                $results = $general + $users;
                break;
            default:
                $results = $general;
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
//        Log::error("import types: ".print_r($this->importTypes,true));

        $columnOptions = []; // FIXME - should this be $this->>columnOptions?
        $this->columnOptions[''] = $this->getColumns(''); //blank mode? I don't know what this is supposed to mean
        foreach($this->importTypes AS $type => $name) {
            $this->columnOptions[$type] = $this->getColumns($type);
        }
        $this->increment = 0;
    }

    public function postSave()
    {
        Log::error("Saving import!");
        if (!$this->activeFile->import_type) {
            $this->statusType='error';
            $this->statusText= "An import type is required... "; // TODO - translate me!
            return false;
        }
        $this->statusType = 'pending';
        $this->statusText = "Processing...";
    }

    public function changeTypes() // UNUSED?
    {
        Log::error("type changed!");
    }

    public function render()
    {
        //\Log::error("Rendering! And here's the value for mappings: ".print_r($this->mappings,true));
        return view('livewire.importer-file');
    }
}
