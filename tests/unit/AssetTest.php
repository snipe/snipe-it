<?php
class AssetTest extends TestCase {

    public function testConstructor() {
        $f=new Asset();
    }

    public function testBadIP() {
        $f=new Asset();
        $f->name="test 1";
        $f->format="IP";
        $f->element="text";

        $f->save();

        $this->assertFalse($f->check_format("300.2.3.4"));
    }



}
