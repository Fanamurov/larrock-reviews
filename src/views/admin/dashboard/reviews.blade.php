<div class="uk-margin-bottom uk-width-1-1 uk-width-1-4@m">
    <h4 class="panel-p-title"><a href="/admin/{{ $component->name }}">{{ $component->title }}</a></h4>
    <div class="uk-card uk-card-default uk-card-small">
        <div class="uk-card-body">
            @if(count($data) > 0)
                <ul class="uk-list">
                    @foreach($data as $value)
                        <li>
                            <a href="/admin/{{ $component->name }}/{{ $value->id }}/edit">{{ $value->name }} {{ $value->city }}</a>
                            <span class="uk-text-muted uk-text-small">{{ $value->user_rating }}</span>
                            @if($value->public_in_feed)
                                <a target="_blank" href="{{ $value->full_url }}"><span uk-icon="icon: link"></span></a>
                            @endif
                            <div>
                                <span class="uk-text-small">{{ \Carbon\Carbon::parse($value->updated_at)->format('d M Y') }}</span>
                                @if( !empty($value->answer))
                                    <span class="uk-label uk-label-success">Ответ есть</span>
                                @else
                                    <span class="uk-label uk-label-warning">Ответа еще нет</span>
                                @endif
                                @if($value->active !== 1)
                                    <span class="uk-label uk-label-danger">Не опубликован</span>
                                @endif
                            </div>
                        </li>
                    @endforeach
                </ul>
            @else
                <p>Отзывов еще нет</p>
            @endif
            <p>
                <a href="/admin/{{ $component->name }}/create" class="uk-button uk-button-default uk-width-1-1">Создать отзыв</a>
            </p>
        </div>
    </div>
</div>