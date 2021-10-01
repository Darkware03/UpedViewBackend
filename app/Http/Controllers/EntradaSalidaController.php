<?php

namespace App\Http\Controllers;

//use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class EntradaSalidaController extends Controller
{
    public function insertarEntrada(Request $r)
    {
        /*if ($r->id) {
            DB::update("update rentrada_salida set salida='" . $r->salida . "' where id='" . $r->id . "' and Users='" . $r->user . "'");
            return 'salida';
        }else{*/
        if ($r->tipo==1){
            DB::insert("insert into rentrada_salida values (null, '".$r->id."',now(),null)");
            return 1;
        }else if ($r->tipo==2){
            $identrada=null;
            $data=DB::select("select * from rentrada_salida where Users='".$r->id."' order by id desc limit 1;");
            foreach ($data as $row){
            $identrada=$row->id;
            }
            if ($identrada>0){
                DB::insert("update rentrada_salida set salida = now() where id='".$identrada."'");
            }
            return 2;
        }
        /*}*/
    }

     public function insertarSalida(Request $r)
    {
        //   DB::update ("update rentrada_salida set salida='".$r->salida."' where id='".$r->id."' and Users='".$r->user."'");

           return 'ingresado';
    }


    public function obtenerRegistros(Request $r)
	{
	    $ladata=[];
	    $hoy=date('Y-m-d');
	    $data=DB::select("select es.id,u.name,es.entrada,es.salida
            from rentrada_salida es join users u on es.Users=u.id where es.entrada like '%".$r->fecha."%'
	    	order by es.id desc");


        return $data;

	}
}
