<?php

namespace Larrock\ComponentReviews;

use Cache;
use LarrockReviews;
use Larrock\Core\Component;
use Larrock\ComponentUsers\Models\User;
use Larrock\ComponentReviews\Models\Reviews;
use Larrock\Core\Helpers\FormBuilder\FormDate;
use Larrock\Core\Helpers\FormBuilder\FormTags;
use Larrock\Core\Helpers\FormBuilder\FormInput;
use Larrock\Core\Helpers\FormBuilder\FormCheckbox;
use Larrock\Core\Helpers\FormBuilder\FormTextarea;
use Larrock\Core\Helpers\FormBuilder\FormSelectKey;

class ReviewsComponent extends Component
{
    public function __construct()
    {
        $this->name = $this->table = 'reviews';
        $this->title = 'Отзывы';
        $this->description = 'Отзывы к материалам, каталогу, корзине и т.д.';
        $this->model = \config('larrock.models.reviews', Reviews::class);
        $this->addRows()->addActive()->isSearchable()->addPlugins();
    }

    protected function addPlugins()
    {
        return $this->addPluginImages()->addPluginFiles();
    }

    protected function addRows()
    {
        $row = new FormInput('name', 'Имя комментатора');
        $this->setRow($row->setValid('max:255|required')->setInTableAdmin()->setFillable());

        $row = new FormInput('city', 'Город комментатора');
        $this->setRow($row->setValid('max:255')->setFillable());

        $row = new FormInput('contact', 'Контакты');
        $this->setRow($row->setValid('max:255')->setFillable());

        $row = new FormTextarea('comment', 'Комментарий');
        $this->setRow($row->setTypo()->setValid('required')->setInTableAdmin()->setFillable());

        $row = new FormSelectKey('rating', 'Оценка');
        $this->setRow($row->setOptions(['5' => '★★★★★ Рекомендую', '4' => '★★★★ Хорошо',
            '3' => '★★★ Удовлетворительно', '2' => '★★ Не рекомендую', '1' => '★ Ужасно', ])
            ->setValid('required')->setInTableAdmin()->setFillable()
            ->setCssClassGroup('uk-width-1-2 uk-width-1-3@m'));

        $row = new FormCheckbox('public_in_feed', 'Опубликован на странице Отзывы');
        $this->setRow($row->setDefaultValue(0)->setFillable()->setCssClassGroup('uk-width-1-2 uk-width-1-3@m'));

        $row = new FormDate('date', 'Дата комментария');
        $this->setRow($row->setFillable()->setCssClassGroup('uk-width-1-2 uk-width-1-3@m'));

        $row = new FormTags('user_id', 'ID посетителя на сайте');
        $this->setRow($row->setModels(Reviews::class, User::class)->setTitleRow('name')
            ->setMaxItems(1)->setFillable()->setCssClassGroup('uk-width-1-2 uk-width-1-3@m'));

        $row = new FormTags('answer_author', 'Кто отвечает');
        $this->setRow($row->setModels(Reviews::class, User::class)
            ->setMaxItems(1)->setFillable()->setTitleRow('name'));

        $row = new FormTextarea('answer', 'Ответ');
        $this->setRow($row->setTypo()->setInTableAdmin()->setFillable());

        $row = new FormInput('link_name', 'link_name');
        $this->setRow($row->setCssClassGroup('uk-width-1-2 uk-width-1-3@m')->setFillable());

        $row = new FormInput('link_id', 'link_id');
        $this->setRow($row->setCssClassGroup('uk-width-1-2 uk-width-1-3@m')->setFillable());

        $row = new FormInput('url_post', 'url_post');
        $this->setRow($row->setCssClassGroup('uk-width-1-2 uk-width-1-3@m')->setFillable());

        return $this;
    }

    public function renderAdminMenu()
    {
        $count = Cache::rememberForever('count-data-admin-'.LarrockReviews::getName(), function () {
            return LarrockReviews::getModel()->count(['id']);
        });

        return view('larrock::admin.sectionmenu.types.default', ['count' => $count, 'app' => LarrockReviews::getConfig(),
            'url' => '/admin/'.LarrockReviews::getName(), ]);
    }

    public function toDashboard()
    {
        $data = Cache::rememberForever('LarrockReviewsItemsDashboard', function () {
            return LarrockReviews::getModel()->latest('updated_at')->take(5)->get();
        });

        return view('larrock::admin.dashboard.reviews', ['component' => LarrockReviews::getConfig(), 'data' => $data]);
    }
}
