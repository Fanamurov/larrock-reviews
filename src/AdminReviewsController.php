<?php

namespace Larrock\ComponentReviews;

use LarrockReviews;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Larrock\Core\Traits\ShareMethods;
use Larrock\Core\Traits\AdminMethodsEdit;
use Larrock\Core\Traits\AdminMethodsIndex;
use Larrock\Core\Traits\AdminMethodsStore;
use Larrock\Core\Traits\AdminMethodsUpdate;
use Larrock\Core\Traits\AdminMethodsDestroy;

class AdminReviewsController extends Controller
{
    use AdminMethodsStore, AdminMethodsDestroy, AdminMethodsUpdate, AdminMethodsIndex, AdminMethodsEdit, ShareMethods;

    public function __construct()
    {
        $this->shareMethods();
        $this->middleware(LarrockReviews::combineAdminMiddlewares());
        $this->config = LarrockReviews::shareConfig();
        \Config::set('breadcrumbs.view', 'larrock::admin.breadcrumb.breadcrumb');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $test = Request::create('/admin/reviews', 'POST', [
            'title' => 'Новый материал',
            'url' => str_slug('novyy-material'),
            'active' => 0,
            'name' => 'Покупатель',
            'city' => 'Хабаровск',
            'contact' => 'без контакта',
            'public_in_feed' => 1,
            'user_id' => \Auth::user()->id,
            'comment' => 'Отзыв',
            'rating' => 5,
        ]);

        return $this->store($test);
    }
}
