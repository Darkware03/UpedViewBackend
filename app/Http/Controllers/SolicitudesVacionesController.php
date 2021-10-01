<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SolicitudesVacionesController extends Controller
{
   	public function insertarSolicitudVacacion(request $r)
	{
		$data=DB::insert("insert into solicitudes_vacaciones values (null,'".$r->id."','".$r->fecha_inicio."',now(),null,'".$r->mensaje."')");
		return 1;
	}

   	public function obtenerSolicitudesVacaciones(Request $r)
    {

        $data=DB::select("select s.id id, s.mensaje,u.name Users, s.fecha_inicio fecha_inicio, s.created_at created_at
            FROM solicitudes_vacaciones s
            JOIN users u
            ON s.Users=u.id
            ORDER BY id desc limit 25");

        return $data;
    }
}


