<?php

namespace Larrock\ComponentReviews;

use App\Http\Controllers\Controller;
use Larrock\ComponentReviews\Models\Reviews;

class ReviewsController extends Controller
{
    public function index()
    {
        $data['list'] = Reviews::wherePublicInFeed(1)->whereActive(1)->orderBy('date', 'DESC')->paginate(10);
        $data['moderate'] = Reviews::wherePublicInFeed(1)->whereActive(0)->orderBy('date', 'DESC')->get();
        return view('larrock::front.reviews.list', $data);
    }
}
