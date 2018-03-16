@extends('larrock::emails.template.body')

@section('content')
	<h1 style="font:26px/32px Calibri,Helvetica,Arial,sans-serif;">Отправлен отзыв</h1>
	<p style="font:14px/16px Calibri,Helvetica,Arial,sans-serif;"><strong>Имя:</strong> {{ $name }}</p>
	<p style="font:14px/16px Calibri,Helvetica,Arial,sans-serif;"><strong>Город:</strong> {{ $city }}</p>
	<p style="font:14px/16px Calibri,Helvetica,Arial,sans-serif;"><strong>Контакты:</strong> {{ $contact }}</p>
	<p style="font:14px/16px Calibri,Helvetica,Arial,sans-serif;"><strong>Оценка:</strong> {{ $rating }}</p>
	<p style="font:14px/16px Calibri,Helvetica,Arial,sans-serif;"><strong>Комментарий:</strong> {{ $comment }}</p>
	<p style="font:14px/16px Calibri,Helvetica,Arial,sans-serif;"><strong>Ссылка на страницу где оставлен комментарий:</strong> <a href="{{ $url_post }}" target="_blank">{{ $url_post }}</a> </p>
@endsection

@section('footer')
    @include('larrock::emails.template.footer')
@endsection