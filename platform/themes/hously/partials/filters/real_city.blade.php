@if($type=='projects')
<div>
    <label for="choices-blocks-{{ $type }}" class="font-medium form-label text-slate-900 dark:text-white">{{ __('Select City:') }}</label>
    <div class="relative mt-2 filter-search-form filter-border">
        <i class="mdi mdi-home-outline icons"></i>
        <select class="form-select z-2" data-trigger name="city_id" id="choices-bedrooms-sale" aria-label="{{ __('City') }}">
            <option value="">{{ __('All Cities') }}</option>
            @foreach(\DB::table('cities')->where('is_real_estate',1)->get() as $city)
                <option value="{{ $city->id }}" {{ request('city_id')==$city->id ? 'selected': ''}}>{{ $city->name }}</option>
            @endforeach
        </select>
    </div>
</div>

@else
@php
        $states = \DB::table('cities')->where('is_real_estate',1)->get();
    if(request()->state_id){
        $states = \DB::table('cities')->where('state_id',request()->state_id)->where('is_real_estate',1)->get();
    }
@endphp
<div>
    <label for="choices-blocks-{{ $type }}" class="font-medium form-label text-slate-900 dark:text-white">{{ __('Select City:') }}</label>
    <div class="relative mt-2 filter-search-form filter-border">
        <i class="mdi mdi-home-outline icons"></i>
        <div id="cities1">
        <select class="form-select z-2" data-trigger name="city_id" id="choices-blocks-{{ $id?? $type }}" aria-label="{{ __('City') }}">
            <option value="">{{ __('All Cities') }}</option>
            @foreach($states as $city)
                <option value="{{ $city->id }}" {{ request('city_id')==$city->id ? 'selected': ''}}>{{ $city->name }}</option>
            @endforeach
        </select>
        </div>
    </div>
</div>
@endif

