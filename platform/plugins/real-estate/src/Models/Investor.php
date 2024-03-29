<?php

namespace Botble\RealEstate\Models;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Arr;

class Investor extends BaseModel
{
    protected $table = 're_investors';

    protected $fillable = [
        'name',
        'image',
        'disc',
        'status',
    ];

    protected $casts = [
        'status' => BaseStatusEnum::class,
    ];

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class, 'investor_id');
    }

    // public function getImageAttribute(): ?string
    // {
    //     return $this->images ?? null;
    // }
}
