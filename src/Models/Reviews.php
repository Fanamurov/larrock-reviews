<?php

namespace Larrock\ComponentReviews\Models;

use Larrock\ComponentReviews\Facades\LarrockReviews;
use Larrock\ComponentUsers\Facades\LarrockUsers;
use Illuminate\Database\Eloquent\Model;
use Larrock\Core\Component;
use Larrock\Core\Traits\GetLink;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMediaConversions;
use Nicolaslopezj\Searchable\SearchableTrait;
use Larrock\Core\Traits\GetFilesAndImages;

class Reviews extends Model implements HasMediaConversions
{
    /**
     * @var $this Component
     */
    protected $config;

    use SearchableTrait;
    use GetFilesAndImages;
    use HasMediaTrait;
    use GetLink;

    protected $searchable = [
        'columns' => [
            'reviews.name' => 10
        ]
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->fillable(LarrockReviews::addFillableUserRows([]));
        $this->config = LarrockReviews::getConfig();
        $this->table = LarrockReviews::getTable();
    }

    protected $casts = [
        'active' => 'integer',
        'public_in_feed' => 'integer',
        'rating' => 'integer'
    ];

    protected $appends = [
        'user_rating',
        'answer_author_info'
    ];

    public function getConfig()
    {
        return $this->config;
    }

    public function getUserRatingAttribute()
    {
        if($this->rating === 5){
            return '★★★★★ Рекомендую';
        }
        if($this->rating === 4){
            return '★★★★ Хорошо';
        }
        if($this->rating === 3){
            return '★★★ Удовлетворительно';
        }
        if($this->rating === 2){
            return '★★ Не рекомендую';
        }
        if($this->rating === 1){
            return '★ Ужасно';
        }
        return $this->rating;
    }

    public function getAnswerAuthorInfoAttribute()
    {
        if( !empty($this->answer_author) && $get_user = LarrockUsers::getModel()->whereId($this->answer_author)->first()){
            if( !empty($get_user->fio)){
                return $get_user->fio .' ('. env('SITE_NAME', 'администрация сайта') .')';
            }
            return $get_user->first_name .' '. $get_user->last_name .' ('. env('SITE_NAME', 'администрация сайта') .')';
        }
        return 'Аноним';
    }

    public function get_user()
    {
        return $this->hasOne(LarrockUsers::getModelName(), 'id', 'user_id');
    }

    public function get_userAnswer()
    {
        return $this->hasOne(LarrockUsers::getModelName(), 'id', 'answer_author');
    }
}