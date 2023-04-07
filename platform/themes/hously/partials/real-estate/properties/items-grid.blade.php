<div class="mt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-[30px]">
    @foreach($properties as $property)
        <div class="overflow-hidden duration-500 ease-in-out bg-white shadow property-item group rounded-xl dark:bg-slate-900 hover:shadow-xl dark:hover:shadow-xl dark:shadow-gray-700 dark:hover:shadow-gray-700">
            <div class="relative overflow-hidden">
                <a href="{{ $property->url }}">
                    <img src="{{ RvMedia::getImageUrl($property->image, 'small', false, RvMedia::getDefaultImage()) }}" alt="{{ $property->name }}" class="transition-all duration-500 hover:scale-110">
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
                <div class="absolute bottom-0 flex text-sm ltr:left-0 rtl:right-[-27px] item-info-wrap">
                    <span class="flex items-center py-1 pl-6 pr-4 text-white">{{ $property->category->name }}</span>
                    {!! $property->status->toHtml() !!}
                </div>
            </div>

            <div class="p-6">
                <div class="truncate">
                    <a href="{{ $property->url }}" class="text-lg font-medium uppercase duration-500 ease-in-out hover:text-primary" title="{{ $property->name }}">
                        {!! BaseHelper::clean($property->name) !!}
                    </a>
                    @if($property->city->name || $property->state->name)
                        <p class="truncate text-slate-600 dark:text-slate-300">{{ $property->city->name ? $property->city->name . ', ' : '' }}{{ $property->state->name }}</p>
                    @else
                        <p class="truncate text-slate-600 dark:text-slate-300">&nbsp;</p>
                    @endif
                </div>

                <ul class="flex items-center justify-between py-3 ltr:pl-0 rtl:pr-0 mb-0 list-none border-b dark:border-gray-800">
                    @if($property->number_bedroom)
                        <li class="flex items-center ltr:mr-2 rtl:ml-2">
                            <i class="text-2xl text-primary mdi mdi-bed-empty ltr:mr-2 rtl:ml-2"></i>
                            <span>{{ trans_choice(__('1 Bed|:number Beds'), $property->number_bedroom, ['number' => $property->number_bedroom]) }}</span>
                        </li>
                    @endif

                    @if($property->number_bathroom)
                        <li class="flex items-center ltr:mr-2 rtl:ml-2">
                            <i class="text-2xl text-primary mdi mdi-shower ltr:mr-2 rtl:ml-2"></i>
                            <span>{{ trans_choice(__('1 Bath|:number Baths'), $property->number_bathroom, ['number' => $property->number_bathroom]) }}</span>
                        </li>
                    @endif

                    @if($property->square)
                        <li class="flex items-center ltr:mr-2 rtl:ml-2">
                            <i class="text-2xl text-primary mdi mdi-arrow-collapse-all ltr:mr-2 rtl:ml-2"></i>
                            <span>{{ $property->square_text }}</span>
                        </li>
                    @endif
                </ul>

                <ul class="flex items-center justify-between pt-6 pl-0 mb-0 list-none">
                    <li>
                        <span class="text-slate-400">{{ __('Price') }}</span>
                        <p class="text-lg font-semibold">{{ format_price($property->price, $property->currency) }}</p>
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
    @endforeach
</div>
