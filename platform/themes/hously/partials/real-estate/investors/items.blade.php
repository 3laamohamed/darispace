@php
    $currentLayout = BaseHelper::stringify(request()->query('layout')) ?? (theme_option('investors_list_layout') ?: 'grid');

    if (! in_array($currentLayout, ['grid', 'list'])) {
        $currentLayout = 'grid';
    }
@endphp

{!! Theme::partial("real-estate.investors.items-$currentLayout", compact('investors')) !!}

@if ($investors instanceof \Illuminate\Pagination\LengthAwarePaginator)
    {{ $investors->links(Theme::getThemeNamespace('partials.pagination')) }}
@endif
