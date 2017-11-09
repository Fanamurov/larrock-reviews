<?php

namespace Larrock\ComponentReviews;

use Breadcrumbs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Larrock\Core\Traits\AdminMethodsDestroy;
use Larrock\Core\Traits\AdminMethodsEdit;
use Larrock\Core\Traits\AdminMethodsIndex;
use Larrock\Core\Traits\AdminMethodsStore;
use Larrock\Core\Traits\AdminMethodsUpdate;
use Mail;
use Session;
use Validator;
use Larrock\ComponentReviews\Facades\LarrockReviews;

class AdminReviewsController extends Controller
{
    use AdminMethodsStore, AdminMethodsDestroy, AdminMethodsUpdate, AdminMethodsIndex, AdminMethodsEdit;

    public function __construct()
    {
        $this->config = LarrockReviews::shareConfig();

        \Config::set('breadcrumbs.view', 'larrock::admin.breadcrumb.breadcrumb');
        Breadcrumbs::register('admin.'. LarrockReviews::getName() .'.index', function($breadcrumbs){
            $breadcrumbs->push(LarrockReviews::getTitle(), '/admin/'. LarrockReviews::getName());
        });
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
            'user_id' => \Auth::user()->id
        ]);
        return $this->store($test);
    }

    public function post(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'city' => 'max:255',
            'rating' => 'required',
            'comment' => 'required',
        ]);
        if($validator->fails()){
            return back()->withInput($request->except('password'))->withErrors($validator);
        }

        $reviews = LarrockReviews::getModel()->fill($request->all());
        if($reviews->save()){
            Session::push('message.success', 'Ваш комментарий успешно отправлен, после модерации от будет опубликован');

            $mails = collect(array_map('trim', explode(',', env('MAIL_TO_ADMIN', 'robot@martds.ru'))));
            $send_data = $request->all();
            /** @noinspection PhpVoidFunctionResultUsedInspection */
            Mail::send('larrock::emails.review-to-admin',
                $send_data,
                function($message) use ($mails){
                    $message->from('no-reply@'. array_get($_SERVER, 'HTTP_HOST'), env('MAIL_TO_ADMIN_NAME', 'ROBOT'));
                    foreach($mails as $value){
                        $message->to($value);
                    }
                    $message->subject('Отправлен комментарий '. array_get($_SERVER, 'HTTP_HOST')
                    );
                });
        }else{
            Session::push('message.danger', 'Комментарий не удалось сохранить');
        }

        return back()->withInput();
    }
}