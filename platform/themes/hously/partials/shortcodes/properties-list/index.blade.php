@php
    Theme::asset()->usePath()->add('leaflet-css', 'plugins/leaflet/leaflet.css');
    Theme::asset()->usePath()->add('style', 'css/style.css');
    Theme::asset()->container('footer')->usePath()->add('leaflet-js', 'plugins/leaflet/leaflet.js');
    Theme::asset()->container('footer')->usePath()->add('leaflet-markercluster', 'plugins/leaflet/leaflet.markercluster-src.js');

    $layouts = [
        'grid' => [
            'name' => __('Grid'),
            'icon' => 'mdi mdi-view-grid-outline',
        ],
        'list' => [
            'name' => __('List'),
            'icon' => 'mdi mdi-view-list-outline',
        ],
        // 'map' => [
        //     'name' => __('Map'),
        //     'icon' => 'mdi mdi-map-marker',
        // ],
    ];

    $currentLayout = BaseHelper::stringify(request()->query('layout')) ?? (theme_option('properties_list_layout') ?: 'grid');

    if (! in_array($currentLayout, array_keys($layouts))) {
        $currentLayout = 'grid';
    }
@endphp

<div class="container mt-12 md:mt-16 item-search">
    <div class="flex justify-between">
        <div class="flex gap-2">
            <button class="block px-3 py-2 text-white transition-all bg-primary md:hidden rounded-xl hover:bg-secondary" id="open-filter">
                <i class="mdi mdi-filter"></i>
                <span class="hidden md:block">{{ __('Filter') }}</span>
            </button>
            @foreach($layouts as $key => $layout)
                <button @disabled($currentLayout === $key) @class(['hidden md:flex items-center pt-1 px-2 rounded-md text-white leading-none hover:bg-secondary cursor-pointer toggle-layout', 'bg-secondary' => $currentLayout === $key, 'bg-slate-500' => $currentLayout !== $key]) data-type="{{ $key }}" title="{{ $layout['name'] }}">
                    <i class="{{ $layout['icon'] }} text-2xl"></i>
                </button>
            @endforeach
        </div>
        <div class="flex items-center gap-3">
            <div>
                <select name="per_page" id="per-page" class="p-3 border rounded-lg cursor-pointer border-slate-300 focus-visible:outline-primary dark:text-slate-600">
                    <option value="">{{ __('Showing') }}</option>
                    @foreach(RealEstateHelper::getPropertiesPerPageList() as $perPage)
                        <option value="{{ $perPage }}" @selected((int)BaseHelper::stringify(request()->query('per_page')) === $perPage)>{{ $perPage }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <select name="sort_by" id="sort-by" class="p-3 border rounded-lg cursor-pointer border-slate-300 focus-visible:outline-primary dark:text-slate-600">
                    <option value="">{{ __('Default') }}</option>
                    @foreach(RealEstateHelper::getSortByList() as $key => $value)
                        <option value="{{ $key }}" @selected(BaseHelper::stringify(request()->query('sort_by')) === $key)>{{ $value }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>

<section class="relative">
    <div class="container">
        <div id="items-map" @class(['hidden' => (! request()->input('layout') == 'map') || ! $showMap])>
            {!! Theme::partial("real-estate.properties.items-map", compact('properties')) !!}
        </div>
        <div id="items-list" data-type="property" @class(['hidden' => request()->input('layout') == 'map']) data-layout="{{ theme_option('properties_list_layout') }}" style="max-height: none; max-width: none">
            {!! Theme::partial("real-estate.properties.items-$currentLayout", compact('properties')) !!}
        </div>
    </div>
</section>

<div class="hidden w-full mx-auto overflow-hidden duration-500 ease-in-out bg-white shadow group rounded-xl dark:bg-slate-900 hover:shadow-xl dark:hover:shadow-xl dark:shadow-gray-700 dark:hover:shadow-gray-700 lg:max-w-2xl" id="property-list-skeleton">
    <div class="md:flex">
        <div class="flex items-center justify-center bg-gray-300 rounded-l h-60 dark:bg-gray-700">
            <i class="px-12 py-16 text-gray-200 text-8xl mdi mdi-image-filter-hdr"></i>
        </div>
        <div class="p-6">
            <div class="pb-6 space-y-4">
                <div class="hidden md:flex items-center -ml-0.5 mb-2">
                    <i class="mr-1 text-sm mdi mdi-tag-outline text-slate-200"></i>
                    <div class="w-1/4 h-2 rounded bg-slate-200"></div>
                </div>
                <div class="h-2 rounded bg-slate-200"></div>
                <div class="w-3/5 h-2 rounded bg-slate-200"></div>
            </div>

            <ul class="flex items-center justify-between py-6 pl-0 mb-0 list-none md:py-4">
                <li class="flex items-center ltr:mr-4 rtl:ml-4">
                    <i class="text-2xl text-slate-200 mdi mdi-shower ltr:mr-2 rtl:ml-2"></i>
                    <div class="w-10 h-2 rounded bg-slate-200"></div>
                </li>

                <li class="flex items-center ltr:mr-4 rtl:ml-4">
                    <i class="text-2xl text-slate-200 mdi mdi-bed-empty ltr:mr-2 rtl:ml-2"></i>
                    <div class="w-10 h-2 rounded bg-slate-200"></div>
                </li>

                <li class="flex items-center">
                    <i class="text-2xl text-slate-200 mdi mdi-arrow-collapse-all ltr:mr-2 rtl:ml-2"></i>
                    <div class="w-10 h-2 rounded bg-slate-200"></div>
                </li>
            </ul>
        </div>
    </div>
</div>

<div class="hidden overflow-hidden duration-500 ease-in-out bg-white shadow group rounded-xl dark:bg-slate-900 hover:shadow-xl dark:hover:shadow-xl dark:shadow-gray-700 dark:hover:shadow-gray-700" id="property-grid-skeleton">
    <div class="relative">
        <div class="flex items-center justify-center w-full bg-gray-300 rounded h-60 dark:bg-gray-700">
            <i class="text-gray-200 text-8xl mdi mdi-image-filter-hdr"></i>
        </div>
    </div>

    <div class="p-6 space-y-6">
        <div class="space-y-4">
            <div class="h-2 rounded bg-slate-200"></div>
            <div class="w-3/5 h-2 rounded bg-slate-200"></div>
        </div>

        <ul class="flex items-center justify-between py-6 pl-0 mb-0 list-none">
            <li class="flex items-center ltr:mr-4 rtl:ml-4">
                <i class="text-2xl text-slate-200 mdi mdi-shower ltr:mr-2 rtl:ml-2"></i>
                <div class="w-10 h-2 rounded bg-slate-200"></div>
            </li>

            <li class="flex items-center ltr:mr-4 rtl:ml-4">
                <i class="text-2xl text-slate-200 mdi mdi-bed-empty ltr:mr-2 rtl:ml-2"></i>
                <div class="w-10 h-2 rounded bg-slate-200"></div>
            </li>

            <li class="flex items-center">
                <i class="text-2xl text-slate-200 mdi mdi-arrow-collapse-all ltr:mr-2 rtl:ml-2"></i>
                <div class="w-10 h-2 rounded bg-slate-200"></div>
            </li>
        </ul>
    </div>
</div>

<div class="hidden overflow-hidden duration-500 ease-in-out bg-white shadow group rounded-xl dark:bg-slate-900 hover:shadow-xl dark:hover:shadow-xl dark:shadow-gray-700 dark:hover:shadow-gray-700" id="property-map-skeleton">
    <div class="relative">
        <div class="flex items-center justify-center w-full bg-gray-300 rounded h-60 dark:bg-gray-700">
            <i class="text-gray-200 text-8xl mdi mdi-image-filter-hdr"></i>
        </div>
    </div>

    <div class="p-6 space-y-6">
        <div class="space-y-4">
            <div class="h-2 rounded bg-slate-200"></div>
            <div class="w-3/5 h-2 rounded bg-slate-200"></div>
        </div>
    </div>
</div>
