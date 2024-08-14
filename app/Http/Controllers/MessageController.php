<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class MessageController extends Controller
{
    public function show()
    {
        return response()->json(Message::all());
    }

    public function send(Request $request)
    {
        $valid = Validator::make($request->all(), [
            'title' => ['required', 'max:25'],
            'text' => ['required', 'max:255']
        ], [
            'required' => 'Поле обязательное',
            'max' => 'Слишком много символ'
        ]);

        if ($valid->fails()) {
            return response()->json($valid->errors(), 422);
        }
        if ($this->isOnline()){
            $message_data = [
                'recipient'=>$request->email,
                'fromEmail'=>'anisimov.vadim.alexeevich@gmail.com',
                'fromName'=>'PPMS-Center',
                'subject'=>$request->title,
                'body'=>$request->text,
                'userBody'=>$request->user_message,
            ];
            Mail::send('email-template', $message_data, function ($message) use ($message_data){
                $message->to($message_data['recipient'])
                    ->from($message_data['fromEmail'],  $message_data['fromName'])
                    ->subject($message_data['subject']);
            });
            return response()->json('Сообщение успешно отправлено', 200);
        }else{
            return response()->json('Проверьте подключение к интернету', 500);
        }
    }

    public function isOnline($site = 'https://www.youtube.com')
    {
        if (@fopen($site, "r")) {
            return true;
        } else {
            return false;
        }

    }

    public function create(Request $request)
    {
        $valid = Validator::make($request->all(), [
            'name' => ['required', 'string', 'min:2', 'max:15'],
            'email' => ['required', 'email:dns,rfc'],
            'comment' => ['required', 'max:255']
        ],
            [
                'required' => 'Поле обязательное',
                'email' => 'Введите эл.почту (например, expamle@example.com)',
                'min' => 'Минимальное количество знаков 2',
                'max' => 'Слишком большой текст (Максимум 255 знаков)'
            ]);
        if ($valid->fails()) {
            return response()->json($valid->errors());
        }
        Message::query()->create([
            'name' => $request->name,
            'email' => $request->email,
            'comment' => $request->comment,
        ]);
        return response()->json('Сообщение успешно отправлено!', 200);
    }
}
