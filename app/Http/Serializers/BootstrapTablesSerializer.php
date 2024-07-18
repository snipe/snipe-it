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
        return [$resourceKey => $data];
    }

    public function item($resourceKey, array $data): array
    {
        if ($resourceKey) {
            return [$resourceKey => $data];
        }
        return $data;
    }

    public function null(): ?array
    {
        return [];
    }

    public function includedData(ResourceInterface $resource, array $data): array
    {
        return $data;
    }

    public function meta(array $meta): array
    {
        return ['meta' => $meta];
    }

    public function paginator(PaginatorInterface $paginator): array
    {
        $currentPage = (int) $paginator->getCurrentPage();
        $lastPage = (int) $paginator->getLastPage();

        $pagination = [
            'total' => (int) $paginator->getTotal(),
            'count' => (int) $paginator->getCount(),
            'per_page' => (int) $paginator->getPerPage(),
            'current_page' => $currentPage,
            'total_pages' => $lastPage,
        ];

        $pagination['links'] = [];

        if ($currentPage > 1) {
            $pagination['links']['previous'] = $paginator->getUrl($currentPage - 1);
        }

        if ($currentPage < $lastPage) {
            $pagination['links']['next'] = $paginator->getUrl($currentPage + 1);
        }

        return ['pagination' => $pagination];
    }

    public function cursor(CursorInterface $cursor): array
    {
        // TODO: Implement cursor() method.
    }
}