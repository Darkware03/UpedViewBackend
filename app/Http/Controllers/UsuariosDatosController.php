<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsuariosDatosController extends Controller
{
    //
    public function obtenerCumpleaneros(Request $r)
    {
        $dia_actual=date('d');
        $mes_actual=date('m');
        $data=DB::select("select u.id,name,foto_perfil,cu.descripcion cargo
        from users u join area cu on u.area=cu.id where month(fecha_nacimiento)=$mes_actual");
        return $data;
    }

    public function obtenerContactos(Request $r)
    {

        $data=DB::select("select id,name,area, foto_perfil, email,telefono telefono from users
 where not(id=$r->id) order by area;");
        return $data;
    }

    public function obtenerContactoMensaje(Request $r)
    {

        $data=DB::select("select id,name,area, foto_perfil, email from users order by area;");
        return $data;
    }
}
