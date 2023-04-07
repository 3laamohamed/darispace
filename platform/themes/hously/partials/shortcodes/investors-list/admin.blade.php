<div class="form-group mb-3">
    <label class="control-label">{{ __('Number of investors per page') }}</label>
    {!! Form::customSelect('per_page', RealEstateHelper::getInvestorsPerPageList(), Arr::get($attributes, 'per_page')) !!}
</div>
