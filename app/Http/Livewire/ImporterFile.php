<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\CustomField;

use Log;

class ImporterFile extends Component
{
    public $activeFile; //this gets automatically populated on instantiation
    public $customFields;
    public $importTypes;
    public $columnOptions;
    public $increment; // just used to force refreshes - and doesn't really work anyways
    public $statusType;
    public $statusText;
    public $update;
    public $send_welcome;
    public $run_backup;
    public $field_map; // we need a separate variable for the field-mapping, because the keys in the normal array are too complicated for Livewire to understand

    protected $rules = [
        'activeFile.import_type' => 'string',
        'activeFile.field_map' => 'array', //this doesn't work because I think we would have to list all the keys?
        // 'activeFile.field_map.*' => 'string', // FIXME - can we do this?
        'activeFile.header_row' => 'array',
        'field_map' => 'array'
    ];

//    protected $listeners = ['refreshComponent' => '$refresh'];

    public function getDinglefartsProperty() // FIXME (and probably not even used at this point :(((
    {
        $tmp = array_combine($this->activeFile->header_row, $this->field_map);
        \Log::error("tmp is: ".print_r($tmp,true));
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

    private function getColumns($type) //maybe static?
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
//        Log::error("import types: ".print_r($this->importTypes,true));

        $columnOptions = []; // FIXME - should this be $this->>columnOptions?
        $this->columnOptions[''] = $this->getColumns(''); //blank mode? I don't know what this is supposed to mean
        foreach($this->importTypes AS $type => $name) {
            $this->columnOptions[$type] = $this->getColumns($type);
        }
        $this->increment = 0;
        $this->field_map = array_values($this->activeFile->field_map);
    }

    public function postSave()
    {
        if (!$this->activeFile->import_type) {
            Log::info("didn't find an import type :(");
            $this->statusType ='error';
            $this->statusText = "An import type is required... "; // TODO - translate me!
            return false;
        }
        $this->statusType = 'pending';
        $this->statusText = "Processing...";

                axios.post('{{ route('api.imports.importFile', $activeFile->id) }}', {
        'import-update': !!@this.update,
                    'send-welcome': !!@this.send_welcome,
                    'import-type': @this.activeFile.import_type,
                    'run-backup': !!@this.run_backup,
                    'column-mappings': mappings // FIXME - terrible name
                }).then( (body) => {
        Log::warn("success!!!")
                    // Success
        $this->statusType = "success";
        $this->statusText = "Success... Redirecting.";
                    // FIXME - can we 'flash' an update here?
        window.location.href = body.data.messages.redirect_url; // definite fixme here!
                }, (body) => {
        // Failure
        console.warn("failure!!!!")
                    if(body.response.data.status == 'import-errors') {
                        //window.eventHub.$emit('importErrors', body.messages);
                        console.warn("import error")
                        console.dir(body)
                        @this.set('statusType','error');
                        @this.emit('importError', body.response.data.messages)
                        //@this.set('statusText', "Error: "+body.response.data.messages.join("<br>"));
                    } else {
                        console.warn("not import-errors, just regular errors")
                        console.dir(body)
                        @this.set('statusType','error');
                        @this.emit('importError',body.response.data.messages ? body.response.data.messages :  {'import-type': ['Unknown error']})
                        @this.set('statusText',body.response.data.messages ? body.response.data.messages : 'Unknown error');
                    }
                    // @this.emit('hideDetails');
                });
            }
$(function () {
    $('#import').on('click',function () {
        console.warn("okay, click handler firing!!!")
                  postSave()
              })
              console.warn("JS click handler loaded!")
          })
window.setTimeout(function() {
    var what = @this.dinglefarts
              console.warn("What is this: ",what)
          },1000)

        $class = title_case($this->option('item-type'));
        $classString = "App\\Importer\\{$class}Importer";
        $importer = new $classString($filename);
        $importer->setCallbacks([$this, 'log'], [$this, 'progress'], [$this, 'errorCallback'])
            ->setUserId($this->option('user_id'))
            ->setUpdating($this->option('update'))
            ->setShouldNotify($this->option('send-welcome'))
            ->setUsernameFormat($this->option('username_format'));

        // This $logFile/useFiles() bit is currently broken, so commenting it out for now
        // $logFile = $this->option('logfile');
        // \Log::useFiles($logFile);
        $this->comment('======= Importing Items from '.$filename.' =========');
        $importer->import();

        $this->bar = null;

        if (! empty($this->errors)) {
            $this->comment('The following Errors were encountered.');
            foreach ($this->errors as $asset => $error) {
                $this->comment('Error: Item: '.$asset.' failed validation: '.json_encode($error));
            }
        } else {
            $this->comment('All Items imported successfully!');
        }
        $this->comment('');

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
