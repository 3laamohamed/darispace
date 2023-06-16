<div class="mt-8 grid grid-cols-1 lg:grid-cols-2 gap-[30px]">
    @foreach($cities as $city)
    <div class="w-full mx-auto overflow-hidden duration-500 ease-in-out bg-white shadow city-item group rounded-xl dark:bg-slate-900 hover:shadow-xl dark:hover:shadow-xl dark:shadow-gray-700 dark:hover:shadow-gray-700 lg:max-w-2xl">
        <div class="h-full md:flex">
                <div class="relative overflow-hidden md:shrink-0">
                    <a href="{{ route('public.city',$city->id) }}">
                        <img class="object-cover w-full h-full transition-all duration-500 md:w-48 hover:scale-110" src="{{ RvMedia::getImageUrl($city->image, 'small', false, RvMedia::getDefaultImage()) }}" alt="{{ $city->name }}">
                    </a>
                    <div class="absolute top-6 ltr:right-6 rtl:left-6">
                        <button type="button" class="text-lg text-red-600 bg-white rounded-full shadow btn btn-icon dark:bg-slate-900 dark:shadow-gray-700 add-to-wishlist" aria-label="{{ __('Add to wishlist') }}" data-type="city" data-id="{{ $city->id }}">
                            <i class="mdi mdi-heart-outline"></i>
                        </button>
                    </div>
                    {{-- @if($imagesCount = count($city->images))
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
                            {{-- <a href="{{ $city->category->url }}" class="text-sm transition-all hover:text-primary">
                                <i class="mdi mdi-tag-outline"></i>
                                {{ $city->category->name }}
                            </a> --}}
                        </div>
                        <a href="{{ route('public.city',$city->id) }}" class="text-lg font-medium duration-500 ease-in-out hover:text-primary" title="{{ $city->name }}">
                            {{ $city->name }}
                        </a>
                        {{-- @if($city->city->name || $city->state->name)
                            <p class="truncate text-slate-600 dark:text-slate-300">{{ $city->city->name ? $city->city->name . ', ' : '' }}{{ $city->state->name }}</p>
                        @else
                            <p class="truncate text-slate-600 dark:text-slate-300">&nbsp;</p>
                        @endif --}}
                    </div>
                    {{-- @if(RealEstateHelper::isEnabledReview())
                        <div class="mt-2">
                            @include(Theme::getThemeNamespace('views.real-estate.partials.review-star'), ['avgStar' => $city->reviews_avg_star, 'count' => $city->reviews_count])
                        </div>
                    @endif --}}
                </div>
            </div>
        </div>
    @endforeach
</div>
