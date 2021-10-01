<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LinksInteresController extends Controller
{
    public function insertarLi(Request $r)
    {
        $id=$r->id;
        if (isset($id) and !empty($id)){
            DB::update("update link_interes set titulo='".$r->titulo."',link='".$r->link."', updated_at=now() where id = '".$id."'");
            return 'Campo Modificado';
        }else{
            $titulo=$r->titulo;
            $link=$r->link;
            DB::insert("insert into link_interes values(null,'".$titulo."','".$link."',now(),null)");
            return 'Agregado';
        }
    }
    public function obtenerLi(Request $r)
    {
        $data=DB::select('select * from link_interes order by id desc limit 25');
        return $data;
    }
    public function eliminarLi(Request $r)
    {
        $id=$r->id;
        $data=DB::delete("delete from link_interes where id='".$id."'");
        return $data;
    }
}
