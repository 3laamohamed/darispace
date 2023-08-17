@php
    Theme::set('navStyle', 'light');
    $avatar = $investor->image ? RvMedia::getImageUrl($investor->image, 'thumb') : $investor->image;
    $projects=$projects->where('status','!=','not_available');
@endphp

{!! Theme::partial('breadcrumb') !!}

<div class="container z-10 -mt-12 lg:-mt-16">
    <div class="block bg-white rounded-lg shadow-2xl md:flex dark:bg-slate-900">
        <div class="flex-[1] md:mr-2 p-4">
            <img src="{{ $avatar }}" alt="{{ $investor->name }}" class="w-full rounded-lg">
        </div>
        <div class="py-4 px-6 w-full flex-[3]">
            <h2 class="text-2xl font-semibold">{{ $investor->name }}</h2>
            <hr class="my-4">
            <p>{!! BaseHelper::clean($investor->disc) !!}</p>
            <ul class="mt-5 space-y-2">
                <li>
                    <i class="mr-1 text-xl mdi mdi-home-outline"></i>
                    <span>
                        @php($projectsCount = $investor->projects->where('status','!=','not_available')->count())
                        @if($projectsCount === 1)
                            {{ __(':count project', ['count' => number_format($projectsCount)]) }}
                        @else
                            {{ __(':count projects', ['count' => number_format($projectsCount)]) }}
                        @endif
                    </span>
                </li>
                @if($investor->email)
                    <li class="hover:text-primary">
                        <i class="mr-1 mdi mdi-email-outline"></i>
                        @if(setting('real_estate_hide_agency_email', 0))
                            <span>{{ Str::mask($investor->email, '*', 4, -4) }}</span>
                        @else
                            <a href="mailto:{{ $investor->email }}">{{ $investor->email }}</a>
                        @endif
                    </li>
                @endif
                @if($investor->phone)
                    <li class="hover:text-primary">
                        <i class="mr-1 mdi mdi-phone-outline"></i>
                        @if(setting('real_estate_hide_agency_phone', 0))
                            <span>{{ Str::mask($investor->phone, '*', 3, -3) }}</span>
                        @else
                            <a href="tel:{{ $investor->phone }}" dir="ltr">{{ $investor->phone }}</a>
                        @endif
                    </li>
                @endif
            </ul>
        </div>
    </div>
    <div class="pt-10">
        @if ($projects->count())
            <div class="mx-3 mt-10 mb-5">
                <h5 class="pb-3 text-xl font-bold border-b border-gray-300">{{ __('Projects by this investor') }}</h5>
                {!! Theme::partial('real-estate.projects.items', ['projects' => $projects]) !!}
            </div>
        @endif
    </div>
</div>
