<?php

namespace App\Http\Controllers;

use App\Events\comentarioNoticias;
use App\Events\comentariosEventos;
use App\Events\Publicaciones;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use mysql_xdevapi\Exception;

class eventosController extends Controller
{
    //

    public function geteventos(Request $r)
    {
        $data = DB::select("select p.id id,p.imagen imagen,p.imagen imagen,p.created_at created_at,p.titulo titulo,p.evento_texto publicacion_texto,p.fecha_evento,p.lugar lugar
     ,count(distinct pc.id) total_comentario,SUBSTRING(p.evento_texto,1,30) resumen
     ,count(distinct pr.id_usuario,if(pr.recomendarion=1,1,null)) total_reacciones
     ,count(if(pr.id_usuario='$r->id_usuario' and pr.recomendarion>0,1,null))conto
from eventos p left join evento_comentario pc on pc.id_evento=p.id
                left join evento_recomendacion pr on p.id=pr.id_evento
group by p.id order by p.id desc limit 25;");

        $data2=DB::select("select e.titulo,e.lugar,count(if(ev.recomendarion=1,1,null))total_asistencias
from eventos e join evento_recomendacion ev on e.id=ev.id_evento group by e.id;");
        return response(
            [
                "data"=>$data,
                "data2"=>$data2,
            ]
        );
    }

    public function getComentarios(Request $r)
    {
        $data = DB::select("select u.id id_usuario,u.foto_perfil foto_perfil,u.name name_user,pc.id id,pc.id_usuario usuario,
       pc.comentario comentario, pc.id_evento publicacion
from evento_comentario pc join users u on pc.id_usuario=u.id where id_evento='".$r->id_publicacion."'");
        return response(
            [
                "data"=>$data,
            ]
        );
    }
    public function getRecomendacion(Request $r)
    {
        $data = DB::select("select * from noticia_recomendacion;");
        return response(
            [
                "data"=>$data,
            ]
        );
    }

    public function posteventos(Request $r)
    {
        if(isset($r->id) and !empty($r->id)){
            //primero asignamos el request a una variable asi
            $archivos = $r->file('files');
            $filename=null;
            $url=null;
            $usuario=auth()->id();
            if (isset($archivos)) {
                 $url=asset('/storage/imagenes_eventos/');
              //  $url='https://octaconc.com/home/octaconc/public_html/storage/imagenes_eventos/';

                foreach ($archivos as $archivo) {
                    /*SUBIDA DE IMAGENES
                    en este apartado lo estaremos moviendo a la carpeta local
                    */
                    $aux = explode('.', $archivo->getClientOriginalName());
                    $filename = $aux[0] . '-' . rand(0, 100) . '-' . date("Y-m-d_H:i:s") . '.' . $archivo->getClientOriginalExtension();
                    \Storage::disk('imagenes_eventos')->put($filename, \File::get($archivo));
                    /*FIN SUBIDA DE IMAGENES*/
                    $filename=$url.'/'.$filename;
                }
            }
            DB::update("update eventos set titulo='".$r->titulo."',evento_texto='".$r->texto."',fecha_evento='".$r->fecha_evento."',lugar='".$r->lugar."'
            /*,imagen='".$filename."'*/ where id='".$r->id."'");
            return 'modificado';
        }else{
            //primero asignamos el request a una variable asi
            $archivos = $r->file('files');
            $filename=null;
            $url=null;
            $usuario=auth()->id();
            if (isset($archivos)) {
                $url=asset('/storage/imagenes_eventos/');
               // $url='https://octaconc.com/home/octaconc/public_html/storage/imagenes_eventos/';

                foreach ($archivos as $archivo) {
                    /*SUBIDA DE IMAGENES
                    en este apartado lo estaremos moviendo a la carpeta local
                    */
                    $aux = explode('.', $archivo->getClientOriginalName());
                    $filename = $aux[0] . '-' . rand(0, 100) . '-' . date("Y-m-d_H:i:s") . '.' . $archivo->getClientOriginalExtension();
                    \Storage::disk('imagenes_eventos')->put($filename, \File::get($archivo));
                    /*FIN SUBIDA DE IMAGENES*/
                    $filename=$url.'/'.$filename;
                }
            }
            if (isset($r->titulo) and !empty($r->titulo )){
                try {
                    DB::insert("insert into eventos values (null,'".Auth::user()->id."','".$filename."','".$r->titulo."','".$r->texto."',
                    '".$r->lugar."','".$r->fecha_evento."',now(),null)");
                    $subtitulo=$r->titulo;
                    $titulo='Nuevo Evento - '.$subtitulo;
                    $mensaje=$r->texto;
                    $notificacion=new Notificaciones;
                    $notificacion->sendMessage($mensaje,$titulo);
                    return 'creado';

                }catch (Exception $e){
                    return $e;

                }
            }
        }

    }
    public function postComentarios(Request $r)
    {
        $fecha_actual=now();
        $id_publicacion=$r->id_publicacion;
        $id_usuario=$r->id_usuario;
        $comentario=$r->comentario;
        DB::insert("insert into evento_comentario values(null,'".$id_publicacion."',$id_usuario,'".$comentario."','".$fecha_actual."',null)");
        $comentarios['foto_perfil'] = $r->foto_perfil;
        $comentarios['name_user'] =  $r->nombre_usuario;
        $comentarios['comentario'] =  $comentario;
        $success = event(new comentariosEventos($comentarios));

        return $success;
    }
    public function postRecomendacion(Request $r)
    {
        $fecha_actual=now();

        $reaccion=null;
        $data=DB::select("select * from evento_recomendacion where id_usuario='".$r->id_usuario."'
        and id_evento='".$r->id_publicacion."'");
        if ($data!=null){
            foreach ($data as $row){
                $reaccion=$row->id_usuario;
            }
        }
        if ($reaccion<0 || empty($reaccion) || $reaccion==null){
            $id_publicacion=$r->id_publicacion;
            $id_usuario=$r->id_usuario;
            $recomendacion=$r->recomendacion;
            DB::insert("insert into evento_recomendacion values(null,'".$id_publicacion."','".$id_usuario."','".$recomendacion."','".$fecha_actual."',null)");
            return 1;
        }else{
            $eval=DB::select("select * from evento_recomendacion where id_usuario='".$r->id_usuario."'
                                     and id_evento='".$r->id_publicacion."'");
            $recomendacion=null;
            foreach ($eval as $ev){
                $recomendacion=$ev->recomendarion;
            }
            if ($recomendacion<=0){
                $recomendacion=1;
            }else{
                $recomendacion=0;
            }
            DB::update("update evento_recomendacion set
recomendarion='".$recomendacion."', updated_at='".$fecha_actual."' where id_evento='".$r->id_publicacion."'and id_usuario='".$r->id_usuario."'");
            return $recomendacion;
        }
    }

    public function deleteEventos(Request $r)
    {
        DB::delete("delete from eventos where id='".$r->id."'");
        return 'eliminado';
    }
    public function evento(Request $r)
    {
        $message['user'] = $r->usuario;
        $message['message'] =  $r->mensaje;
        $message['notificacion'] =  1;
        $success = event(new Publicaciones($message));
        return "siiiiiiiii";
    }



}
