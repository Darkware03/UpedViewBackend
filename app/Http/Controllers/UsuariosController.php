<?php

namespace App\Http\Controllers;

//use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuariosController extends Controller
{
    public function Login(Request $r){
        $email=$r->email;
        $password=$r->password;
        if (isset($email) && !empty($email) && $email!=='' && isset($password) && !empty($password) && $password!=='') {
            $data = DB::select('select * from users where email=? and password=?;', [$email, Hash::make($password)]);
            return $data;
        }
        return 'Error';
    }

    public function insertarUsuario(Request $r)
    {

        if (isset($r->id) and !empty($r->id)){
            $archivos = $r->file('files');
            $filename=null;
            $url=null;
            $usuario=auth()->id();
            if (isset($archivos)) {
                 $url=asset('/storage/imagenes_foto_perfil/');
                //$url='https://octaconc.com/home/octaconc/public_html/storage/imagenes_foto_perfil/';
                foreach ($archivos as $archivo) {
                    /*SUBIDA DE IMAGENES
                    en este apartado lo estaremos moviendo a la carpeta local
                    */
                    $aux = explode('.', $archivo->getClientOriginalName());
                    $filename = $aux[0] . '-' . rand(0, 100) . '-' . date("Y-m-d_H:i:s") . '.' . $archivo->getClientOriginalExtension();
                    \Storage::disk('imagenes_foto_perfil')->put($filename, \File::get($archivo));
                    /*FIN SUBIDA DE IMAGENES*/
                    $filename=$url.'/'.$filename;
                }
            }
            //if (isset($r->titulo) and !empty($r->titulo )){
            $password=Hash::make($r->password);
            DB::update("update users
set name='".$r->nombre."',email='".$r->correo."',password='".$password."',telefono='".$r->telefono."'
,area='".$r->Area."',fecha_nacimiento='".$r->fechaDeNacimiento."',sexo='".$r->sexo."',estado='".$r->estado."'
,codigoEmpleado='".$r->codigoEmpleado."',updated_at=now()/*,foto_perfil='".$filename."'*/
             where id='".$r->id."'");
            return 'modificado';
        }else{
            //primero asignamos el request a una variable asi
            $archivos = $r->file('files');
            $filename=null;
            $url=null;
            $usuario=auth()->id();
            if (isset($archivos)) {
                $url=asset('/storage/imagenes_foto_perfil/');
               // $url='https://octaconc.com/home/octaconc/public_html/storage/imagenes_foto_perfil/';
                    foreach ($archivos as $archivo) {
                        /*SUBIDA DE IMAGENES
                        en este apartado lo estaremos moviendo a la carpeta local
                        */
                        $aux = explode('.', $archivo->getClientOriginalName());
                        $filename = $aux[0] . '-' . rand(0, 100) . '-' . date("Y-m-d_H:i:s") . '.' . $archivo->getClientOriginalExtension();
                        \Storage::disk('imagenes_foto_perfil')->put($filename, \File::get($archivo));
                        /*FIN SUBIDA DE IMAGENES*/
                        $filename=$url.'/'.$filename;
                    }
            }
            //if (isset($r->titulo) and !empty($r->titulo )){
            $password=Hash::make($r->password);
                DB::insert("insert into users values(null,'".$r->nombre."','".$r->correo."',null,'".$password."',null,now(),null)");
//insert into users values
//(null,$r->nombre,$r->correo,null,$password,$r->telefono,$r->Area,null,now(),null,$r->fechaDeNacimiento,null,$r->sexo,$r->codigoEmpleado,$r->estado
                return 'Usuario Registrado';
            }

    }


    public function obtenerUsuario(Request $r)
    {


       /* $data=DB::select("select u.id id,u.codigoEmpleado codigoEmpleado,u.name nombre,u.password password,u.foto_perfil foto_perfil,
u.telefono telefono,u.marcacion marcacion,u.email correo,a.descripcion area,e.descripcion estado,s.descripcion sexo,s.id sid,e.id eid,a.id aid,u.fecha_nacimiento fechaDeNacimiento
*/
//        $data=DB::select("select u.id id,u.codigoEmpleado codigoEmpleado,u.name nombre,u.password password,u.foto_perfil foto_perfil,
// u.telefono telefono,u.email correo,a.descripcion area,e.descripcion estado,s.descripcion sexo,s.id sid,e.id eid,a.id aid,u.fecha_nacimiento fechaDeNacimiento
// from users u join area a on u.area=a.id
// join estados e on u.estado=e.id
// join sexo s on u.sexo=s.id
// where u.estado=1;");
        $data2=DB::select("select * from area");
        $data3=DB::select("select * from sexo");
        $data4=DB::select("select * from estados");

        return response([
        	//"data"=>$data,
        	"data2"=>$data2,
        	"data3"=>$data3,
        	"data4"=>$data4,
        ]);
    }

    public function obEstadoUsuarioCero(Request $r)
    {

        $data=DB::select("select * from users where estado=0");
        return $data;
    }
    public function getCargo(Request $r)
    {
        $data=DB::select("select * from cargo_user");
        return $data;
    }
    public function postCargo(Request $r)
    {
        if($r->id){
            $data=DB::update("update cargo_user set descripcion='".$r->cargo."' where id='".$r->id."'");
            return $data;
        }else{
            $data=DB::insert("insert into cargo_user values(null,'".$r->cargo."')");
            return $data;
        }
    }
    public function deleteCargo(Request $r)
    {
        $data=DB::delete ("delete from cargo_user where id='".$r->id."'");
        return $data;
    }

}
