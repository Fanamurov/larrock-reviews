@if(isset($moderate) && count($moderate) > 0)
    <div class="comments-list-container alert alert-warning">
        <p class="h2">{{ $title_moderate or 'Ваши отзывы на модерации' }}:</p>
        @foreach($moderate as $item)
            <div class="comment-item">
                <p class="author"><span class="name">{{ $item->name }}</span>
                    @if( !empty($item->city))<span class="city text-muted">/{{ $item->city }}</span>@endif
                    @if( !isset($hidden_rating))<span class="rating rating-score-{{ $item->rating }}">{{ $item->user_rating }}</span>@endif</p>
                <p class="comment">
                    {{ $item->comment }}
                    <span class="created_at text-right text-muted">{{ Carbon\Carbon::parse($item->date)->format('d.m.Y') }}г.</span>
                </p>
                @level(2)
                <a class="admin_edit" href="/admin/comments/{{ $item->id }}/edit">Edit element</a>
                @endlevel
            </div>
        @endforeach
    </div>
@endif

@if(count($data) > 0)
    <div class="comments-list-container">
        <p class="h2">{{ $title_list or 'Отзывы к товару' }}:</p>
        @foreach($data as $item)
            <div class="comment-item">
                <p class="author"><span class="name">{{ $item->name }}</span>
                    @if( !empty($item->city))<span class="city text-muted">/{{ $item->city }}</span>@endif
                    @if( !isset($hidden_rating))<span class="rating rating-score-{{ $item->rating }}">{{ $item->user_rating }}</span>@endif</p>
                <p class="comment">
                    {{ $item->comment }}
                </p>
                @if( !empty($item->answer))
                    <p class="answer">{{ $item->answer }}<br/><span class="text-muted text-right">{{ $item->answer_author_info }}</span></p>
                @endif
                @level(2)
                <a class="admin_edit" href="/admin/comments/{{ $item->id }}/edit">Edit element</a>
                @endlevel
            </div>
        @endforeach
    </div>
@endif