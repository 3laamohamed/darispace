<div>
    <label for="choices-bathrooms-{{ $type }}" class="font-medium form-label text-slate-900 dark:text-white">{{ __('Select property:') }}</label>
    <div class="relative mt-2 filter-search-form filter-border">
        <i class="mdi mdi-home-outline icons"></i>
        <select class="form-select z-2" data-trigger name="property_id" id="choices-bathrooms-{{ $id ?? $type }}" aria-label="{{ __('property') }}">
            <option value="">{{ __('All properties') }}</option>
            @foreach(\DB::table('re_properties')->get() as $property)
                <option value="{{ $property->id }}">{{ $property->name }}</option>
            @endforeach
        </select>
    </div>
</div>
