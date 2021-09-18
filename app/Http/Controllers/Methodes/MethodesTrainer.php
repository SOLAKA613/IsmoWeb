<?php

namespace App\Http\Controllers\Methodes;

use Illuminate\Http\Request;
use Exception;
use App\Models\Level;
use App\Models\Division;
use App\Models\Teaching;
use App\Models\Trainer;
use App\Models\Module;
use App\Models\Time_planning;
use Illuminate\Support\Facades\Storage;

class MethodesTrainer {

    public function ObjTrainerUpd(object $obj,Request $request,$id){

        $idFile = null;

        if(!empty($request->file)){
            $nameFile = $request->file('file')->getClientOriginalName();
            $file = $request->file('file');
            $path = $file->store('public/files');
            $trainer = Trainer::whereId($id)->first();
            $i = Time_planning::whereId($trainer->time_planning_id)->update(['name' => $nameFile,"file" => $path]);
            if($i == 0){
                return false;
            }
            $idFile = Time_planning::whereFile($request->file)->value("id");
        }else{
            $idFile = Trainer::whereId($id)->value("time_planning_id");
        }

        $obj->id = $request->input('id');
        $obj->first_name = $request->input('first_name');
        $obj->last_name = $request->input('last_name');
        $obj->age = $request->input('age');
        $obj->email = $request->input('email');
        $obj->gender = $request->input('gender');
        $obj->time_planning_id = $idFile;
        return $obj;

    }

    public function ObjTrainerSav(object $obj,Request $request){
        $nameFile = $request->file('file')->getClientOriginalName();
        $file = $request->file('file');
        $path = $file->store('public/files');
        $time_planning = new Time_planning();
        $time_planning->name = $request->file;
        $time_planning->file = $path;
        $i = $time_planning->save();
        if($i == 0){
            return false;
        }

        $idFile = Time_planning::whereFile($path)->value("id");
        $obj->id = $request->input('id');
        $obj->first_name = $request->input('first_name');
        $obj->last_name = $request->input('last_name');
        $obj->age = $request->input('age');
        $obj->email = $request->input('email');
        $obj->gender = $request->input('gender');
        $obj->time_planning_id = $idFile;
        return $obj;
    }

    public function saveData($nameDivision,$nameLevel,$nameModule,$id){
        try{
            $Levs = Division::whereName($nameDivision)->firstOrFail()->levels;
            $teaching = new Teaching();
            foreach($Levs as $key => $value){
                if($value->name == $nameLevel){
                    $mdl = Level::whereId($value->id)->firstOrFail()->modules;
                    foreach($mdl as $key => $value){
                        if($value->name == $nameModule){
                            $teaching->module_id = $value->id;
                            $teaching->trainer_id = $id;
                            $tech = $teaching->save();
                            if($tech >= 1){
                                return true;
                            }
                        }
                    }
                }
            }

        return false;
        }catch(Exception $e){
            return $e->getMessage();
        }
    }

    public function deleteData($id){
        try{
            $del = Teaching::whereTrainer_id($id)->delete();
            return $del;
        }catch(Exception $e){
            return false;
        }
    }

    public function updateData($nameDivision,$nameLevel,$nameModule,$id){
        try{
            $Levs = Division::whereName($nameDivision)->firstOrFail()->levels;
            $teaching = new Teaching();

            foreach($Levs as $key => $value){
                if($value->name == $nameLevel){
                    $mdl = Level::whereId($value->id)->firstOrFail()->modules;
                    foreach($mdl as $key => $value){
                        if($value->name == $nameModule){
                            $teaching->module_id = $value->id;
                            $teaching->trainer_id = $id;
                            $tech = $teaching->save();
                            if($tech >= 1){
                                return true;
                            }
                        }
                    }
                }
            }

        return false;
        }catch(Exception $e){
            return $e->getMessage();
        }
    }

    public function listDivModLev($id){
        try{
            $mods = array();
            $lev = array();
            $div = array();
            $i = 0;
            $techs = Trainer::whereId($id)->firstOrFail()->teachings;
            foreach($techs as $key => $value){
                $mods[$i] = Module::findOrFail($value->module_id);
                $i++;
            }
            $i=0;
            foreach($mods as $key => $value){
                $lev[$i] = Level::findOrFail($value->level_id);
                $div[$i] = $value->name . "," . $lev[$i]["name"] . "," . Division::findOrFail($lev[$i]["division_id"])->name;
                $i++;
            }

            return $div;

        }catch(Exception $e){
            return $e->getMessage();
        }
    }


}
