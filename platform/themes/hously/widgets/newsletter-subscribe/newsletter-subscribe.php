<?php

use Botble\Widget\AbstractWidget;

class NewsletterWidget extends AbstractWidget
{
    protected $widgetDirectory = 'newsletter-subscribe';

    public function __construct()
    {
        parent::__construct([
            'name' => __('Subscribe to Newsletter.'),
            'description' => __('Subscribe to get latest updates and information.'),
            'title' => null,
            'subtitle' => null,
        ]);
    }
}
