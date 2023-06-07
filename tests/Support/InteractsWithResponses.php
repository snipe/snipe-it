<?php

namespace Tests\Support;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\TestResponse;

trait InteractsWithResponses
{
    private function assertResponseContainsInRows(TestResponse $response, Model $model, string $field = 'name')
    {
        $this->assertTrue(collect($response['rows'])->pluck($field)->contains($model->{$field}));
    }

    private function assertResponseDoesNotContainInRows(TestResponse $response, Model $model, string $field = 'name')
    {
        $this->assertFalse(collect($response['rows'])->pluck($field)->contains($model->{$field}));
    }
}
