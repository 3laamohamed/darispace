<div>
    <label for="choices-investor-{{ $type }}" class="font-medium form-label text-slate-900 dark:text-white">{{ __('Select Investor:') }}</label>
    <div class="relative mt-2 filter-search-form filter-border">
        <i class="mdi mdi-home-outline icons"></i>
        <select class="form-select z-2" data-trigger name="investor_id" id="choices-type-{{ $id ?? $type }}" aria-label="{{ __('Investor') }}">
            <option value="">{{ __('All Investor') }}</option>
            @foreach($investors as $investor)
                <option value="{{ $investor->id }}">{{ $investor->name }}</option>
            @endforeach
        </select>
    </div>
</div>
