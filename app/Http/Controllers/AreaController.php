<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AreaController extends Controller
{
    public function insertarArea(Request $r)
    {
        $id=$r->id;
        if (isset($id) and !empty($id)){
            DB::update("update area set descripcion='".$r->descripcion."', updated_at=now() where id = '".$id."'");
            return 'Campo Modificado';
        }else{
            $descripcion=$r->descripcion;
            DB::insert("insert into area values(null,'".$descripcion."',now(),null)");
            return 'Agregado';
        }
    }
    public function obtenerArea(Request $r)
    {
        $data=DB::select('select * from area order by id desc limit 25');
        return $data;
    }
    public function eliminarArea(Request $r)
    {
        $id=$r->id;
        $data=DB::delete("delete from area where id='".$id."'");
        return $data;
    }
}
