<?php

namespace Botble\RealEstate\Enums;

use Botble\Base\Supports\Enum;
use Html;
use Illuminate\Support\HtmlString;

/**
 * @method static PropertyDurationEnum FIVE()
 * @method static PropertyDurationEnum SEVEN()
 * @method static PropertyDurationEnum TEN()
 * @method static PropertyDurationEnum FIFTEEN()
 * @method static PropertyDurationEnum TWENTY()
 * @method static PropertyDurationEnum RENTED()
 * @method static PropertyDurationEnum BUILDING()
 */
class PropertyDurationEnum extends Enum
{
    public const FIVE = '5';
    public const SEVEN = '7';
    public const TEN = '10';
    public const FIFTEEN = '15';
    public const TWENTY = '20';


    public static $langPath = 'plugins/real-estate::property.durations';

    public function toHtml(): HtmlString|string|null
    {
        return match ($this->value) {
            self::FIVE => Html::tag(
                'span',
                self::FIVE()->label(),
                ['class' => 'label-default duration-label']
            )
                ->toHtml(),
            self::SEVEN => Html::tag('span', self::SEVEN()->label(), ['class' => 'label-success duration-label'])
                ->toHtml(),
            self::TEN => Html::tag('span', self::TEN()->label(), ['class' => 'label-success duration-label'])
                ->toHtml(),
            self::FIFTEEN => Html::tag('span', self::FIFTEEN()->label(), ['class' => 'label-danger duration-label'])
                ->toHtml(),
            self::TWENTY => Html::tag('span', self::TWENTY()->label(), ['class' => 'label-success duration-label'])
                ->toHtml(),
            default => null,
        };
    }
}
