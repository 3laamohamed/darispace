<?php

use Botble\Widget\AbstractWidget;

class SiteInformationWidget extends AbstractWidget
{
    protected $config = [];

    protected $widgetDirectory = 'site-information';

    public function __construct()
    {
        parent::__construct([
            'menu_id' => 'footer_menu',
            'name' => __('Site Information'),
            'url' => '#',
            'logo' => null,
            'description' => null,
        ]);
    }
}
