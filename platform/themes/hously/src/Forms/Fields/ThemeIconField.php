<?php

namespace Theme\Hously\Forms\Fields;

use Assets;
use Kris\LaravelFormBuilder\Fields\FormField;
use Theme;

class ThemeIconField extends FormField
{
    protected function getTemplate(): string
    {
        Assets::addScriptsDirectly(Theme::asset()->url('js/icons-field.js'))
            ->addStylesDirectly(Theme::asset()->url('css/icons.css'));

        return Theme::getThemeNamespace('partials.forms.fields.icons-field-form');
    }
}
