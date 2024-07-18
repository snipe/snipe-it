<?php

namespace App\Http\Serializers;

use League\Fractal\Pagination\CursorInterface;
use League\Fractal\Serializer\SerializerAbstract;
use League\Fractal\Resource\ResourceInterface;
use League\Fractal\Pagination\PaginatorInterface;
use League\Fractal\Serializer\ArraySerializer;
use League\Fractal\Serializer\JsonApiSerializer;

class BootstrapTablesSerializer extends JsonApiSerializer
{
    public function collection($resourceKey, array $data): array
    {
        \Log::error('resource key: '.$resourceKey);
        return [
                'total' => count($data),
                'rows' => $data
        ];
    }

    public function item($resourceKey, array $data): array
    {
        if ($resourceKey) {
            return [$resourceKey => $data];
        }
        return $data;
    }

}