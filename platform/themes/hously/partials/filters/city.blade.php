<div>
    <label for="choices-bedrooms-{{ $type }}" class="font-medium form-label text-slate-900 dark:text-white">{{ __('Select City:') }}</label>
    <div class="relative mt-2 filter-search-form filter-border">
        <i class="mdi mdi-home-outline icons"></i>
        <select class="form-select z-2" data-trigger name="city_id" id="choices-bedrooms-{{ $id ?? $type }}" aria-label="{{ __('City') }}">
            <option value="">{{ __('All Cities') }}</option>
            @foreach(\DB::table('cities')->get() as $city)
                <option value="{{ $city->id }}" {{ request('city_id')==$city->id ? 'selected': ''}}>{{ $city->name }}</option>
            @endforeach
        </select>
    </div>
</div>
