<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class CorreosPersonalesController extends Controller
{
    public function insertarCorreoPersonal(Request $r)
    {
        
        DB::insert("insert into correo_personales values (null,'".Auth::user()->email."','".$r->correoDestinatario."','".$r->Asunto."','".$r->mensaje."',now(),null)");
        

        /*if (isset($r->id) and !empty($r->id)){
            DB::update("update correo_personales set correo_remitente='".$r->correoRemitente."',correo_destinatario='".$r->correoDestinatario."',Asunto='".$r->Asunto."',mensaje='".$r->mensaje."',updated_at=now()
             	      where id='".$r->id."'");

            return 'modificado';
        }else{ }*/
             

    }


     public function obtenerCorreosPersonales(Request $r)
    {
        $correousuario=Auth::user()->email;
        $data=DB::select("select cp.id id, cp.correo_remitente correo_remitente, cp.correo_destinatario correo_destinatario, a.descripcion Asunto, cp.mensaje mensaje, cp.created_at created_at
			FROM correo_personales cp
			JOIN asuntos a
			ON cp.Asunto=a.id
            WHERE '$correousuario'= cp.correo_remitente
            ORDER BY id desc limit 25");

        $data2=DB::select("select * from asuntos");
        
        return response([
        	"data"=>$data,
        	"data2"=>$data2
        ]);
    }

    public function eliminarCorreosPersonal(Request $r)
    {
        
        $data=DB::delete("delete from correo_personales where id='".$r->id."'");

        return 'eliminado';
    }
}
