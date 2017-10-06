@if(count($reviews) > 0)
    <div class="uk-width-1-1">
        <section id="reviews" class="uk-margin-large-top uk-margin-bottom">
            @php
                $datetime1 = new DateTime('2016-11-22');
                $datetime2 = new DateTime(date('Y-m-d'));
                $interval = $datetime1->diff($datetime2);
                $counter = 348 + (35*$interval->format('%R%a'));
            @endphp
            <p class="uk-h2 uk-text-center">Уже <i>{{ $counter }}</i> довольных клиентов<br/>были обслужены нами</p>
            <div class="uk-push-1-5 uk-width-4-5 uk-width-small-4-5 uk-width-medium-3-5">
                <div class="uk-slidenav-position" data-uk-slideset="{default: 1; autoplay: true}">
                    <ul class="uk-grid uk-slideset @if(Request::get('_key') === '1') no-action @endif" id="reviews-grid">
                        @foreach($reviews as $item)
                            <li class="@if($loop->first) uk-active @endif">
                                {!! $item->comment !!}
                                @level(2) <a class="admin_edit" href="/admin/reviews/{{ $item['id'] }}/edit">Edit element</a> @endlevel
                                <p class="uk-text-right"><em>{{ $item->name }}</em></p>
                            </li>
                        @endforeach
                    </ul>

                    <a href="" class="uk-slidenav uk-slidenav-previous uk-hidden-small" data-uk-slideset-item="назад"></a>
                    <a href="" class="uk-slidenav uk-slidenav-next uk-hidden-small" data-uk-slideset-item="дальше"></a>
                    <ul class="uk-slideset-nav uk-dotnav uk-flex-center"></ul>
                </div>
            </div>
        </section>
    </div>
@endif

@push('scripts')
    <script src="/_assets/bower_components/uikit/js/components/slideset.min.js"></script>
@endpush