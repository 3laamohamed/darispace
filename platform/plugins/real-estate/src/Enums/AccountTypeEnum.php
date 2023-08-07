<?php

namespace Botble\RealEstate\Enums;

use Botble\Base\Supports\Enum;
use Html;
use Illuminate\Support\HtmlString;

/**
 * @method static AccountTypeEnum PROPERTY_OWNER()
 * @method static AccountTypeEnum PROPERTY_OFFICE()
 * @method static AccountTypeEnum CUSTOMER()
 */
class AccountTypeEnum extends Enum
{
    public const PROPERTY_OWNER = 'property_owner';
    public const PROPERTY_OFFICE = 'property_office';
    public const CUSTOMER = 'customer';

    public static $langPath = 'plugins/real-estate::property.moderation-statuses';

    public function toHtml(): HtmlString|string|null
    {
        return match ($this->value) {
            self::PROPERTY_OFFICE => Html::tag('span', self::PROPERTY_OFFICE()->label(), ['class' => 'label-info status-label'])
                ->toHtml(),
            self::PROPERTY_OWNER => Html::tag('span', self::PROPERTY_OWNER()->label(), ['class' => 'label-warning status-label'])
                ->toHtml(),
            self::CUSTOMER => Html::tag('span', self::CUSTOMER()->label(), ['class' => 'label-warning status-label'])
                ->toHtml(),
            default => null,
        };
    }
}
