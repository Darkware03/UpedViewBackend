<?php

namespace App\Http\Controllers;

use App\Events\Comentarios;
use App\Events\Publicaciones;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PHPUnit\Util\Exception;

class Ci2Publicaciones extends Controller
{
    //
    public function getPublicaciones(Request $r)
    {
        $data = DB::select("select p.imagen imagen,p.id id,p.imagen imagen,cp.Descripcion Categoria,cp.id idcat,p.created_at created_at,p.titulo titulo,p.publicacion_texto publicacion_texto
     ,count(distinct pc.id) total_comentario
     ,count(distinct pr.id_usuario,if(pr.recomendacion=1,1,null)) total_reacciones
     ,count(if(pr.id_usuario='$r->id_usuario' and pr.recomendacion>0,1,null))conto
from publicaciones p left join publicacion_comentario pc on pc.id_publicacion=p.id
left join publicacion_recomendaciones pr on p.id=pr.id_publicacion
join categoria_publicacion cp on p.Categoria=cp.id
group by p.id order by p.id desc limit 25;");
        $data2=DB::select("select * from categoria_publicacion");
        return response(
            [
                "data"=>$data,
                "data2"=>$data2
            ]
        );
    }

    public function getComentarios(Request $r)
    {
        $data = DB::select("select u.id id_usuario,u.foto_perfil foto_perfil,u.name name_user,pc.id id,pc.id_usuario usuario, pc.comentario comentario, pc.id_publicacion publicacion
from publicacion_comentario pc join users u on pc.id_usuario=u.id where id_publicacion='".$r->id_publicacion."'");
        return response(
            [
                "data"=>$data,
            ]
        );
    }
    public function getRecomendacion(Request $r)
    {
        $data = DB::select("select * from publicacion_recomendaciones;");
        return response(
            [
                "data"=>$data,
            ]
        );
    }

    public function aggPublicaciones(Request $r)
    {
        try {
            //primero asignamos el request a una variable asi
            $archivos = $r->file('files');
            $filename=null;
            $url=null;
            $usuario=auth()->id();
            if (isset($archivos)) {
                //$url='https://octaconc.com/home/octaconc/public_html/storage/imagenes_publicaciones/';
                 $url=asset('/storage/imagenes_publicaciones/');
                foreach ($archivos as $archivo) {
                    /*SUBIDA DE IMAGENES
                    en este apartado lo estaremos moviendo a la carpeta local
                    */
                    $aux = explode('.', $archivo->getClientOriginalName());
                    $filename = $aux[0] . '-' . rand(0, 100) . '-' . date("Y-m-d_H:i:s") . '.' . $archivo->getClientOriginalExtension();
                    \Storage::disk('imagenes_publicaciones')->put($filename, \File::get($archivo));
                    /*FIN SUBIDA DE IMAGENES*/
                    $filename=$url.'/'.$filename;
                }
            }
            if (isset($r->id) and !empty($r->id)){
                DB::update("update publicaciones set titulo='".$r->titulo."',publicacion_texto='".$r->texto."',categoria='".$r->categoria."'
                /*,imagen='".$filename."'*/ where id='".$r->id."'");
                return 'modificado';
            }else{
                //primero asignamos el request a una variable asi
                $archivos = $r->file('files');
                $filename=null;
                $url=null;
                $usuario=auth()->id();
                if (isset($archivos)) {
                    //$url='https://octaconc.com/home/octaconc/public_html/storage/imagenes_publicaciones/';
                    $url=asset('/storage/imagenes_publicaciones/');
                    foreach ($archivos as $archivo) {
                        /*SUBIDA DE IMAGENES
                        en este apartado lo estaremos moviendo a la carpeta local
                        */
                        $aux = explode('.', $archivo->getClientOriginalName());
                        $filename = $aux[0] . '-' . rand(0, 100) . '-' . date("Y-m-d_H:i:s") . '.' . $archivo->getClientOriginalExtension();
                        \Storage::disk('imagenes_publicaciones')->put($filename, \File::get($archivo));
                        /*FIN SUBIDA DE IMAGENES*/
                        $filename=$url.'/'.$filename;
                    }
                }
                if (isset($r->titulo) and !empty($r->titulo )){
                    DB::insert("insert into publicaciones values (null,'".Auth::user()->id."','".$filename."','".$r->titulo."','".$r->texto."'
                    ,'".$r->categoria."',null,now(),null)");

                    return 'Publicacion hecha';
                }
                else {
                    return 'nel';
                }
            }
        }catch (Exception $e){
            return $e;
        }
    }
    public function postComentarios(Request $r)
    {
        $fecha_actual=now();
        $id_publicacion=$r->id_publicacion;
        $id_usuario=$r->id_usuario;
        $comentario=$r->comentario;
       DB::insert("insert into publicacion_comentario values(null,'".$id_publicacion."',$id_usuario,'".$comentario."','".$fecha_actual."',null)");
        $comentarios['foto_perfil'] = $r->foto_perfil;
        $comentarios['name_user'] =  $r->nombre_usuario;
        $comentarios['comentario'] =  $comentario;
        $success = event(new Comentarios($comentarios));

        return 'comentario insertado';
    }
    public function postRecomendacion(Request $r)
    {
        $fecha_actual=now();

        $reaccion=null;
        $data=DB::select("select * from publicacion_recomendaciones where id_usuario='".$r->id_usuario."'
        and id_publicacion='".$r->id_publicacion."'");
        if ($data!=null){
            foreach ($data as $row){
                $reaccion=$row->id_usuario;
            }
        }
        if ($reaccion<0 || empty($reaccion) || $reaccion==null){
            $id_publicacion=$r->id_publicacion;
            $id_usuario=$r->id_usuario;
            $recomendacion=$r->recomendacion;
            DB::insert("insert into publicacion_recomendaciones values(null,'".$id_publicacion."','".$id_usuario."','".$recomendacion."','".$fecha_actual."',null)");
            return 1;
        }else{
            $eval=DB::select("select * from publicacion_recomendaciones where id_usuario='".$r->id_usuario."'
                                     and id_publicacion='".$r->id_publicacion."'");
            $recomendacion=null;
            foreach ($eval as $ev){
                $recomendacion=$ev->recomendacion;
            }
            if ($recomendacion<=0){
                $recomendacion=1;
            }else{
                $recomendacion=0;
            }
            DB::update("update publicacion_recomendaciones set
recomendacion='".$recomendacion."', updated_at='".$fecha_actual."' where id_publicacion='".$r->id_publicacion."'and id_usuario='".$r->id_usuario."'");
            return $recomendacion;
        }
    }

    public function delPublicaciones(Request $r)
    {
        DB::delete("delete from publicaciones where id='".$r->id."'");
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

    public function getcomentariospublicacion(Request $r){
        $data=DB::select("select comentario,name,titulo
                                from publicacion_comentario pc join users u on pc.id_usuario=u.id
                                join publicaciones p on p.id=pc.id_publicacion;");
        return $data;
    }
}
