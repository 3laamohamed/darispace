<div>
    <label for="choices-bathrooms-{{ $type }}" class="font-medium form-label text-slate-900 dark:text-white">{{ __('Select State:') }}</label>
    <div class="relative mt-2 filter-search-form filter-border">
        <i class="mdi mdi-home-outline icons"></i>
        <select class="form-select z-2" data-trigger name="state_id" id="choices-bathrooms-{{ $id ?? $type }}" aria-label="{{ __('City') }}">
            <option value="">{{ __('All Cities') }}</option>
            @foreach(\DB::table('states')->get() as $state)
                <option value="{{ $state->id }}" {{ request('state_id')==$state->id ? 'selected': ''}}>{{ $state->name }}</option>
            @endforeach
        </select>
    </div>
</div>
