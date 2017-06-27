<?php

namespace Larrock\ComponentReviews;

use Larrock\ComponentReviews\Models\Reviews;
use Larrock\ComponentUsers\Models\User;
use Larrock\Core\Component;
use Larrock\Core\Helpers\FormBuilder\FormCheckbox;
use Larrock\Core\Helpers\FormBuilder\FormDate;
use Larrock\Core\Helpers\FormBuilder\FormInput;
use Larrock\Core\Helpers\FormBuilder\FormSelect;
use Larrock\Core\Helpers\FormBuilder\FormSelectKey;
use Larrock\Core\Helpers\FormBuilder\FormTags;
use Larrock\Core\Helpers\FormBuilder\FormTextarea;

class ReviewsComponent extends Component
{
    public function __construct()
    {
        $this->name = $this->table = 'reviews';
        $this->title = 'Отзывы';
        $this->description = 'Отзывы к материалам, каталогу, корзине и т.д.';
        $this->model = Reviews::class;
        $this->active = TRUE;
        $this->addRows()->addActive()->isSearchable()->addPlugins();
    }

    protected function addPlugins()
    {
        $this->addPluginImages()->addPluginFiles();
        return $this;
    }

    protected function addRows()
    {
        $row = new FormInput('name', 'Имя комментатора');
        $this->rows['name'] = $row->setValid('max:255|required')->setInTableAdmin();

        $row = new FormInput('city', 'Город комментатора');
        $this->rows['city'] = $row->setValid('max:255');

        $row = new FormInput('contact', 'Контакты');
        $this->rows['contact'] = $row->setValid('max:255');

        $row = new FormTextarea('comment', 'Комментарий');
        $this->rows['description'] = $row->setTypo()->setValid('required')->setInTableAdmin();

        $row = new FormSelectKey('rating', 'Оценка');
        $this->rows['rating'] = $row->setOptions(['5' => '★★★★★ Рекомендую', '4' => '★★★★ Хорошо',
            '3' => '★★★ Удовлетворительно', '2' => '★★ Не рекомендую', '1' => '★ Ужасно'])->setValid('required')->setInTableAdmin();

        $row = new FormCheckbox('public_in_feed', 'Опубликован на странице Отзывы');
        $this->rows['public_in_feed'] = $row->setDefaultValue(0);

        $row = new FormDate('date', 'Дата комментария');
        $this->rows['date'] = $row->setTab('other', 'Дата, вес, активность');

        $row = new FormTags('user_id', 'ID посетителя на сайте');
        $this->rows['user_id'] = $row->setConnect(User::class, 'get_user')->setMaxItems(1);

        $row = new FormTags('answer_author', 'Кто отвечает');
        $this->rows['answer_author'] = $row->setConnect(User::class, 'get_userAnswer')->setMaxItems(1);

        $row = new FormTextarea('answer', 'Ответ');
        $this->rows['answer'] = $row->setTypo()->setInTableAdmin();

        return $this;
    }

    public function renderAdminMenu()
    {
        $count = \Cache::remember('count-data-admin-'. $this->name, 1440, function(){
            return Reviews::count(['id']);
        });
        return view('larrock::admin.sectionmenu.types.default', ['count' => $count, 'app' => $this, 'url' => '/admin/'. $this->name]);
    }

    public function createSitemap()
    {
        //return Reviews::whereActive(1)->get();
    }
}