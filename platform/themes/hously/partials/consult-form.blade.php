<form class="generic-form" id="contact-form" method="post" action="{{ route('public.send.consult') }}">
    @csrf
    <input type="hidden" value="{{ $type }}" name="type">
    <input type="hidden" value="{{ $data->id }}" name="data_id">
    <div class="p-6 space-y-3">
        <h3 class="mb-4 text-xl font-bold">{{ __('Contact') }}</h3>
        <div>
            <input name="name" type="text" class="bg-white form-input dark:bg-slate-700" placeholder="{{ __('Name') }}">
        </div>
        <div>
            <input name="phone" type="number" class="bg-white form-input dark:bg-slate-700" placeholder="{{ __('Phone') }}">
        </div>
        <div>
            <input name="email" type="email" class="bg-white form-input dark:bg-slate-700" placeholder="{{ __('Email') }}">
        </div>
        <div>
            <input type="text" readonly class="text-gray-400 form-input" disabled value="{{ $data->name }}">
        </div>
        <div>
            <textarea name="content" rows="3" class="block p-2.5 w-full border rounded-sm border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Message"></textarea>
        </div>
        @if (setting('enable_captcha') && is_plugin_active('captcha'))
            <div class="form-group">
                {!! Captcha::display() !!}
            </div>
        @endif
        <div>
            <button type="submit" class="w-full text-white btn bg-primary">{{ __('Send') }}</button>
        </div>
        <div class="clearfix"></div>

        {!! apply_filters('consult_form_extra_info', null, $data) !!}
        <br>
    </div>
</form>
