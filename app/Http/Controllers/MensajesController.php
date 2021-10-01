<?php

namespace App\Http\Controllers;

use App\Events\MessageSentEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MensajesController extends Controller
{
    //
    public function getMensajes(Request $r)
    {
        $consulta=DB::select("
select u.name,um.mensaje,um.para para,um.de de,DATE_FORMAT(um.fecha,\"%H:%I:%S\")fecha
from usuarios_mensajes um join users u
on u.id=um.de where de=$r->de and para=$r->para or de=$r->para and para=$r->de order by um.id asc;");
        return $consulta;
    }
    public function postMensajes(Request $r)
    {
        DB::insert("insert into usuarios_mensajes values (null,$r->de,$r->para,'".$r->mensaje."',now())");
        $data=DB::select("select date_format(now(),'%H:%m:%s') fecha;");
        $hora=null;
        foreach ($data as $item) {
            $hora=$item->fecha;
        }
        $ahora=$hora;
        $mensaje['name']=$r->name;
        $mensaje['mensaje']=$r->mensaje;
        $mensaje['fecha']=$hora;
        $mensaje['para']=$r->para;
        $mensaje['de']=$r->de;
        //$comentarios['comentario'] =  $comentario;
        //$success = event(new Comentarios($comentarios));
        //event(new MessageSentEvent($user, $message))->toOthers();
        broadcast(new MessageSentEvent($mensaje))->toOthers();
        return $hora;
    }
}
