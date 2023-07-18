<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="light scroll-smooth" dir="{{ BaseHelper::siteLanguageDirection() === 'rtl' ? 'rtl' : 'ltr' }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=5, user-scalable=1" name="viewport"/>
        <meta name="csrf-token" content="{{ csrf_token() }}">

        {!! BaseHelper::googleFonts('https://fonts.googleapis.com/css2?family=' . urlencode(theme_option('primary_font', 'League Spartan')) . ':wght@300;400;500;600;700&display=swap') !!}

        <style>
            :root {
                --primary-color: {{ implode(' ', BaseHelper::hexToRgb(theme_option('primary_color', '#16a34a'))) }};
                --secondary-color: {{ theme_option('secondary_color', '#15803D') }};
                --primary-font: '{{ theme_option('primary_font', 'League Spartan') }}', sans-serif;
                --primary-color-rgb: {{ BaseHelper::hexToRgba(theme_option('primary_color', '#16a34a'), 0.8) }};
            }
        </style>

        <script>
            window.defaultThemeMode = @json(theme_option('default_theme_mode', 'system'));
        </script>

        <!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-K6FMSWK');</script>
        <!-- End Google Tag Manager -->

        {!! Theme::header() !!}
    </head>

    <body class="dark:bg-slate-900">
        <!-- Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-K6FMSWK"
            height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
            <!-- End Google Tag Manager (noscript) -->
        {!! apply_filters(THEME_FRONT_BODY, null) !!}

        <div id="alert-container"></div>

        @if (empty($withoutNavbar))
            {!! Theme::partial('topnav') !!}
        @endif
