@extends('larrock::front.main')
@section('title') Отзывы @endsection

@section('content')
    <div class="container-comments-page comments-list-container">
        <h1>Отзывы</h1>

        <div class="container-comments-tovar">
            <div class="uk-alert auk-lert-info">
                <p class="h2">Оставьте свой отзыв к нашему магазину:</p>
                @include('larrock::front.modules.reviews.form', ['link_name' => 'page', 'public_in_feed' => true])
            </div>
        </div>

        @if(isset($moderate) && count($moderate) > 0)
            <div class="comments-list-container alert alert-warning">
                <p class="uk-h2">Ваши отзывы и комментарии на модерации:</p>
                @foreach($moderate as $item)
                    <div class="comment-item">
                        <p class="author"><span class="name">{{ $item['name'] }}</span>
                            @if( !empty($item['city']))<span class="city text-muted">/{{ $item['city'] }}</span>@endif
                            @if( !isset($hidden_rating))<span class="rating rating-score-{{ $item['rating'] }}">{{ $item['user_rating'] }}</span>@endif</p>
                        <p class="comment">
                            {{ $item['comment'] }}
                            <span class="created_at text-right text-muted">{{ Carbon\Carbon::parse($item['date'])->format('d.m.Y') }}г.</span>
                        </p>
                        @level(2)
                        <a class="admin_edit" href="/admin/comments/{{ $item['id'] }}/edit">Edit element</a>
                        @endlevel
                    </div>
                @endforeach
            </div>
        @endif

        @if(count($list) > 0)
            @foreach($list as $item)
                <div class="comment-item uk-grid">
                    <div class="author uk-width-1-1"><span class="name">{{ $item['name'] }}</span>
                        @if( !empty($item['city']))<span class="city text-muted">({{ $item['city'] }})</span>@endif
                        @if( !isset($hidden_rating))<span class="rating rating-score-{{ $item['rating'] }}">{{ $item['user_rating'] }}</span><@endif/div>
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
                        <div class="answer uk-width-1-1">{!! $item['answer'] !!}<br/><span class="text-muted text-right">{{ $item['answer_author_info'] }}</span></div>
                    @endif
                    @level(2)
                    <a class="admin_edit" href="/admin/comments/{{ $item['id'] }}/edit">Edit element</a>
                    @endlevel
                </div>
            @endforeach
        @else
            <p class="uk-alert uk-alert-warning">Опубликованных отзывов пока нет, станьте первым!</p>
        @endif

        {!! $list->render() !!}
    </div>
@endsection