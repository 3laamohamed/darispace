@foreach($reviews as $review)
    <div class="flex items-start border-b pb-7 border-b-slate-100 last:border-none">
        <div class="min-w-max">
            <a href="{{ $review->author->url }}">
                <img src="{{ RvMedia::getImageUrl($review->author->avatar_url, 'thumb') }}" alt="{{ $review->author->name }}" class="w-20 h-20 rounded-full">
            </a>
        </div>
        <div class="ml-5 rtl:mr-5">
            <div class="-ml-1">
                @foreach(range(1, 5) as $i)
                    <i @class(['mdi', 'mdi-star text-amber-500' => $review->star >= $i, 'mdi-star-outline text-slate-400' => $review->star < $i])></i>
                @endforeach
            </div>
            <div class="mb-2">
                <a href="{{ $review->author->url }}" class="block font-bold transition-all hover:text-primary">
                    {{ $review->author->name }}
                </a>
                <span class="text-sm text-primary">{{ $review->created_at->diffForHumans() }}</span>
            </div>
            <p>{{ $review->content }}</p>
        </div>
    </div>
@endforeach

{{ $reviews->onEachSide(1)->links(Theme::getThemeNamespace('partials.pagination')) }}
