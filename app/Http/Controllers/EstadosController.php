<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EstadosController extends Controller
{
    //
    public function insertarEstado(Request $r)
    {
        $id=$r->id;
        if (isset($id) and !empty($id)){
            DB::update("update estados set descripcion='".$r->descripcion."', updated_at=now() where id = '".$id."'");
            return 'MODIFICADO';
        }else{
            $descripcion=$r->descripcion;
            DB::insert("insert into estados values(null,'".$descripcion."',now(),null)");
            return 'Lo agregamos';
        }
    }
    public function obtenerEstado(Request $r)
    {
        $data=DB::select('select * from estados order by id desc limit 25');
        return $data;
    }
    public function getMarcacion(Request $r)
    {
        $data=DB::select('select * from tipo_marcacion order by id desc limit 25');
        return $data;
    }
    public function eliminarEstado(Request $r)
    {
        $id=$r->id;
        $data=DB::delete("delete from estados where id='".$id."'");
        return $data;
    }
}
