<?php

namespace Tests\Unit;

use App\Models\CustomFieldset;
use App\Models\Traits\HasCustomFields;
use Illuminate\Support\Collection;
use Tests\TestCase;

class Thingee {
    use HasCustomFields;

    function getFieldset(): ?CustomFieldset
    {
        return new CustomFieldset();
    }

    static function getFieldsetUsers(int $fieldset_id): Collection
    {
        // TODO: Implement getFieldsetUsers() method.
        return collect();
    }

    function save(array $options = [])
    {
        parent::save(); //does this call the trait?
        return true;
    }
}

class HasCustomFieldsTraitTest extends TestCase
{
    public function testExample()
    {
        $thing = new Thingee();
        $this->expectException("You must customFill() custom fields out before saving!");
        $thing->save(); //should THROW
    }
}
