<?php

namespace Larrock\ComponentReviews;

use App\Http\Controllers\Controller;
use Larrock\ComponentReviews\Models\Reviews;
use Larrock\ComponentReviews\Facades\LarrockReviews;
use Validator;
use Illuminate\Http\Request;
use Alert;
use Mail;

class ReviewsController extends Controller
{
    public function index()
    {
        $data['list'] = LarrockReviews::getModel()->wherePublicInFeed(1)->whereActive(1)->orderBy('date', 'DESC')->paginate(10);
        if(Auth::user()){
            $data['moderate'] = LarrockReviews::getModel()->wherePublicInFeed(1)->whereUserId(Auth::user()->id)->whereActive(0)->orderBy('date', 'DESC')->get();
        }
        return view('larrock::front.reviews.list', $data);
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

        $comment = LarrockReviews::getModel()->fill($request->all());
        $comment->date = date('Y-m-d H:s:i');
        $comment->active = 0;
        if($comment->save()){
            Alert::add('success', 'Ваш отзыв успешно отправлен, после модерации от будет опубликован')->flash();

            $mails = array_map('trim', explode(',', env('MAIL_TO_ADMIN', 'robot@martds.ru')));
            $send_data = $request->all();
            /** @noinspection PhpVoidFunctionResultUsedInspection */
            Mail::send('larrock::emails.review', $send_data,
                function($message) use ($mails){
                    $message->from('no-reply@'. array_get($_SERVER, 'HTTP_HOST'), env('MAIL_TO_ADMIN_NAME', 'ROBOT'));
                    $message->to($mails);
                    $message->subject('Отправлен отзыв '. env('SITE_NAME')
                    );
                });
        }else{
            Alert::add('danger', 'Отзыв не удалось сохранить')->flash();
        }

        return back()->withInput();
    }
}