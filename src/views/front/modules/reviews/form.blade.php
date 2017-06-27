<!-- Верстка под bootstrap -->
@php($form_id = random_int(0,999999))
<form id="form-comment-{{ $form_id }}" action="/reviews/post" method="post" class="uk-form">
    <div class="uk-grid">
        <p class="uk-width-1-1 uk-hidden-medium uk-hidden-large"><small class="text-muted">Все отзывы модерируются перед публикацией. Ваши контакты не будут
                опубликованы, они нужны только для связи с Вами администрацией магазина.</small></p>
        <div class="uk-width-1-1 uk-width-medium-4-10">
            <div class="uk-form-row">
                <input type="text" id="form-contact-name" placeholder="Ваше имя" class="uk-width-1-1"
                       name="name" value="@if(Auth::check()){{ Auth::getUser()->fio }}@endif">
                @if(Auth::check())
                    <input type="hidden" name="user_id" value="{{ Auth::getUser()->id }}">
                @endif
                <input type="hidden" name="link_name" value="{{ $link_name or '' }}">
                <input type="hidden" name="link_id" value="{{ $link_id or '' }}">
                <input type="hidden" name="url_post" value="{{ URL::current() }}">
                @if(isset($public_in_feed))
                    <input type="hidden" name="public_in_feed" value="1">
                @endif
            </div>
            <div class="uk-form-row">
                <input type="text" id="form-contact-city"
                       placeholder="Ваш город" name="city" class="uk-width-1-1" value="@if(Auth::check()){{ Auth::getUser()->city }}@endif">
            </div>
            <div class="uk-form-row">
                <input type="text" id="form-contact-contact"
                       placeholder="Ваш email или телефон" class="uk-width-1-1" name="contact" value="@if(Auth::check()){{ Auth::getUser()->email }}@endif">
            </div>
        </div>
        <div class="uk-width-1-1 uk-width-medium-6-10">
            @if( !isset($hidden_rating))
                <div class="uk-form-row">
                    <div class="uk-grid">
                        <div class="uk-width-2-10">
                            <label for="rating" class="uk-form-label">Оценка:</label>
                        </div>
                        <div class="uk-width-6-10">
                            <select name="rating" id="rating">
                                <option value="5">★★★★★ Рекомендую</option>
                                <option value="4">★★★★  Хорошо</option>
                                <option value="3">★★★   Удовлетворительно</option>
                                <option value="2">Не рекомендую</option>
                            </select>
                        </div>
                    </div>
                </div>
            @else
                <input type="hidden" name="rating" value="5">
            @endif
            <div class="uk-form-row">
                <textarea name="comment" placeholder="Ваш комментарий" rows="3" class="uk-width-1-1"></textarea>
            </div>
            <div class="uk-form-row">
                {{ csrf_field() }}
                <button class="uk-button uk-button-large uk-button-primary" type="submit">Отправить</button>
            </div>
        </div>
        <div class="uk-width-1-1 uk-hidden-small">
            <div class="uk-alert uk-alert-info">
                Все отзывы модерируются перед публикацией. Ваши контакты не будут
                    опубликованы, они нужны только для связи с Вами администрацией магазина.
            </div>
        </div>
    </div>
</form>
{!! JsValidator::formRequest('Larrock\ComponentReviews\Requests\ReviewRequest', '#form-comment-'. $form_id) !!}