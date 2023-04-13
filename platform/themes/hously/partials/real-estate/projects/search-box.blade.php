<form action="{{ $actionUrl ?? route('public.projects') }}" data-ajax-url="{{ $ajaxUrl ?? route('public.projects') }}" class="search-filter">
    {{-- @php
        dd( RealestateHelper::getProjectsListPageUrl());
    @endphp --}}
    <div class="space-y-5 registration-form text-dark text-start">
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:gap-0">
            {{-- {!! Theme::partial('filters.keyword', compact('type')) !!} --}}
            {!! Theme::partial('filters.projects', compact('id', 'type')) !!}

            {!! Theme::partial('filters.location', compact('type')) !!}

            {!! Theme::partial('filters.category', compact('id', 'type', 'categories')) !!}
            {{-- {!! Theme::partial('filters.investor', compact('id', 'type', 'investors')) !!} --}}

            @php

                $investors=\DB::table('re_investors')->get();
            @endphp
            {!! Theme::partial('filters.investor', compact('id', 'type', 'investors')) !!}


            {{-- <div>
                <label for="choices-type-rent" class="font-medium form-label text-slate-900 dark:text-white">نوع:</label>
                <div class="relative mt-2 filter-search-form filter-border">
                    <i class="mdi mdi-currency-usd icons"></i>
                    <div class="choices" data-type="select-one" tabindex="0" role="listbox" aria-haspopup="true" aria-expanded="false">
                        <div class="choices__inner">
                            <select data-trigger="" name="type" id="choices-type-rent" aria-label="نوع" class="choices__input" hidden="" tabindex="-1" data-choice="active">
                                <option value="" data-custom-properties="[object Object]">كل الأنواع</option>
                            </select>
                            <div class="choices__list choices__list--single">
                                <div class="choices__item choices__placeholder choices__item--selectable" data-item="" data-id="1" data-value="" data-custom-properties="[object Object]" aria-selected="true">كل الأنواع</div></div></div><div class="choices__list choices__list--dropdown" aria-expanded="false"><div class="choices__list" role="listbox"><div id="choices--choices-type-rent-item-choice-3" class="choices__item choices__item--choice is-selected choices__placeholder choices__item--selectable" role="option" data-choice="" data-id="3" data-value="" data-select-text="Press to select" data-choice-selectable="" aria-selected="false">كل الأنواع</div><div id="choices--choices-type-rent-item-choice-1" class="choices__item choices__item--choice choices__item--selectable is-highlighted" role="option" data-choice="" data-id="1" data-value="rent" data-select-text="Press to select" data-choice-selectable="" aria-selected="true">إيجار</div><div id="choices--choices-type-rent-item-choice-2" class="choices__item choices__item--choice choices__item--selectable" role="option" data-choice="" data-id="2" data-value="sale" data-select-text="Press to select" data-choice-selectable="">عروض</div></div></div></div>
                </div>
            </div> --}}

        </div>

        <button type="button" class="flex items-center gap-2 toggle-advanced-search text-secondary hover:text-primary">
            {{ __('Advanced') }}
            <i class="mdi mdi-chevron-down-circle-outline"></i>
        </button>

        <div class="hidden space-y-5 transition-all duration-200 ease-in-out advanced-search">
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4 lg:gap-0">
                {!! Theme::partial('filters.block', compact('id', 'type')) !!}

                {!! Theme::partial('filters.floor', compact('id', 'type')) !!}

                {!! Theme::partial('filters.flat', compact('id', 'type')) !!}
            </div>
        </div>

        <div class="grid items-center grid-cols-3 gap-2 md:flex">
            <button type="submit" class="col-span-2 btn bg-primary hover:bg-secondary border-primary hover:border-secondary text-white submit-btn w-full md:w-1/4 !h-12 rounded transition-all ease-in-out duration-200">
                <i class="mdi mdi-magnify ltr:mr-2 rtl:ml-2"></i>
                {{ __('Search') }}
            </button>

            <button type="button" class="col-span-1 md:mt-0 block md:inline-block w-full md:w-fit px-4 bg-slate-500 rounded text-white py-[0.70rem] hover:bg-slate-600" id="reset-filter">
                <i class="mr-1 mdi mdi-refresh"></i>
                {{ __('Reset') }}
            </button>
        </div>
    </div>
</form>
