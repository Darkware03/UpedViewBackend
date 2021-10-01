<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ComunicadosController extends Controller
{
    //
    public function insertarComunicado(Request $r)
    {
        $id=$r->id;
        if (isset($id) and !empty($id)){
            DB::update("update comunicados set titulo='".$r->titulo."',texo_comunicado='".$r->texto."',tipo_comunicado='".$r->categoria."',updated_at=now() where id = '".$id."'");
            return 'MODIFICADO';
        }else{
            $titulo=$r->titulo;
            $texto=$r->texto;
            DB::insert("insert into comunicados values(null,'".$titulo."','".$texto."',now(),null,$r->categoria)");
           $categoria=$r->categoria;
           $cat=null;
           if ($categoria==1){
               $cat='MUY URGENTE';
           }elseif ($categoria==2){
               $cat='URGENTE';
           }else{
               $cat='NORMAL';
           }
            $mensaje=$r->texto;
            $titulo='Nuevo Comunicado - '.$cat;
            $notificacion=new Notificaciones;
            $notificacion->sendMessage($mensaje,$titulo);
            return 'Lo agregamos';
        }
    }
    public function obtenerComunicado(Request $r)
    {
        $data=DB::select('select c.id id, c.titulo titulo, c.texo_comunicado texo_comunicado,tc.id tipo_comunicado,c.created_at fecha,
    tc.descripcion descripcion from comunicados c join tipo_comunicado tc on
     c.tipo_comunicado=tc.id order by id desc limit 25');
        $data2=DB::select("select * from tipo_comunicado");
        return response(
            [
                "data"=>$data,
                "data2"=>$data2
                ]
        );
    }
    public function eliminarComubnicado(Request $r)
    {
        $id=$r->id;
        $data=DB::delete("delete from comunicados where id='".$id."'");
        return $data;
    }

    public function enterado(Request $r){
        DB::insert("insert into usuario_comunicado_entereado
                         values(null,'".$r->usuario."','".$r->comunicado."',1);");
        return 1;
    }
    public function enterado_usuario(Request $r){
        DB::insert("select *
               from usuario_comunicado_entereado where id_usuario='".$r->usuario."'
                      group by id_comunicado;");
    }
    public function enteradousuarios(Request $r){
        $data=DB::select("select *
from usuario_comunicado_entereado uce join comunicados c on c.id=uce.id_comunicado
join users u on u.id=uce.id_usuario
group by uce.id_usuario,uce.id_comunicado;");
        return $data;
    }
}
