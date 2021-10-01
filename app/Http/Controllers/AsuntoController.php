<?php

namespace App\Http\Controllers;

//use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AsuntoController extends Controller
{
    public function insertarAsunto(Request $r)
    {

        if (isset($r->id) and !empty($r->id)){
            DB::update("update asuntos set descripcion='".$r->descripcion."',updated_at=now()
             where id='".$r->id."'");
            return 'modificado';
        }else{
           DB::insert("insert into asuntos values (null,'".$r->descripcion."',now(),null)");

                return 'Asunto Registrado';
            }

    }


     public function obtenerAsuntos(Request $r)
    {
    	$data=DB::select("select * from asuntos order by id desc");
        return $data;
    }

    public function eliminarAsunto(Request $r)
    {
        $id=$r->id;
        $data=DB::delete("delete from asuntos where id='".$id."'");
        return $data;
    }

    
}
