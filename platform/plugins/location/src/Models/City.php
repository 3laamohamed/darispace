<?php

namespace Botble\Location\Models;

use Botble\Base\Casts\SafeContent;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Models\BaseModel;
use Botble\RealEstate\Models\Project;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class City extends BaseModel
{
    protected $table = 'cities';

    protected $fillable = [
        'name',
        'state_id',
        'country_id',
        'record_id',
        'order',
        'is_default',
        'is_real_estate',
        'status',
    ];

    protected $casts = [
        'status' => BaseStatusEnum::class,
        'name' => SafeContent::class,
    ];

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class)->withDefault();
    }

    public function projects()
    {
        return $this->hasMany(Project::class,'city_id');
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class)->withDefault();
    }
}
