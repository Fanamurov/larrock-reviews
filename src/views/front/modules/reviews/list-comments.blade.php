@if(isset($moderate) && count($moderate) > 0)
    <div class="comment-item comment-item-moderate uk-alert uk-alert-warning">
        <p class="uk-h2">Ваши отзывы и комментарии на модерации:</p>
        @foreach($moderate as $item)
            <div class="comment-item uk-position-relative">
                <p class="author"><span class="name">{{ $item['name'] }}</span>
                    @if( !empty($item['city']))<span class="city uk-text-muted">({{ $item['city'] }})</span>@endif
                    @if( !isset($hidden_rating))<span class="rating rating-score-{{ $item['rating'] }}">{{ $item['user_rating'] }}</span>@endif</p>
                <div class="comment">
                    {{ $item['comment'] }}
                    <span class="created_at uk-text-right uk-text-muted">{{ Carbon\Carbon::parse($item['date'])->format('d.m.Y') }}г.</span>
                </div>
                @level(2) <a class="admin_edit" href="/admin/reviews/{{ $item['id'] }}/edit">Edit element</a> @endlevel
            </div>
        @endforeach
    </div>
@endif

@if(count($list) > 0)
    @foreach($list as $item)
        <div class="comment-item uk-grid uk-position-relative">
            <p class="author uk-width-1-1"><span class="name">{{ $item['name'] }}</span>
                @if( !empty($item['city']))<span class="city uk-text-muted">({{ $item['city'] }})</span>@endif
                @if( !isset($hidden_rating))<span class="rating rating-score-{{ $item['rating'] }}">{{ $item['user_rating'] }}</span>@endif</p>
            @if(count($item->getFirstImage) > 0)
                <div class="uk-width-1-5">
                    <img src="{{ $item->getFirstImage->getUrl() }}" alt="Отзыв" class="all-width">
                </div>
                <div class="uk-width-4-5">
                    {!! $item['comment'] !!}
                </div>
            @else
                <div class="uk-width-1-1">
                    {!! $item['comment'] !!}
                </div>
            @endif
            @if( !empty($item['answer']) && $item['answer_author'])
                <div class="answer uk-push-1-6 uk-width-5-6">
                    {!! $item['answer'] !!}
                    <span class="uk-text-muted uk-text-right">{{ $item['answer_author_info'] }}</span>
                </div>
            @endif
            @level(2) <a class="admin_edit" href="/admin/reviews/{{ $item['id'] }}/edit">Edit element</a> @endlevel
        </div>
    @endforeach
@else
    <p class="uk-alert uk-alert-warning">Опубликованных отзывов пока нет, станьте первым!</p>
@endif