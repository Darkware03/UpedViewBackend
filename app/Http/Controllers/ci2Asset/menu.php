<?php

namespace App\Http\Controllers\ci2Asset;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class menu extends Controller
{
    public function getMenuItems(Request $r)
    {
        $data=DB::select("select * from menu where estado > 0");
        return $data;
    }
    public function getMenu2Items(Request $r)
    {
        $data=DB::select("select * from menu_2 where estado >0");
        return $data;
    }
    public function getMenu3Items(Request $r)
    {
        $data=DB::select("select * from menu_3 where estado >0");
        return $data;
    }
}
