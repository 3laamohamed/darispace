<?php

namespace Botble\RealEstate\Enums;

use Botble\Base\Supports\Enum;
use Html;
use Illuminate\Support\HtmlString;

/**
 * @method static PropertyStatusEnum NOT_AVAILABLE()
 * @method static PropertyStatusEnum WITHOUT_FINISHING()
 * @method static PropertyStatusEnum SEMI_FINISHED()
 * @method static PropertyStatusEnum FULLY_FINISHED()
 * @method static PropertyStatusEnum LUXURIOUS_FINISHING()
 * @method static PropertyStatusEnum SUPER_DELUXE_FINISHING()
 * @method static PropertyStatusEnum ULTRA_LUXE_FINISHING()
 * @method static PropertyStatusEnum DELUXE_FINISHING()
 */
class PropertyStatusEnum extends Enum
{
    public const NOT_AVAILABLE = 'not_available';
    public const WITHOUT_FINISHING = 'without_finishing';
    public const SEMI_FINISHED = 'semi_finished';
    public const FULLY_FINISHED = 'fully_finished';
    public const LUXURIOUS_FINISHING = 'luxurious_finishing';
    public const SUPER_DELUXE_FINISHING = 'super_deluxe_finishing';
    public const ULTRA_LUXE_FINISHING = 'ultra_luxe_finishing';
    public const DELUXE_FINISHING = 'deluxe_finishing';

    public static $langPath = 'plugins/real-estate::property.statuses';

    public function toHtml(): HtmlString|string|null
    {
        return match ($this->value) {
            self::NOT_AVAILABLE => Html::tag(
                'span',
                self::NOT_AVAILABLE()->label(),
                ['class' => 'label-default status-label']
            )
                ->toHtml(),
            self::WITHOUT_FINISHING => Html::tag('span', self::WITHOUT_FINISHING()->label(), ['class' => 'label-success status-label'])
                ->toHtml(),
            self::SEMI_FINISHED => Html::tag('span', self::SEMI_FINISHED()->label(), ['class' => 'label-success status-label'])
                ->toHtml(),
            self::FULLY_FINISHED => Html::tag('span', self::FULLY_FINISHED()->label(), ['class' => 'label-danger status-label'])
                ->toHtml(),
            self::LUXURIOUS_FINISHING => Html::tag('span', self::LUXURIOUS_FINISHING()->label(), ['class' => 'label-success status-label'])
                ->toHtml(),
            self::SUPER_DELUXE_FINISHING => Html::tag('span', self::SUPER_DELUXE_FINISHING()->label(), ['class' => 'label-danger status-label'])
                ->toHtml(),
            self::ULTRA_LUXE_FINISHING => Html::tag('span', self::ULTRA_LUXE_FINISHING()->label(), ['class' => 'label-info status-label'])
                ->toHtml(),
            self::DELUXE_FINISHING => Html::tag('span', self::DELUXE_FINISHING()->label(), ['class' => 'label-info status-label'])
                ->toHtml(),
            default => null,
        };
    }
}
