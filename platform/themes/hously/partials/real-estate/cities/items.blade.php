@php
    $currentLayout = BaseHelper::stringify(request()->query('layout')) ?? (theme_option('cities_list_layout') ?: 'grid');

    if (! in_array($currentLayout, ['grid', 'list'])) {
        $currentLayout = 'grid';
    }
@endphp

{!! Theme::partial("real-estate.cities.items-$currentLayout", compact('cities')) !!}

@if ($cities instanceof \Illuminate\Pagination\LengthAwarePaginator)
    {{ $cities->links(Theme::getThemeNamespace('partials.pagination')) }}
@endif
