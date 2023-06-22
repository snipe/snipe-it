<?php

namespace Tests\Support;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\TestResponse;
use RuntimeException;

trait InteractsWithResponses
{
    protected function assertResponseContainsInRows(TestResponse $response, Model $model, string $property = 'name')
    {
        $this->guardAgainstNullProperty($model, $property);

        $this->assertTrue(collect($response['rows'])->pluck($property)->contains($model->{$property}));
    }

    protected function assertResponseDoesNotContainInRows(TestResponse $response, Model $model, string $property = 'name')
    {
        $this->guardAgainstNullProperty($model, $property);

        $this->assertFalse(collect($response['rows'])->pluck($property)->contains($model->{$property}));
    }

    protected function assertResponseContainsInResults(TestResponse $response, Model $model, string $property = 'id')
    {
        $this->guardAgainstNullProperty($model, $property);

        $this->assertTrue(collect($response->json('results'))->pluck('id')->contains($model->{$property}));
    }

    protected function assertResponseDoesNotContainInResults(TestResponse $response, Model $model, string $property = 'id')
    {
        $this->guardAgainstNullProperty($model, $property);

        $this->assertFalse(collect($response->json('results'))->pluck('id')->contains($model->{$property}));
    }

    private function guardAgainstNullProperty(Model $model, string $property): void
    {
        if (is_null($model->{$property})) {
            throw new RuntimeException(
                "The property ({$property}) is null on the model which isn't helpful for comparison."
            );
        }
    }
}
