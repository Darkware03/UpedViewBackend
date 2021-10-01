<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoriaPublicacionController extends Controller
{
    public function insertarCatPub(Request $r)
    {
        $id=$r->id;
        if (isset($id) and !empty($id)){
            DB::update("update categoria_publicacion set descripcion='".$r->descripcion."', updated_at=now() where id = '".$id."'");
            return 'Campo Modificado';
        }else{
            $descripcion=$r->descripcion;
            DB::insert("insert into categoria_publicacion values(null,'".$descripcion."',now(),null)");
            return 'Agregado';
        }
    }
    public function obtenerCatPub(Request $r)
    {
        $data=DB::select('select * from categoria_publicacion order by id desc limit 25');
        return $data;
    }
    public function eliminarCatPub(Request $r)
    {
        $id=$r->id;
        $data=DB::delete("delete from categoria_publicacion where id='".$id."'");
        return $data;
    }
}


