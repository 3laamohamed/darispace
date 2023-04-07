@if (is_plugin_active('real-estate'))
    @php
        $currencies = get_all_currencies();
    @endphp

    @if ($currencies->count() > 1)
        <li class="relative inline-block text-left currency-switcher rtl:text-right">
            <div>
                <button id="button-currency-switcher" type="button" class="inline-flex justify-center w-full px-2 py-2 text-sm font-medium text-gray-300 border border-gray-800 rounded-md shadow-sm btn btn-icon btn-sm hover:bg-primary hover:text-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 focus:ring-offset-gray-100 dark:border-slate-700" aria-expanded="true" aria-haspopup="true">
                    {{ get_application_currency()->title }}
                    <i class="ml-1 leading-none mdi mdi-chevron-down rtl:mr-1"></i>
                </button>
            </div>
            <div class="dropdown-currency-switcher overflow-hidden w-[120px] transform opacity-0 scale-95 hidden transition ease-out duration-100 absolute right-0 bottom-[45px] z-10 mt-2 w-56 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none dark:bg-slate-900">
                <div>
                    @foreach($currencies as $currency)
                        <a href="{{ route('public.change-currency', $currency->title) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-slate-200 item-currency dark:text-white dark:hover:bg-slate-600">{{ $currency->title }}</a>
                    @endforeach
                </div>
            </div>
        </li>
    @endif
@endif
