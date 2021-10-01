<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoriaNoticiaController extends Controller
{
    public function insertarCatNoticia(Request $r)
    {
        $id=$r->id;
        if (isset($id) and !empty($id)){
            DB::update("update categoria_noticia set descripcion='".$r->descripcion."', updated_at=now() where id = '".$id."'");
            return 'Campo Modificado';
        }else{
            $descripcion=$r->descripcion;
            DB::insert("insert into categoria_noticia values(null,'".$descripcion."',now(),null)");
            return 'Agregado';
        }
    }
    public function obtenerCatNoticia(Request $r)
    {
        $data=DB::select('select * from categoria_noticia order by id desc limit 25');
        return $data;
    }
    public function eliminarCatNoticia(Request $r)
    {
        $id=$r->id;
        $data=DB::delete("delete from categoria_noticia where id='".$id."'");
        return $data;
    }
}
