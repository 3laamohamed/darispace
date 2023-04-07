@php
    Theme::set('pageCoverImage', $page->getMetaData('cover_image', true));
    Theme::set('pageDescription', $page->description)
@endphp

{!! apply_filters(PAGE_FILTER_FRONT_PAGE_CONTENT, BaseHelper::clean($page->content), $page) !!}
