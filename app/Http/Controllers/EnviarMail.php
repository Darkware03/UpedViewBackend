<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
class EnviarMail extends Controller
{
    //
    public function contact(Request $request){
        $subject = "Prueba";
        $for = "darkmetal123@outlook.com";
        Mail::send('email',$request->all(), function($msj) use($subject,$for){
            $msj->from("giovannidark@mail.com","Giovanni");
            $msj->subject($subject);
            $msj->to($for);
        });
        return 'enviado';
    }
}
