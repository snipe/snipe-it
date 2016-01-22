<?php 
//require '/var/www/html/app/models/CustomField.php';
//use Illuminate\Foundation\Testing\

class CustomFieldTest extends TestCase //PHPUnit_Framework_TestCase
{
  public function testConstructor() {
    $f=new CustomField();
  }
  
  public function testBadIP() {
    $f=new CustomField();
    $f->name="test 1";
    $f->format="IP";
    $f->element="text";
    
    $f->save();
    
    $this->assertFalse($f->check_format("300.2.3.4"));
  }
  
  public function testGoodIP() {
    $f=new CustomField();
    $f->name="test 1";
    $f->format="IP";
    $f->element="text";
    
    $f->save();
    
    $this->assertTrue($f->check_format("1.2.3.4"));
  }
  
  public function testFormat() {
    $f=new CustomField();
    $f->name="test 1";
    $f->format="IP";
    $f->element="text";
    
    $f->save();
    
    //print_r($f->attributes);
    //print($f);
    //print("Uhm, format is: ".$f->attributes['format']);
    //print("Lemme try this: ".$f->getAttribute('format'));
    //print("Moar: ".print_r($f->getAttributes(),true));
    $this->assertEquals($f->getAttributes()['format'],CustomField::$PredefinedFormats['IP']); //this seems undocumented...
    $this->assertEquals($f->format,"IP");
  }
  
  public function testDbName() {
    $f=new CustomField();
    $f->name="An Example Name";
    $this->assertEquals($f->db_column_name(),"an_example_name");
  }
  
  public function testValidation() {
    $f=new CustomField();
    
    $f->name='Id';
    $f->format='IP';
    $f->element="text";
    /*$this->assertDoesntThrow(function () {
      $f->save();
    });*/
    $this->assertFalse(CustomField::saving($f)); //horrible hacky workaround to even problems
                                        //for Laravel testing. Blech.
    
    $g=new CustomField();
    $g->name='totally_unique_name';
    $g->format='IP';
    $g->element="text";
    //$this->assertTrue($g->validate($g->toArray()));
    $this->assertTrue(CustomField::saving($g));
    /*$this->assertThrows(function () {
      $f->save();
    });*/
  }
}
