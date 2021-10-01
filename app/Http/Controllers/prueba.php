<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class prueba extends Controller
{
    //
    public function send()
    {
        // ...

        // message is being sent
       // $message = new Message;
        $message = null;
        $message->setAttribute('from', 1);
        $message->setAttribute('to', 2);
        $message->setAttribute('message', 'Demo message from user 1 to user 2');
        //$message->save();

        // want to broadcast NewMessageNotification event
        event(new NewMessageNotification($message));

        // ...
    }
}
