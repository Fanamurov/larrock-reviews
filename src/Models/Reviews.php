<?php

namespace Larrock\ComponentReviews\Models;

use Larrock\ComponentReviews\Facades\LarrockReviews;
use Larrock\ComponentUsers\Facades\LarrockUsers;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMedia;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMediaConversions;
use Nicolaslopezj\Searchable\SearchableTrait;

class Reviews extends Model implements HasMediaConversions
{
    use SearchableTrait;

    protected $searchable = [
        'columns' => [
            'reviews.name' => 10
        ]
    ];

    use HasMediaTrait;

    public function registerMediaConversions()
    {
        $this->addMediaConversion('110x110')
            ->setManipulations(['w' => 110, 'h' => 110])
            ->performOnCollections('images');

        $this->addMediaConversion('140x140')
            ->setManipulations(['w' => 140, 'h' => 140])
            ->performOnCollections('images');
    }

    protected $table = 'reviews';

    protected $fillable = ['user_id', 'name', 'link_name', 'link_id', 'city', 'comment', 'answer',
        'answer_author', 'rating', 'active', 'contact', 'url_post', 'public_in_feed', 'date'];

    protected $casts = [
        'active' => 'integer',
        'public_in_feed' => 'integer',
        'rating' => 'integer'
    ];

    protected $appends = [
        'user_rating',
        'answer_author_info'
    ];

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
        if( !empty($this->answer_author) && $get_user = User::whereId($this->answer_author)->first()){
            if( !empty($get_user->fio)){
                return $get_user->fio .' ('. env('SITE_NAME', 'администрация сайта') .')';
            }
            return $get_user->first_name .' '. $get_user->last_name .' ('. env('SITE_NAME', 'администрация сайта') .')';
        }
        return 'Аноним';
    }

    public function getImages()
    {
        return $this->hasMany('Spatie\MediaLibrary\Media', 'model_id', 'id')->where('model_type', '=', LarrockReviews::getModelName())->orderBy('order_column', 'DESC');
    }
    public function getFirstImage()
    {
        return $this->hasOne('Spatie\MediaLibrary\Media', 'model_id', 'id')->where('model_type', '=', LarrockReviews::getModelName())->orderBy('order_column', 'DESC');
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
