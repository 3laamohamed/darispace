<div @class(['grid grid-cols-1', 'mt-10' => $style === 2])>
    <ul @class([
        'flex-wrap justify-center inline-block w-full p-4 text-center bg-white border-b sm:w-fit rounded-t-xl dark:border-gray-800 mb-0',
        'dark:bg-slate-900' => $style === 1,
        'mx-auto mt-10 sm:w-fit bg-white/80 dark:bg-slate-900/80 backdrop-blur-sm' => $style === 2,
    ]) id="searchTab" data-tabs-toggle="#search-filter" role="tablist">
        @if($shortcode->enabled_search_projects)
            <li role="presentation" class="inline-block">
                <button @class(['w-full px-6 py-2 text-base font-medium transition-all duration-500 ease-in-out hover:text-primary', 'rounded-md' => $style === 1, 'rounded-xl' => $style === 2, 'rounded-3xl' => $style === 4]) id="projects-tab" data-tabs-target="#projects" type="button" role="tab" aria-controls="projects" aria-selected="true">
                    {{ __('Projects') }}
                </button>
            </li>
        @endif
        {{-- <li role="presentation" class="inline-block">
            <button @class(['w-full px-6 py-2 text-base font-medium transition-all duration-500 ease-in-out', 'rounded-md' => $style === 1, 'rounded-xl' => $style === 2, 'rounded-3xl' => $style === 4]) id="sale-tab" data-tabs-target="#sale" type="button" role="tab" aria-controls="sale" aria-selected="false">
                {{ __('Sale') }}
            </button>
        </li>
        <li role="presentation" class="inline-block">
            <button @class(['w-full px-6 py-2 text-base font-medium transition-all duration-500 ease-in-out', 'rounded-md' => $style === 1, 'rounded-xl' => $style === 2, 'rounded-3xl' => $style === 4]) id="rent-tab" data-tabs-target="#rent" type="button" role="tab" aria-controls="rent" aria-selected="false">
                {{ __('Rent') }}
            </button>
        </li> --}}
        <li role="presentation" class="inline-block">
            <button @class(['w-full px-6 py-2 text-base font-medium transition-all duration-500 ease-in-out', 'rounded-md' => $style === 1, 'rounded-xl' => $style === 2, 'rounded-3xl' => $style === 4]) id="investor-tab" data-tabs-target="#investor" type="button" role="tab" aria-controls="investor" aria-selected="false">
                {{ __('Investors') }}
            </button>
        </li>

        <li role="presentation" class="inline-block">
            <button @class(['w-full px-6 py-2 text-base font-medium transition-all duration-500 ease-in-out', 'rounded-md' => $style === 1, 'rounded-xl' => $style === 2, 'rounded-3xl' => $style === 4]) id="property-tab" data-tabs-target="#property" type="button" role="tab" aria-controls="property" aria-selected="false">
                {{ __('Property') }}
            </button>
        </li>

    </ul>

    <div class="p-6 bg-white shadow-md search-filter dark:bg-slate-900 ltr:rounded-tl-none rtl:rounded-tr-none ltr:rounded-tr-none rtl:rounded-tl-none ltr:md:rounded-tr-xl rtl:md:rounded-tl-xl rounded-xl dark:shadow-gray-700">
        @if($shortcode->enabled_search_projects)
            <div id="projects" role="tabpanel" aria-labelledby="projects-tab">
                {!! Theme::partial('real-estate.projects.search-box', ['id'=>'sale','type' => 'projects', 'categories' => $categories]) !!}
            </div>
        @endif

        {{-- <div class="hidden" id="sale" role="tabpanel" aria-labelledby="sale-tab">
            {!! Theme::partial('filters.property', ['type' => 'sale', 'categories' => $categories]) !!}
        </div>

        <div class="hidden" id="rent" role="tabpanel" aria-labelledby="rent-tab">
            {!! Theme::partial('filters.property', ['type' => 'rent', 'categories' => $categories]) !!}
        </div> --}}

        <div class="hidden" id="investor" role="tabpanel" aria-labelledby="investor-tab">
            {!! Theme::partial('real-estate.investors.search-box', ['id'=>'mobile','categories' => $categories,'type' => \DB::table('re_investors')->get(), 'investors' => \DB::table('re_investors')->get()]) !!}
        </div>

        {{-- @php
            dd($id);
        @endphp --}}
        <div class="hidden" id="property" role="tabpanel" aria-labelledby="property-tab">
            {!! Theme::partial('real-estate.properties.search-box', ['id'=>'rent','categories'=>$categories,'type' => \DB::table('re_properties')->get(), 'properties' => \DB::table('re_properties')->get()]) !!}
        </div>
    </div>
</div>
