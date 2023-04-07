@php(Theme::set('navStyle', 'light'))

{!! Theme::partial('header') !!}

{!! Theme::partial('breadcrumb') !!}

{!! Theme::content() !!}

{!! Theme::partial('footer') !!}
