@extends('larrock::front.main')
@section('title') Отзывы @endsection

@section('content')
    <div class="componentReviews reviews-list-container">
        <h1>Отзывы</h1>

        <div class="container-reviews-tovar">
            <div class="uk-alert uk-alert-info">
                <p class="uk-h2">Оставьте свой отзыв к нашему магазину:</p>
                @include('larrock::front.modules.reviews.form', ['link_name' => 'page', 'public_in_feed' => true])
            </div>
        </div>

        @include('larrock::front.modules.reviews.list-comments')

        {!! $list->render() !!}
    </div>
@endsection