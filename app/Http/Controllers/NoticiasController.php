<?php

namespace App\Http\Controllers;

use App\Events\comentarioNoticias;
use App\Events\Comentarios;
use App\Events\Publicaciones;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use mysql_xdevapi\Exception;

class NoticiasController extends Controller
{
    //

    //
    public function getNoticias(Request $r)
    {
        $data = DB::select("select p.id id,p.imagen imagen,cp.Descripcion Categoria,cp.id idcat,p.created_at created_at,p.titulo titulo,p.noticia_texto publicacion_texto
     ,count(distinct pc.id) total_comentario
     ,count(distinct pr.id_usuario,if(pr.recomendarion=1,1,null)) total_reacciones
     ,count(if(pr.id_usuario='$r->id_usuario' and pr.recomendarion>0,1,null))conto
from noticias p left join noticia_comentario pc on pc.id_noticia=p.id
                     left join noticia_recomendacion pr on p.id=pr.id_noticia
                     join categoria_noticia cp on p.Categoria=cp.id
group by p.id order by p.id desc limit 25;");
        $data2=DB::select("select * from categoria_noticia");

        return response(
            [
                "data"=>$data,
                "data2"=>$data2
            ]
        );
    }

    public function getComentarios(Request $r)
    {
        $data = DB::select("select u.id id_usuario,u.foto_perfil foto_perfil,u.name name_user,pc.id id,pc.id_usuario usuario,
       pc.comentario comentario, pc.id_noticia publicacion
from noticia_comentario pc join users u on pc.id_usuario=u.id where id_noticia='".$r->id_publicacion."'");
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

    public function postNoticias(Request $r)
    {
         if(isset($r->id) and !empty($r->id)){
             //primero asignamos el request a una variable asi
             $archivos = $r->file('files');
             $filename=null;
             $url=null;
             $usuario=auth()->id();
             if (isset($archivos)) {
                 $url=asset('/storage/imagenes_noticias/');
                 //$url='https://octaconc.com/home/octaconc/public_html/storage/imagenes_noticias/';

                 foreach ($archivos as $archivo) {
                     /*SUBIDA DE IMAGENES
                     en este apartado lo estaremos moviendo a la carpeta local
                     */
                     $aux = explode('.', $archivo->getClientOriginalName());
                     $filename = $aux[0] . '-' . rand(0, 100) . '-' . date("Y-m-d_H:i:s") . '.' . $archivo->getClientOriginalExtension();
                     \Storage::disk('imagenes_noticias')->put($filename, \File::get($archivo));
                     /*FIN SUBIDA DE IMAGENES*/
                     $filename=$url.'/'.$filename;
                 }
             }

            DB::update("update noticias set titulo='".$r->titulo."',noticia_texto='".$r->texto."',categoria='".$r->categoria."'
            /*, imagen='".$filename."'*/ where id='".$r->id."'");
            return 'modificado';
        }else{
            //primero asignamos el request a una variable asi
            $archivos = $r->file('files');
            $filename=null;
            $url=null;
            $usuario=auth()->id();
            if (isset($archivos)) {
               $url=asset('/storage/imagenes_noticias/');
            //$url='https://octaconc.com/home/octaconc/public_html/storage/imagenes_noticias/';

                foreach ($archivos as $archivo) {
                    /*SUBIDA DE IMAGENES
                    en este apartado lo estaremos moviendo a la carpeta local
                    */
                    $aux = explode('.', $archivo->getClientOriginalName());
                    $filename = $aux[0] . '-' . rand(0, 100) . '-' . date("Y-m-d_H:i:s") . '.' . $archivo->getClientOriginalExtension();
                    \Storage::disk('imagenes_noticias')->put($filename, \File::get($archivo));
                    /*FIN SUBIDA DE IMAGENES*/
                    $filename=$url.'/'.$filename;
                }
            }
            if (isset($r->titulo) and !empty($r->titulo )){
                try {
                    DB::insert("insert into noticias values (null,'".Auth::user()->id."','".$filename."','".$r->titulo."','".$r->texto."','".$r->categoria."',now(),null)");
                    return 'noticia hecha';

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
        DB::insert("insert into noticia_comentario values(null,'".$id_publicacion."',$id_usuario,'".$comentario."','".$fecha_actual."',null)");
        $comentarios['foto_perfil'] = $r->foto_perfil;
        $comentarios['name_user'] =  $r->nombre_usuario;
        $comentarios['comentario'] =  $comentario;
        $success = event(new comentarioNoticias($comentarios));

        return $success;
    }
    public function postRecomendacion(Request $r)
    {
        $fecha_actual=now();

        $reaccion=null;
        $data=DB::select("select * from noticia_recomendacion where id_usuario='".$r->id_usuario."'
        and id_noticia='".$r->id_publicacion."'");
        if ($data!=null){
            foreach ($data as $row){
                $reaccion=$row->id_usuario;
            }
        }
        if ($reaccion<0 || empty($reaccion) || $reaccion==null || $reaccion==''){
            $id_publicacion=$r->id_publicacion;
            $id_usuario=$r->id_usuario;
            $recomendacion=$r->recomendacion;
            DB::insert("insert into noticia_recomendacion values(null,'".$id_publicacion."','".$id_usuario."','".$recomendacion."','".$fecha_actual."',null)");
            return 1;
        }else{
            $eval=DB::select("select * from noticia_recomendacion where id_usuario='".$r->id_usuario."'
                                     and id_noticia='".$r->id_publicacion."'");
            $recomendacion=null;
            foreach ($eval as $ev){
                $recomendacion=$ev->recomendarion;
            }
            if ($recomendacion<=0){
                $recomendacion=1;
            }else{
                $recomendacion=0;
            }
            DB::update("update noticia_recomendacion set
recomendarion='".$recomendacion."', updated_at='".$fecha_actual."' where id_noticia='".$r->id_publicacion."' and id_usuario='".$r->id_usuario."'");
            return $recomendacion;
        }
    }

    public function deleteNoticias(Request $r)
    {
        DB::delete("delete from noticias where id='".$r->id."'");
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
