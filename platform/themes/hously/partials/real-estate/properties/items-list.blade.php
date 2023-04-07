<div class="mt-8 grid grid-cols-1 lg:grid-cols-2 gap-[30px]">
    @foreach($properties as $property)
    <div class="w-full mx-auto overflow-hidden duration-500 ease-in-out bg-white shadow property-item group rounded-xl dark:bg-slate-900 hover:shadow-xl dark:hover:shadow-xl dark:shadow-gray-700 dark:hover:shadow-gray-700 lg:max-w-2xl">
        <div class="h-full md:flex">
                <div class="relative overflow-hidden md:shrink-0">
                    <a href="{{ $property->url }}">
                        <img class="object-cover w-full h-full transition-all duration-500 md:w-48 hover:scale-110" src="{{ RvMedia::getImageUrl($property->image, 'small', false, RvMedia::getDefaultImage()) }}" alt="{{ $property->name }}">
                    </a>
                    <div class="absolute top-6 ltr:right-6 rtl:left-6">
                        <button type="button" class="text-lg text-red-600 bg-white rounded-full shadow btn btn-icon dark:bg-slate-900 dark:shadow-gray-700 add-to-wishlist" aria-label="{{ __('Add to wishlist') }}" data-type="property" data-id="{{ $property->id }}">
                            <i class="mdi mdi-heart-outline"></i>
                        </button>
                    </div>
                    @if($imagesCount = count($property->images))
                        <div class="absolute top-6 ltr:left-6 rtl:right-6">
                            <div class="flex items-center justify-center content-center p-2 pt-2.5 bg-gray-700 rounded-md bg-opacity-60 text-white text-sm">
                                <i class="leading-none mdi mdi-camera-outline ltr:mr-1 rtl:ml-1"></i>
                                <span class="leading-none">{{ $imagesCount }}</span>
                            </div>
                        </div>
                    @endif
                    <div class="absolute bottom-0 flex text-sm md:hidden ltr:left-0 rtl:right-0 item-info-wrap">
                        <span class="flex items-center py-1 pl-6 pr-4 text-white">{{ $property->category->name }}</span>
                        {!! $property->status->toHtml() !!}
                    </div>
                </div>
                <div class="p-6">
                    <div>
                        <div class="hidden md:block -ml-0.5 mb-2">
                            <a href="{{ $property->category->url }}" class="text-sm transition-all hover:text-primary">
                                <i class="mdi mdi-tag-outline"></i>
                                {{ $property->category->name }}
                            </a>
                        </div>
                        <a href="{{ $property->url }}" class="text-lg font-medium duration-500 ease-in-out hover:text-primary" title="{{ $property->name }}">
                            {{ $property->name }}
                        </a>
                        @if($property->city->name || $property->state->name)
                            <p class="truncate text-slate-600 dark:text-slate-300">{{ $property->city->name ? $property->city->name . ', ' : '' }}{{ $property->state->name }}</p>
                        @else
                            <p class="truncate text-slate-600 dark:text-slate-300">&nbsp;</p>
                        @endif
                    </div>

                    <ul class="flex items-center justify-between py-6 pl-0 mb-0 list-none border-b md:py-4 dark:border-gray-800">
                        @if($bedrooms = $property->number_bedroom)
                            <li class="flex items-center ltr:mr-4 rtl:ml-4">
                                <i class="text-2xl text-primary mdi mdi-bed-empty ltr:mr-2 rtl:ml-2"></i>
                                <span>{{ trans_choice(__('1 Bed|:number Beds'), $bedrooms, ['number' => $bedrooms]) }}</span>
                            </li>
                        @endif

                        @if($bathrooms = $property->number_bathroom)
                            <li class="flex items-center ltr:mr-4 rtl:ml-4">
                                <i class="text-2xl text-primary mdi mdi-shower ltr:mr-2 rtl:ml-2"></i>
                                <span>{{ trans_choice(__('1 Bath|:number Baths'), $bathrooms, ['number' => $bathrooms]) }}</span>
                            </li>
                        @endif

                        @if($property->square)
                            <li class="flex items-center">
                                <i class="text-2xl text-primary mdi mdi-arrow-collapse-all ltr:mr-2 rtl:ml-2"></i>
                                <span>{{ $property->square_text }}</span>
                            </li>
                        @endif
                    </ul>

                    <ul class="flex items-center justify-between pt-6 pl-0 mb-0 list-none md:pt-4">
                        <li>
                            <span class="text-slate-400">{{ __('Price') }}</span>
                            <p class="text-lg font-medium">{{ format_price($property->price, $property->currency) }}</p>
                        </li>

                        @if(RealEstateHelper::isEnabledReview())
                            <li>
                                <span class="text-slate-400">{{ __('Rating') }}</span>
                                @include(Theme::getThemeNamespace('views.real-estate.partials.review-star'), ['avgStar' => $property->reviews_avg_star, 'count' => $property->reviews_count])
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    @endforeach
</div>
