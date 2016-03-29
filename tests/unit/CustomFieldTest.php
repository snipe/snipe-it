<?php
use App\Models\CustomField;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CustomFieldTest extends \Codeception\TestCase\Test
{
  protected $tester;
  use DatabaseMigrations;

  public function testConstructor() {
    $customfield = new CustomField();
  }

  public function testFormat() {
    $customfield = factory(CustomField::class, 'customfield-ip')->make();
    $values = [
      'name' => $customfield->name,
      'format' => $customfield->format,
      'element' => $customfield->element,
    ];

    $this->assertEquals($customfield->getAttributes()['format'],CustomField::$PredefinedFormats['IP']); //this seems undocumented...
    $this->assertEquals($customfield->format,"IP");
  }

  public function testDbName() {
    $customfield=new CustomField();
    $customfield->name="An Example Name";
    $this->assertEquals($customfield->db_column_name(),"_snipeit_an_example_name");
  }

  // public function testValidation() {
  //   // $f=new CustomField();
  //   // $f->name='Id';
  //   // $f->format='IP';
  //   // $f->element="text";
  //   // /*$this->assertDoesntThrow(function () {
  //   //   $f->save();
  //   // });*/
  //   // $this->assertNull(CustomField::saving($f)); //horrible hacky workaround to even problems
  //   //                                     //for Laravel testing. Blech.
  //
  //   $g=new CustomField();
  //   $g->name='totally_unique_name';
  //   $g->format='IP';
  //   $g->element="text";
  //   //$this->assertTrue($g->validate($g->toArray()));
  //   $this->assertTrue(CustomField::saving($g));
  //   /*$this->assertThrows(function () {
  //     $f->save();
  //   });*/
  // }
}
