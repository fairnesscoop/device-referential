<?php

declare(strict_types=1);

namespace App\Application\Manufacturer\Query;

use App\Domain\Manufacturer\Repository\ManufacturerRepositoryInterface;
use App\Domain\Pagination;

final class ListManufacturersQueryHandler
{
    public function __construct(
        private ManufacturerRepositoryInterface $manufacturerRepository,
    ) {
    }

    public function __invoke(ListManufacturersQuery $lisManufacturersQuery): Pagination
    {
        $page = $lisManufacturersQuery->page;
        $pageSize = $lisManufacturersQuery->pageSize;

        $result = $this->manufacturerRepository->findManufacturers(
            page: $page,
            pageSize: $pageSize,
        );

        return new Pagination(
            items: $result,
            totalItems: $result->count(),
            page: $page,
            pageSize: $pageSize,
        );
    }
}
