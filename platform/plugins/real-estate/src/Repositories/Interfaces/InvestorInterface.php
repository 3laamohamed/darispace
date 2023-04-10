<?php

namespace Botble\RealEstate\Repositories\Interfaces;

use Botble\Support\Repositories\Interfaces\RepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface InvestorInterface extends RepositoryInterface
{
    public function getInvestors(array $filters = [], array $params = []): Collection|LengthAwarePaginator;

}
