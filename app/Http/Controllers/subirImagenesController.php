<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class subirImagenesController extends Controller
{
    //
    public function subidaFicheros(Request $request)
    {

        $archivos = $request->file('files');

        if (isset($archivos)) {
           $url=asset('/storage/galeria_fotos/');
           // $url='https://octaconc.com/home/octaconc/public_html/storage/imagenes_publicaciones/';

            foreach ($archivos as $archivo) {
                $aux = explode('.', $archivo->getClientOriginalName());
                $filename = $aux[0] . '-' . rand(0, 100) . '-' . date("Y-m-d_H:i:s") . '.' . $archivo->getClientOriginalExtension();
                \Storage::disk('galeria_fotos')->put($filename, \File::get($archivo));
                $filename=$url.'/'.$filename;

                DB::insert("insert into albumnes_fotos values(null,'".$request->album."',
                now(),null,'".$filename."')");


            }

            return 'subido';

        }else{
            return 'error';
        }
    }

    public function getFiles(Request $r)
    {
        $data=DB::select("select af.id id,af.fotos fotos,af.created_at fecha,a.id idalbum, a.nombre_album album
from albumnes_fotos af join albumnes a on af.id_album=a.id where id_album='".$r->album."'");
        return $data;
    }

    public function deleteFicheros(Request $r)
    {
        DB::delete("delete from albumnes_fotos where id='".$r->id."'");
        return 'Eliminado';
    }

    public function getAlbum(Request $r)
    {
        $data=DB::select("select * from albumnes");
        return $data;
    }
    public function deletealbum(Request $r)
    {
        DB::delete("delete from albumnes where id='".$r->id."'");
        return 'Eliminado';
    }
    public function postalbum(Request $r)
    {
        if (isset($r->id) and !empty($r->id)){
            DB::update("update albumnes set nombre_album='".$r->titulo."', updated_at=now() where id='".$r->id."'");
        return 1;
        }else{
            DB::insert("insert into albumnes values(null,'".$r->titulo."',now(),null)");
        return 2;
        }
    }

}
