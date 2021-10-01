<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SugerenciasController extends Controller
{

	public function insertarSugerencia(request $r)
	{
		$data=DB::insert("insert into sugerencias values (null,'".$r->sugerencia."','".$r->idusu."',now(),null)");
		return 1;
	}

   	public function obtenerSugerencias(Request $r)
    {

        $data=DB::select("select s.id id, s.descripcion descripcion, u.name Users, s.created_at created_at
            FROM sugerencias s
            JOIN users u
            ON s.Users=u.id
            ORDER BY id desc limit 25");



        return $data;


    }
}
