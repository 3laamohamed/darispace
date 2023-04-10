<?php

namespace Botble\RealEstate\Repositories\Caches;

use Botble\Support\Repositories\Caches\CacheAbstractDecorator;
use Botble\RealEstate\Repositories\Interfaces\InvestorInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class InvestorCacheDecorator extends CacheAbstractDecorator implements InvestorInterface
{
    public function getInvestors($filters = [], $params = []): Collection|LengthAwarePaginator
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }
}
