<?php

namespace App\Http\Controllers\Main\Frontend;

use App\Events\MessageEvent;
use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Meta;

/**
 * Class IndexController
 * @package Application\Controllers
 */
class IndexController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        Meta::set('title', 'You are at home');
        Meta::set('description', 'This is my home. Enjoy!');
        Meta::set('image', asset('images/home-logo.png'));

        return view('main.frontend.index.home');
    }


    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function feedback(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'message' => 'required',
        ],[
            'required' => 'Поле обязательно для заполнения'
        ]);

        $message = Message::create($request->all());

        event(new MessageEvent($message));

        return response()->json(['success' => true, 'msg' => 'Сообщение отправлено']);
    }
}