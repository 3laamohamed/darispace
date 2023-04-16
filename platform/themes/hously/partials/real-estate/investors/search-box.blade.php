<form action="{{ $actionUrl ?? RealestateHelper::getInvestorsListPageUrl() }}" data-ajax-url="{{ $ajaxUrl ?? route('public.investors') }}" class="search-filter">
    <div class="space-y-5 registration-form text-dark text-start">
        <div class="grid grid-cols-1 gap-6 md:grid-cols-3 lg:gap-0">
            {{-- {!! Theme::partial('filters.keyword', compact('type')) !!} --}}

            @php

            $investors=\DB::table('re_investors')->get();
            // dd($id);
            @endphp
            {!! Theme::partial('filters.investor', compact('id', 'type', 'investors')) !!}

            {{-- {!! Theme::partial('filters.location', compact('type')) !!} --}}
            {!! Theme::partial('filters.city', compact('id','type')) !!}

            {{-- {!! Theme::partial('filters.city', compact('id', 'type', 'categories')) !!} --}}
            {!! Theme::partial('filters.categories', compact('id', 'type', 'categories',)) !!}

            <div>
                <label for="main_price" class="font-medium form-label text-slate-900 dark:text-white">{{ __('Main Price') }}</label>
                <div class="relative mt-2 filter-search-form filter-border">
                    <i class="mdi mdi-currency-usd icons"></i>
                    <input name="main_price" type="number" value="{{ request('main_price') }}" id="main_price" class="border-0 form-input filter-input-box bg-gray-50 dark:bg-slate-800" placeholder="{{ __('Main Price') }}">
                </div>
            </div>

            <div>
                <label for="deposit" class="font-medium form-label text-slate-900 dark:text-white">{{ __('deposit') }}</label>
                <div class="relative mt-2 filter-search-form filter-border">
                    <i class="mdi mdi-currency-usd icons"></i>
                    <input name="deposit" type="number" id="deposit" value="{{ request('deposit') }}" class="border-0 form-input filter-input-box bg-gray-50 dark:bg-slate-800" placeholder="{{ __('deposit') }}">
                </div>
            </div>

            <div>
                <label for="deliver_year" class="font-medium form-label text-slate-900 dark:text-white">{{ __('year_of_delivery') }}</label>
                <div class="relative mt-2 filter-search-form filter-border">
                    <i class="mdi mdi-home-outline icons"></i>
                    <input name="deliver_year" type="number" value="{{ request('deliver_year') }}" id="deliver_year" class="border-0 form-input filter-input-box bg-gray-50 dark:bg-slate-800" placeholder="{{ __('year_of_delivery') }}">
                </div>
            </div>

        </div>

        {{-- <button type="button" class="flex items-center gap-2 toggle-advanced-search text-secondary hover:text-primary">
            {{ __('Advanced') }}
            <i class="mdi mdi-chevron-down-circle-outline"></i>
        </button> --}}

        <div class="hidden space-y-5 transition-all duration-200 ease-in-out advanced-search">
            {{-- <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4 lg:gap-0">
                {!! Theme::partial('filters.block', compact('id', 'type')) !!}

                {!! Theme::partial('filters.floor', compact('id', 'type')) !!}

                {!! Theme::partial('filters.flat', compact('id', 'type')) !!}
            </div> --}}
        </div>

        <div class="grid items-center grid-cols-3 gap-2 md:flex">
            <button type="submit" class="col-span-2 btn bg-primary hover:bg-secondary border-primary hover:border-secondary text-white submit-btn w-full md:w-1/4 !h-12 rounded transition-all ease-in-out duration-200">
                <i class="mdi mdi-magnify ltr:mr-2 rtl:ml-2"></i>
                {{ __('Search') }}
            </button>

            <button type="button" class="col-span-1 md:mt-0 block md:inline-block w-full md:w-fit px-4 bg-slate-500 rounded text-white py-[0.70rem] hover:bg-slate-600" id="reset-filtr">
                <i class="mr-1 mdi mdi-refresh"></i>
                {{ __('Reset') }}
            </button>
        </div>
    </div>
</form>

