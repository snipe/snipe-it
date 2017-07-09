<?php
use App\Importer\AccessoryImporter;
use App\Importer\AssetImporter;
use App\Models\Accessory;
use App\Models\AssetModel;
use App\Models\Category;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Hash;

class ImporterTest extends BaseTest
{
    /**
    * @var \UnitTester
    */
    protected $tester;

    public function testDefaultImportAsset()
    {
        $csv = <<<'EOT'
Name,Email,Username,item Name,Category,Model name,Manufacturer,Model Number,Serial number,Asset Tag,Location,Notes,Purchase Date,Purchase Cost,Company,Status,Warranty,Supplier
Bonnie Nelson,bnelson0@cdbaby.com,bnelson0,eget nunc donec quis,quam,massa id,Linkbridge,6377018600094472,27aa8378-b0f4-4289-84a4-405da95c6147,970882174-8,Daping,"Curabitur in libero ut massa volutpat convallis. Morbi odio odio, elementum eu, interdum eu, tincidunt in, leo. Maecenas pulvinar lobortis est.",2016-04-05,133289.59,Alpha,Undeployable,14,Blogspan
EOT;
        $this->import(new AssetImporter($csv));
        // Did we create a user?

        $this->tester->seeRecord('users', [
            'first_name' => 'Bonnie',
            'last_name' => 'Nelson',
            'email' => 'bnelson0@cdbaby.com',
        ]);
        $this->tester->seeRecord('categories', [
            'name' => 'quam'
        ]);

        $this->tester->seeRecord('models', [
            'name' => 'massa id',
            'model_number' => 6377018600094472
        ]);

        $this->tester->seeRecord('manufacturers', [
            'name' => 'Linkbridge'
        ]);

        $this->tester->seeRecord('locations', [
            'name' => 'Daping'
        ]);

        $this->tester->seeRecord('companies', [
            'name' => 'Alpha'
        ]);

        $this->tester->seeRecord('status_labels', [
            'name' => 'Undeployable'
        ]);

        $this->tester->seeRecord('suppliers', [
            'name' => 'Blogspan'
        ]);
        $this->tester->seeRecord('assets', [
            'name' => 'eget nunc donec quis',
            'serial' => '27aa8378-b0f4-4289-84a4-405da95c6147',
            'asset_tag' => '970882174-8',
            'notes' => "Curabitur in libero ut massa volutpat convallis. Morbi odio odio, elementum eu, interdum eu, tincidunt in, leo. Maecenas pulvinar lobortis est.",
            'purchase_date' => '2016-04-05 00:00:01',
            'purchase_cost' => 133289.59,
            'warranty_months' => 14
            ]);
    }

    public function testUpdateAsset()
    {
        $csv = <<<'EOT'
Name,Email,Username,item Name,Category,Model name,Manufacturer,Model Number,Serial number,Asset Tag,Location,Notes,Purchase Date,Purchase Cost,Company,Status,Warranty,Supplier
Bonnie Nelson,bnelson0@cdbaby.com,bnelson0,eget nunc donec quis,quam,massa id,Linkbridge,6377018600094472,27aa8378-b0f4-4289-84a4-405da95c6147,970882174-8,Daping,"Curabitur in libero ut massa volutpat convallis. Morbi odio odio, elementum eu, interdum eu, tincidunt in, leo. Maecenas pulvinar lobortis est.",2016-04-05,133289.59,Alpha,Undeployable,14,Blogspan
EOT;
        $this->import(new AssetImporter($csv));
        $updatedCSV = <<<'EOT'
item Name,Category,Model name,Manufacturer,Model Number,Serial number,Asset Tag,Location,Notes,Purchase Date,Purchase Cost,Company,Status,Warranty,Supplier
A new name,some other category,Another Model,Linkbridge 32,356,67433477,970882174-8,New Location,I have no notes,2018-04-05,25.59,Another Company,Ready To Go,18,Not Creative
EOT;
        $importer = new AssetImporter($updatedCSV);
        $importer->setUserId(1)
             ->setUpdating(true)
             ->setUsernameFormat('firstname.lastname')
             ->import();

       $this->tester->seeRecord('categories', [
            'name' => 'some other category'
        ]);

        $this->tester->seeRecord('models', [
            'name' => 'Another Model',
            'model_number' => 356
        ]);

        $this->tester->seeRecord('manufacturers', [
            'name' => 'Linkbridge 32'
        ]);

        $this->tester->seeRecord('locations', [
            'name' => 'New Location'
        ]);

        $this->tester->seeRecord('companies', [
            'name' => 'Another Company'
        ]);

        $this->tester->seeRecord('status_labels', [
            'name' => 'Ready To Go'
        ]);

        $this->tester->seeRecord('suppliers', [
            'name' => 'Not Creative'
        ]);

        $this->tester->seeRecord('assets', [
            'name' => 'A new name',
            'serial' => '67433477',
            'asset_tag' => '970882174-8',
            'notes' => "I have no notes",
            'purchase_date' => '2018-04-05 00:00:01',
            'purchase_cost' => 25.59,
            'warranty_months' => 18
            ]);
    }

