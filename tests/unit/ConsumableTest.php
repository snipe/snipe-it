<?php
use App\Models\Consumable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ConsumableTest extends BaseTest
{
    /**
     * @var \UnitTester
     */
    protected $tester;


     public function testFailsEmptyValidation()
     {
        // An Consumable requires a name, a qty, and a category_id.
         $a = Consumable::create();
         $this->assertFalse($a->isValid());

         $fields = [
             'name' => 'name',
             'qty' => 'qty',
             'category_id' => 'category id'
         ];
         $errors = $a->getErrors();
         foreach ($fields as $field => $fieldTitle) {
             $this->assertEquals($errors->get($field)[0], "The ${fieldTitle} field is required.");
         }
     }

     public function testAConsumableHasRelationships()
     {
         $consumable = factory(Consumable::class)->states('cardstock')->create([
             'category_id' => $this->createValidCategory('consumable-paper-category')->id,
             'manufacturer_id' => $this->createValidManufacturer('apple')->id,
             'company_id' => $this->createValidCompany()->id,
             'location_id' => $this->createValidLocation()->id,
             'user_id' => $this->signIn()->id
         ]);
         
         $this->assertInstanceOf(App\Models\User::class, $consumable->admin);
         $this->assertInstanceOf(App\Models\Company::class, $consumable->company);
         $this->assertInstanceOf(App\Models\Manufacturer::class, $consumable->manufacturer);
         $this->assertInstanceOf(App\Models\Location::class, $consumable->location);
         $this->assertInstanceOf(App\Models\Category::class, $consumable->category);
     }

}
