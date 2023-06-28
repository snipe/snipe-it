<?php

namespace Tests\Support;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\TestResponse;
use PHPUnit\Framework\Assert;
use RuntimeException;

trait CustomTestMacros
{
    protected function registerCustomMacros()
    {
        $guardAgainstNullProperty = function (Model $model, string $property) {
            if (is_null($model->{$property})) {
                throw new RuntimeException(
                    "The property ({$property}) either does not exist or is null on the model which isn't helpful for comparison."
                );
            }
        };

        TestResponse::macro(
            'assertResponseContainsInRows',
            function (Model $model, string $property = 'name') use ($guardAgainstNullProperty) {
                $guardAgainstNullProperty($model, $property);

                Assert::assertTrue(collect($this['rows'])->pluck($property)->contains($model->{$property}));

                return $this;
            }
        );

        TestResponse::macro(
            'assertResponseDoesNotContainInRows',
            function (Model $model, string $property = 'name') use ($guardAgainstNullProperty) {
                $guardAgainstNullProperty($model, $property);

                Assert::assertFalse(collect($this['rows'])->pluck($property)->contains($model->{$property}));

                return $this;
            }
        );

        TestResponse::macro(
            'assertResponseContainsInResults',
            function (Model $model, string $property = 'id') use ($guardAgainstNullProperty) {
                $guardAgainstNullProperty($model, $property);

                Assert::assertTrue(collect($this->json('results'))->pluck('id')->contains($model->{$property}));

                return $this;
            }
        );

        TestResponse::macro(
            'assertResponseDoesNotContainInResults',
            function (Model $model, string $property = 'id') use ($guardAgainstNullProperty) {
                $guardAgainstNullProperty($model, $property);

                Assert::assertFalse(collect($this->json('results'))->pluck('id')->contains($model->{$property}));

                return $this;
            }
        );
    }
}