    public function testCustomMappingImport()
    {
        $csv = <<<'EOT'
Name,Email,Username,object name,Cat,Model name,Manufacturer,Model Number,Serial number,Asset,Loc,Some Notes,Purchase Date,Purchase Cost,comp,Status,Warranty,Supplier
Bonnie Nelson,bnelson0@cdbaby.com,bnelson0,eget nunc donec quis,quam,massa id,Linkbridge,6377018600094472,27aa8378-b0f4-4289-84a4-405da95c6147,970882174-8,Daping,"Curabitur in libero ut massa volutpat convallis. Morbi odio odio, elementum eu, interdum eu, tincidunt in, leo. Maecenas pulvinar lobortis est.",2016-04-05,133289.59,Alpha,Undeployable,14,Blogspan
EOT;

    $customFieldMap = [
        'asset_tag' => 'Asset',
        'category' => 'Cat',
        'company' => 'comp',
        'item_name' => 'object name',
        'expiration_date' => 'expiration date',
        'location' => 'loc',
        'notes' => 'Some Notes',
        'asset_model' => "model name",
    ];

        $this->import(new AssetImporter($csv), $customFieldMap);
        // Did we create a user?

        $this->tester->seeRecord('users', [
            'first_name' => 'Bonnie',
            'last_name' => 'Nelson',
            'email' => 'bnelson0@cdbaby.com',
        ]);

        $this->tester->seeRecord('categories', [
            'name' => 'quam'
        ]);

        $this->tester->seeRecord('models', [
            'name' => 'massa id',
            'model_number' => 6377018600094472
        ]);

        $this->tester->seeRecord('manufacturers', [
            'name' => 'Linkbridge'
        ]);

        $this->tester->seeRecord('locations', [
            'name' => 'Daping'
        ]);

        $this->tester->seeRecord('companies', [
            'name' => 'Alpha'
        ]);

        $this->tester->seeRecord('status_labels', [
            'name' => 'Undeployable'
        ]);

        $this->tester->seeRecord('suppliers', [
            'name' => 'Blogspan'
        ]);
        $this->tester->seeRecord('assets', [
            'name' => 'eget nunc donec quis',
            'serial' => '27aa8378-b0f4-4289-84a4-405da95c6147',
            'asset_tag' => '970882174-8',
            'notes' => "Curabitur in libero ut massa volutpat convallis. Morbi odio odio, elementum eu, interdum eu, tincidunt in, leo. Maecenas pulvinar lobortis est.",
            'purchase_date' => '2016-04-05 00:00:01',
            'purchase_cost' => 133289.59,
            'warranty_months' => 14
            ]);
    }

    public function testDefaultAccessoryImport()
    {
        $csv = <<<'EOT'
Item Name,Purchase Date,Purchase Cost,Location,Company,Order Number,Category,Requestable,Quantity
Walter Carter,09/01/2006,,metus. Vivamus,Macromedia,J935H60W,Customers,False,278
EOT;
        $this->import(new AccessoryImporter($csv));
        $this->tester->seeRecord('accessories', [
            'name' => 'Walter Carter',
            'purchase_date' => '2006-09-01 00:00:01',
            'order_number' => 'J935H60W',
            'requestable' => 0,
            'qty' => 278
        ]);

        $this->tester->seeRecord('locations', [
            'name' => 'metus. Vivamus'
        ]);

        $this->tester->seeRecord('companies', [
            'name' => 'Macromedia'
        ]);

        $this->tester->seeRecord('categories', [
            'name' => 'Customers'
        ]);

    }

    public function testDefaultAccessoryUpdate()
    {
        $csv = <<<'EOT'
Item Name,Purchase Date,Purchase Cost,Location,Company,Order Number,Category,Requestable,Quantity
Walter Carter,09/01/2006,,metus. Vivamus,Macromedia,J935H60W,Customers,False,278
EOT;
        $this->import(new AccessoryImporter($csv));
        $this->tester->seeNumRecords(1, 'accessories');


        $updatedCSV = <<<'EOT'
Item Name,Purchase Date,Purchase Cost,Location,Company,Order Number,Category,Requestable,Quantity
Walter Carter,09/01/2015,350,metus. Vivamus,Macromedia,35GGH,Customers,True,12
EOT;
        $importer = new AccessoryImporter($updatedCSV);
        $importer->setUserId(1)
             ->setUpdating(true)
             ->import();
        // At this point we should still only have one record.
        $this->tester->seeNumRecords(1, 'accessories');
        // But instead these.
        $this->tester->seeRecord('accessories', [
            'name' => 'Walter Carter',
            'purchase_date' => '2015-09-01 00:00:01',
            'order_number' => '35GGH',
            'requestable' => 1,
            'qty' => 12
        ]);
    }

    private function import($importer, $mappings = null)
    {

        if($mappings) {
            $importer->setFieldMappings($mappings);
        }
        $importer->setUserId(1)
             ->setUpdating(false)
             ->setUsernameFormat('firstname.lastname')
             ->import();
    }
}
