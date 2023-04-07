<?php

use Botble\Widget\AbstractWidget;

class ContactInformationWidget extends AbstractWidget
{
    protected $config = [];

    protected $widgetDirectory = 'contact-information';

    public function __construct()
    {
        parent::__construct([
            'menu_id' => 'footer_menu',
            'name' => __('Contact Information'),
            'description' => __('A contact information widget used at the page footer.'),
        ]);
    }
}
