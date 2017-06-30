<?php

namespace Larrock\ComponentReviews;

use Alert;
use Breadcrumbs;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use JsValidator;
use Larrock\ComponentReviews\Models\Reviews;
use Larrock\Core\AdminController;
use Larrock\Core\Component;
use Mail;
use Redirect;
use Validator;
use View;

class AdminReviewsController extends AdminController
{
    public function __construct()
    {
        $component = new ReviewsComponent();
        $this->config = $component->shareConfig();

        Breadcrumbs::setView('larrock::admin.breadcrumb.breadcrumb');
        Breadcrumbs::register('admin.'. $this->config->name .'.index', function($breadcrumbs){
            $breadcrumbs->push($this->config->title, '/admin/'. $this->config->name);
        });
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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

        $reviews = new Reviews();
        $reviews->fill($request->all());
        if($reviews->save()){
            Alert::add('success', 'Ваш комментарий успешно отправлен, после модерации от будет опубликован')->flash();

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
            Alert::add('danger', 'Комментарий не удалось сохранить')->flash();
        }

        //FormsLog::create(['formname' => 'comment', 'params' => $request->all(), 'status' => 'Новое']);

        return back()->withInput();
    }
}