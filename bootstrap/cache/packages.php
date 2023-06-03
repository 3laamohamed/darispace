<?php return array (
  'barryvdh/laravel-debugbar' => 
  array (
    'providers' => 
    array (
      0 => 'Barryvdh\\Debugbar\\ServiceProvider',
    ),
    'aliases' => 
    array (
      'Debugbar' => 'Barryvdh\\Debugbar\\Facades\\Debugbar',
    ),
  ),
  'barryvdh/laravel-dompdf' => 
  array (
    'providers' => 
    array (
      0 => 'Barryvdh\\DomPDF\\ServiceProvider',
    ),
    'aliases' => 
    array (
      'Pdf' => 'Barryvdh\\DomPDF\\Facade\\Pdf',
      'PDF' => 'Barryvdh\\DomPDF\\Facade\\Pdf',
    ),
  ),
  'barryvdh/laravel-ide-helper' => 
  array (
    'providers' => 
    array (
      0 => 'Barryvdh\\LaravelIdeHelper\\IdeHelperServiceProvider',
    ),
  ),
  'botble/api' => 
  array (
    'providers' => 
    array (
      0 => 'Botble\\Api\\Providers\\ApiServiceProvider',
    ),
  ),
  'botble/assets' => 
  array (
    'providers' => 
    array (
      0 => 'Botble\\Assets\\Providers\\AssetsServiceProvider',
    ),
    'aliases' => 
    array (
      'Assets' => 'Botble\\Assets\\Facades\\AssetsFacade',
    ),
  ),
  'botble/get-started' => 
  array (
    'providers' => 
    array (
      0 => 'Botble\\GetStarted\\Providers\\GetStartedServiceProvider',
    ),
  ),
  'botble/git-commit-checker' => 
  array (
    'providers' => 
    array (
      0 => 'Botble\\GitCommitChecker\\Providers\\GitCommitCheckerServiceProvider',
    ),
  ),
  'botble/installer' => 
  array (
    'providers' => 
    array (
      0 => 'Botble\\Installer\\Providers\\InstallerServiceProvider',
    ),
  ),
  'botble/menu' => 
  array (
    'providers' => 
    array (
      0 => 'Botble\\Menu\\Providers\\MenuServiceProvider',
    ),
    'aliases' => 
    array (
      'Menu' => 'Botble\\Menu\\Facades\\MenuFacade',
    ),
  ),
  'botble/optimize' => 
  array (
    'providers' => 
    array (
      0 => 'Botble\\Optimize\\Providers\\OptimizeServiceProvider',
    ),
  ),
  'botble/page' => 
  array (
    'providers' => 
    array (
      0 => 'Botble\\Page\\Providers\\PageServiceProvider',
    ),
  ),
  'botble/platform' => 
  array (
    'providers' => 
    array (
      0 => 'Botble\\Base\\Providers\\BaseServiceProvider',
      1 => 'Botble\\Base\\Providers\\CommandServiceProvider',
      2 => 'Botble\\Base\\Providers\\EventServiceProvider',
      3 => 'Botble\\Base\\Providers\\BreadcrumbsServiceProvider',
      4 => 'Botble\\Base\\Providers\\ComposerServiceProvider',
      5 => 'Botble\\Base\\Providers\\MailConfigServiceProvider',
      6 => 'Botble\\Base\\Providers\\FormServiceProvider',
      7 => 'Botble\\Support\\Providers\\SupportServiceProvider',
      8 => 'Botble\\Table\\Providers\\TableServiceProvider',
      9 => 'Botble\\ACL\\Providers\\AclServiceProvider',
      10 => 'Botble\\Dashboard\\Providers\\DashboardServiceProvider',
      11 => 'Botble\\Media\\Providers\\MediaServiceProvider',
      12 => 'Botble\\JsValidation\\Providers\\JsValidationServiceProvider',
      13 => 'Botble\\Chart\\Providers\\ChartServiceProvider',
    ),
    'aliases' => 
    array (
      'Assets' => 'Botble\\Base\\Facades\\AssetsFacade',
      'MetaBox' => 'Botble\\Base\\Facades\\MetaBoxFacade',
      'Action' => 'Botble\\Base\\Facades\\ActionFacade',
      'Filter' => 'Botble\\Base\\Facades\\FilterFacade',
      'EmailHandler' => 'Botble\\Base\\Facades\\EmailHandlerFacade',
      'Breadcrumbs' => 'Botble\\Base\\Facades\\BreadcrumbsFacade',
      'MacroableModels' => 'Botble\\Base\\Facades\\MacroableModelsFacade',
      'JsValidator' => 'Botble\\JsValidation\\Facades\\JsValidatorFacade',
    ),
  ),
  'botble/plugin-management' => 
  array (
    'providers' => 
    array (
      0 => 'Botble\\PluginManagement\\Providers\\PluginManagementServiceProvider',
    ),
  ),
  'botble/revision' => 
  array (
    'providers' => 
    array (
      0 => 'Botble\\Revision\\Providers\\RevisionServiceProvider',
    ),
  ),
  'botble/seo-helper' => 
  array (
    'providers' => 
    array (
      0 => 'Botble\\SeoHelper\\Providers\\SeoHelperServiceProvider',
    ),
    'aliases' => 
    array (
      'SeoHelper' => 'Botble\\SeoHelper\\Facades\\SeoHelperFacade',
    ),
  ),
  'botble/shortcode' => 
  array (
    'providers' => 
    array (
      0 => 'Botble\\Shortcode\\Providers\\ShortcodeServiceProvider',
    ),
  ),
  'botble/sitemap' => 
  array (
    'providers' => 
    array (
      0 => 'Botble\\Sitemap\\Providers\\SitemapServiceProvider',
    ),
  ),
  'botble/slug' => 
  array (
    'providers' => 
    array (
      0 => 'Botble\\Slug\\Providers\\SlugServiceProvider',
    ),
    'aliases' => 
    array (
      'SlugHelper' => 'Botble\\Slug\\Facades\\SlugHelperFacade',
    ),
  ),
  'botble/theme' => 
  array (
    'providers' => 
    array (
      0 => 'Botble\\Theme\\Providers\\ThemeServiceProvider',
      1 => 'Botble\\Theme\\Providers\\RouteServiceProvider',
    ),
    'aliases' => 
    array (
      'Theme' => 'Botble\\Theme\\Facades\\ThemeFacade',
      'ThemeOption' => 'Botble\\Theme\\Facades\\ThemeOptionFacade',
      'ThemeManager' => 'Botble\\Theme\\Facades\\ManagerFacade',
      'AdminBar' => 'Botble\\Theme\\Facades\\AdminBarFacade',
      'SiteMapManager' => 'Botble\\Theme\\Facades\\SiteMapManagerFacade',
    ),
  ),
  'botble/widget' => 
  array (
    'providers' => 
    array (
      0 => 'Botble\\Widget\\Providers\\WidgetServiceProvider',
    ),
    'aliases' => 
    array (
      'Widget' => 'Botble\\Widget\\Facades\\WidgetFacade',
      'WidgetGroup' => 'Botble\\Widget\\Facades\\WidgetGroupFacade',
    ),
  ),
  'intervention/image' => 
  array (
    'providers' => 
    array (
      0 => 'Intervention\\Image\\ImageServiceProvider',
    ),
    'aliases' => 
    array (
      'Image' => 'Intervention\\Image\\Facades\\Image',
    ),
  ),
  'knuckleswtf/scribe' => 
  array (
    'providers' => 
    array (
      0 => 'Knuckles\\Scribe\\ScribeServiceProvider',
    ),
  ),
  'kris/laravel-form-builder' => 
  array (
    'providers' => 
    array (
      0 => 'Kris\\LaravelFormBuilder\\FormBuilderServiceProvider',
    ),
    'aliases' => 
    array (
      'FormBuilder' => 'Kris\\LaravelFormBuilder\\Facades\\FormBuilder',
    ),
  ),
  'laravel/passport' => 
  array (
    'providers' => 
    array (
      0 => 'Laravel\\Passport\\PassportServiceProvider',
    ),
  ),
  'laravel/sail' => 
  array (
    'providers' => 
    array (
      0 => 'Laravel\\Sail\\SailServiceProvider',
    ),
  ),
  'laravel/sanctum' => 
  array (
    'providers' => 
    array (
      0 => 'Laravel\\Sanctum\\SanctumServiceProvider',
    ),
  ),
  'laravel/socialite' => 
  array (
    'providers' => 
    array (
      0 => 'Laravel\\Socialite\\SocialiteServiceProvider',
    ),
    'aliases' => 
    array (
      'Socialite' => 'Laravel\\Socialite\\Facades\\Socialite',
    ),
  ),
  'laravel/tinker' => 
  array (
    'providers' => 
    array (
      0 => 'Laravel\\Tinker\\TinkerServiceProvider',
    ),
  ),
  'laravelcollective/html' => 
  array (
    'providers' => 
    array (
      0 => 'Collective\\Html\\HtmlServiceProvider',
    ),
    'aliases' => 
    array (
      'Form' => 'Collective\\Html\\FormFacade',
      'Html' => 'Collective\\Html\\HtmlFacade',
    ),
  ),
  'maatwebsite/excel' => 
  array (
    'providers' => 
    array (
      0 => 'Maatwebsite\\Excel\\ExcelServiceProvider',
    ),
    'aliases' => 
    array (
      'Excel' => 'Maatwebsite\\Excel\\Facades\\Excel',
    ),
  ),
  'mews/purifier' => 
  array (
    'providers' => 
    array (
      0 => 'Mews\\Purifier\\PurifierServiceProvider',
    ),
    'aliases' => 
    array (
      'Purifier' => 'Mews\\Purifier\\Facades\\Purifier',
    ),
  ),
  'nesbot/carbon' => 
  array (
    'providers' => 
    array (
      0 => 'Carbon\\Laravel\\ServiceProvider',
    ),
  ),
  'nunomaduro/collision' => 
  array (
    'providers' => 
    array (
      0 => 'NunoMaduro\\Collision\\Adapters\\Laravel\\CollisionServiceProvider',
    ),
  ),
  'nunomaduro/termwind' => 
  array (
    'providers' => 
    array (
      0 => 'Termwind\\Laravel\\TermwindServiceProvider',
    ),
  ),
  'spatie/laravel-feed' => 
  array (
    'providers' => 
    array (
      0 => 'Spatie\\Feed\\FeedServiceProvider',
    ),
  ),
  'spatie/laravel-ignition' => 
  array (
    'providers' => 
    array (
      0 => 'Spatie\\LaravelIgnition\\IgnitionServiceProvider',
    ),
    'aliases' => 
    array (
      'Flare' => 'Spatie\\LaravelIgnition\\Facades\\Flare',
    ),
  ),
  'spatie/laravel-newsletter' => 
  array (
    'providers' => 
    array (
      0 => 'Spatie\\Newsletter\\NewsletterServiceProvider',
    ),
    'aliases' => 
    array (
      'Newsletter' => 'Spatie\\Newsletter\\NewsletterFacade',
    ),
  ),
  'tightenco/ziggy' => 
  array (
    'providers' => 
    array (
      0 => 'Tightenco\\Ziggy\\ZiggyServiceProvider',
    ),
  ),
  'unicodeveloper/laravel-paystack' => 
  array (
    'providers' => 
    array (
      0 => 'Unicodeveloper\\Paystack\\PaystackServiceProvider',
    ),
    'aliases' => 
    array (
      'Paystack' => 'Unicodeveloper\\Paystack\\Facades\\Paystack',
    ),
  ),
  'yajra/laravel-datatables-buttons' => 
  array (
    'providers' => 
    array (
      0 => 'Yajra\\DataTables\\ButtonsServiceProvider',
    ),
  ),
  'yajra/laravel-datatables-html' => 
  array (
    'providers' => 
    array (
      0 => 'Yajra\\DataTables\\HtmlServiceProvider',
    ),
  ),
  'yajra/laravel-datatables-oracle' => 
  array (
    'providers' => 
    array (
      0 => 'Yajra\\DataTables\\DataTablesServiceProvider',
    ),
    'aliases' => 
    array (
      'DataTables' => 'Yajra\\DataTables\\Facades\\DataTables',
    ),
  ),
);