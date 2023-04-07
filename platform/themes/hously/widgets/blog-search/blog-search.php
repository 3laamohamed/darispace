<?php

use Botble\Widget\AbstractWidget;

class BlogSearchWidget extends AbstractWidget
{
    protected $widgetDirectory = 'blog-search';

    public function __construct()
    {
        parent::__construct([
            'name' => __('Blog Search'),
            'description' => __('Search blog posts'),
        ]);
    }
}
