<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SurvController extends Controller
{
    public function insertarSurv(Request $r)
    {
        $id=$r->id;
        if (isset($id) and !empty($id)){
            DB::update("update surveys set titulo='".$r->titulo."',link='".$r->link."', updated_at=now() where id = '".$id."'");
            return 'Campo Modificado';
        }else{
            $titulo=$r->titulo;
            $link=$r->link;
            DB::insert("insert into surveys values(null,'".$titulo."','".$link."',now(),null)");
            return 'Agregado';
        }
    }
    public function obtenerSurv(Request $r)
    {
        $data=DB::select('select * from surveys order by id desc limit 25');
        return $data;
    }
    public function eliminarSurv(Request $r)
    {
        $id=$r->id;
        $data=DB::delete("delete from surveys where id='".$id."'");
        return $data;
    }
}
