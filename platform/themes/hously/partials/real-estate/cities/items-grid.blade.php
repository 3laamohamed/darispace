<div class="grid lg:grid-cols-3 md:grid-cols-2 grid-cols-1 mt-8 gap-[30px]">
    @foreach($cities as $city)
        <div class="overflow-hidden duration-500 ease-in-out bg-white shadow city-item group rounded-xl dark:bg-slate-900 hover:shadow-xl dark:hover:shadow-xl dark:shadow-gray-700 dark:hover:shadow-gray-700">
            <div class="relative overflow-hidden" style="height: 260px;">
                <a href="/properties?city_id={{ $city->id }}">
                    <img src="{{ RvMedia::getImageUrl($city->image, 'small', false, RvMedia::getDefaultImage()) }}" alt="{{ $city->name }}" class="transition-all duration-500 hover:scale-110">
                </a>
                {{-- <div class="absolute top-6 ltr:right-6 rtl:left-6">
                    <button type="button" class="text-lg text-red-600 bg-white rounded-full shadow btn btn-icon dark:bg-slate-900 dark:shadow-gray-700 add-to-wishlist" aria-label="{{ __('Add to wishlist') }}" data-type="city" data-id="{{ $city->id }}">
                        <i class="mdi mdi-heart-outline"></i>
                    </button>
                </div> --}}
                {{-- @if($imagesCount = count($city->images))
                    <div class="absolute top-6 ltr:left-6 rtl:right-6">
                        <div class="flex items-center justify-center p-2 py-1 text-sm text-white bg-gray-700 rounded-lg bg-opacity-30">
                            <i class="mdi mdi-camera-outline ltr:mr-1 rtl:ml-1"></i>
                            <span>{{ $imagesCount }}</span>
                        </div>
                    </div>
                @endif --}}
            </div>
            <div class="p-6">
                <a href="/properties?city_id={{ $city->id }}" class="text-lg font-medium uppercase duration-500 ease-in-out hover:text-primary">
                    {!! BaseHelper::clean($city->name) !!}
                </a>
                <p class="truncate text-slate-600 dark:text-slate-300">
                    <i class="mdi mdi-home"></i>
                   {{ __('Properties Count') }} :  {{ count($city->properties) }}
                </p>
                {{-- @if($city->city->name || $city->state->name)
                    <p class="truncate text-slate-600 dark:text-slate-300">
                        <i class="mdi mdi-map-marker-outline"></i>
                        {{ $city->city->name ? $city->city->name . ', ' : '' }}{{ $city->state->name }}
                    </p>
                @endif --}}
                {{-- @if(RealEstateHelper::isEnabledReview())
                    <div class="mt-2">
                        @include(Theme::getThemeNamespace('views.real-estate.partials.review-star'), ['avgStar' => $city->reviews_avg_star, 'count' => $city->reviews_count])
                    </div>
                @endif --}}
            </div>
        </div>
    @endforeach
</div>
