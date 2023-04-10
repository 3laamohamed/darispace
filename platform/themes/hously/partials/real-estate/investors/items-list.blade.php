<div class="mt-8 grid grid-cols-1 lg:grid-cols-2 gap-[30px]">
    @foreach($investors as $investor)
    <div class="w-full mx-auto overflow-hidden duration-500 ease-in-out bg-white shadow investor-item group rounded-xl dark:bg-slate-900 hover:shadow-xl dark:hover:shadow-xl dark:shadow-gray-700 dark:hover:shadow-gray-700 lg:max-w-2xl">
        <div class="h-full md:flex">
                <div class="relative overflow-hidden md:shrink-0">
                    <a href="{{ route('public.investor',$investor->id) }}">
                        <img class="object-cover w-full h-full transition-all duration-500 md:w-48 hover:scale-110" src="{{ RvMedia::getImageUrl($investor->image, 'small', false, RvMedia::getDefaultImage()) }}" alt="{{ $investor->name }}">
                    </a>
                    <div class="absolute top-6 ltr:right-6 rtl:left-6">
                        <button type="button" class="text-lg text-red-600 bg-white rounded-full shadow btn btn-icon dark:bg-slate-900 dark:shadow-gray-700 add-to-wishlist" aria-label="{{ __('Add to wishlist') }}" data-type="investor" data-id="{{ $investor->id }}">
                            <i class="mdi mdi-heart-outline"></i>
                        </button>
                    </div>
                    {{-- @if($imagesCount = count($investor->images))
                        <div class="absolute top-6 ltr:left-6 rtl:right-6">
                            <div class="flex items-center justify-center content-center p-2 pt-2.5 bg-gray-700 rounded-md bg-opacity-60 text-white text-sm">
                                <i class="leading-none mdi mdi-camera-outline ltr:mr-1 rtl:ml-1"></i>
                                <span class="leading-none">{{ $imagesCount }}</span>
                            </div>
                        </div>
                    @endif --}}
                </div>
                <div class="p-6">
                    <div>
                        <div class="-ml-0.5 mb-2">
                            {{-- <a href="{{ $investor->category->url }}" class="text-sm transition-all hover:text-primary">
                                <i class="mdi mdi-tag-outline"></i>
                                {{ $investor->category->name }}
                            </a> --}}
                        </div>
                        <a href="{{ route('public.investor',$investor->id) }}" class="text-lg font-medium duration-500 ease-in-out hover:text-primary" title="{{ $investor->name }}">
                            {{ $investor->name }}
                        </a>
                        {{-- @if($investor->city->name || $investor->state->name)
                            <p class="truncate text-slate-600 dark:text-slate-300">{{ $investor->city->name ? $investor->city->name . ', ' : '' }}{{ $investor->state->name }}</p>
                        @else
                            <p class="truncate text-slate-600 dark:text-slate-300">&nbsp;</p>
                        @endif --}}
                    </div>
                    {{-- @if(RealEstateHelper::isEnabledReview())
                        <div class="mt-2">
                            @include(Theme::getThemeNamespace('views.real-estate.partials.review-star'), ['avgStar' => $investor->reviews_avg_star, 'count' => $investor->reviews_count])
                        </div>
                    @endif --}}
                </div>
            </div>
        </div>
    @endforeach
</div>
