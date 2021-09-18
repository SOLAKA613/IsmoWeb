<?php

namespace App\Http\Controllers\Methodes;

use Illuminate\Http\Request;


class Functions {

    public function createObj(object $obj,Request $request,$group_id){
        $obj->id = $request->input('id');
        $obj->first_name = $request->input('first_name');
        $obj->last_name = $request->input('last_name');
        $obj->age = $request->input('age');
        $obj->email = $request->input('email');
        $obj->gender = $request->input('gender');
        $obj->group_id = $group_id;
        return $obj;
    }


}
