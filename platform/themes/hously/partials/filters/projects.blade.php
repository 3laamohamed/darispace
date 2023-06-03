<div>
    <label for="choices-bathrooms-{{ $type }}" class="font-medium form-label text-slate-900 dark:text-white">{{ __('Select project:') }}</label>
    <div class="relative mt-2 filter-search-form filter-border">
        <i class="mdi mdi-home-outline icons"></i>
        <select class="form-select z-2" data-trigger name="project_id" id="choices-bathrooms-{{ $id ?? $type }}" aria-label="{{ __('project') }}">
            <option value="">{{ __('All projects') }}</option>
            @foreach(\DB::table('re_projects')->get() as $project)
                <option value="{{ $project->id }}" {{ request()->project_id == $project->id ? 'selected':'' }}>{{ $project->name }}</option>
            @endforeach
        </select>
    </div>
</div>
