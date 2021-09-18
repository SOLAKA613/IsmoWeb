<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Division;
use App\Models\Level;
use App\Models\Group;
use App\Models\Module;
use Carbon\Carbon;
use Exception;

class listController extends Controller
{
    public function listDivisions(){
        $divisions = Division::all();
        return view('ismo.TableData.division', compact('divisions'));
    }

    public function updateDivision(Request $request){
        try{
            $id = $request->code;
            $idDiv = $request->idDiv;
            $name = $request->name;
            $date = Carbon::now();
             Division::updateOrInsert(
                ['id' => $idDiv],
                ['id' => $id ,'name' => $name,'created_at' => $date, 'updated_at' => $date]
            );

            return response()->json(['success'=>"update successfully.".$idDiv]);

        }catch(Exception $e){
            return response()->json(['error'=>"Error"]);
        }
    }

    public function deleteLotDivisions(Request $request){
        try{
            $ids = $request->ids;
            $d = Division::whereIn('id',explode(",",$ids))->delete();
            if($d >= 1){
                return response()->json(['success'=>"deleted successfully."]);
            }else{
                return response()->json(['error'=>"Error "]);
            }
        }catch(Exception $e){
            return response()->json(['error'=>"Error"]);
        }
    }

    public function deleteDivision(Request $request){
        try{
            $id = $request->id;
            $d = Division::whereId($id)->delete();
            if($d >= 1){
                return response()->json(['success'=>"deleted successfully."]);
            }else{
                return response()->json(['error'=>"Error "]);
            }
        }catch(Exception $e){
            return response()->json(['error'=>"Error"]);
        }
    }

    public function listLevels(Request $request){
        try{
            $id = $request->id;
            $request->session()->put('id_division',$id);
            $levels = Division::whereId($id)->first()->levels;
            return view('ismo.TableData.level', compact('levels'));
        }catch(Exception $e){
            return response()->json(['error'=> $e->getMessage()]);
        }
    }

    public function updateLevel(Request $request){
        try{
            $id = $request->code;
            $idLev = $request->idLev;
            $name = $request->name;
            $date = Carbon::now();
            Level::updateOrInsert(
                ['id' => $idLev],
                ['id' => $id ,'division_id' => $request->session()->get('id_division'),'name' => $name,'created_at' => $date, 'updated_at' => $date]
            );

            return response()->json(['success'=>"update successfully."]);

        }catch(Exception $e){
            return response()->json(['error'=>"Error"]);
        }
    }

    public function deleteLevel(Request $request){
        try{
            $id = $request->id;
            $d = Level::whereId($id)->delete();
            if($d >= 1){
                return response()->json(['success'=>"deleted successfully."]);
            }else{
                return response()->json(['error'=>"Error "]);
            }
        }catch(Exception $e){
            return response()->json(['error'=>"Error"]);
        }
    }

    public function deleteLotLevels(Request $request){
        try{
            $ids = $request->ids;
            $d = Level::whereIn('id',explode(",",$ids))->delete();
            if($d >= 1){
                return response()->json(['success'=>"deleted successfully."]);
            }else{
                return response()->json(['error'=>"Error "]);
            }
        }catch(Exception $e){
            return response()->json(['error'=>"Error"]);
        }
    }


    public function listGroups(Request $request){
      try{
        $id = $request->id;
        $groups = Level::whereId($id)->first()->groups;
        $request->session()->put('id_level',$id);
        return view('ismo.TableData.group', ['groups'=>$groups,'idDiv'=>$request->session()->get('id_division')]);
      }catch(Exception $e){
        return response()->json(['error'=>"Error"]);
      }

    }

    public function updateGroup(Request $request){
        try{
            $id = $request->code;
            $idGr = $request->idGr;
            $name = $request->name;
            $date = Carbon::now();
            Group::updateOrInsert(
                ['id' => $idGr],
                ['id' => $id ,'level_id' => $request->session()->get('id_level'),'name' => $name,'created_at' => $date, 'updated_at' => $date]
            );

           return response()->json(['success'=>"update successfully."]);
        }catch(Exception $e){
            return response()->json(['error'=>"Error"]);
        }
    }

    public function deleteGroup(Request $request){
        try{
            $id = $request->id;
            $d = Group::whereId($id)->delete();
            if($d >= 1){
                return response()->json(['success'=>"deleted successfully."]);
            }else{
                return response()->json(['error'=>"Error "]);
            }
        }catch(Exception $e){
            return response()->json(['error'=>"Error"]);
        }
    }

    public function deleteLotGroups(Request $request){
        try{
            $ids = $request->ids;
            $d = Group::whereIn('id',explode(",",$ids))->delete();
            if($d >= 1){
                return response()->json(['success'=>"deleted successfully."]);
            }else{
                return response()->json(['error'=>"Error "]);
            }
        }catch(Exception $e){
            return response()->json(['error'=>"Error"]);
        }
    }

    public function listModules(Request $request){
        try{
          $id = $request->id;
          $modules = Level::whereId($id)->first()->modules;
          $request->session()->put('id_level',$id);
          return view('ismo.TableData.module', ['modules'=>$modules,'idDiv'=>$request->session()->get('id_division')]);
        }catch(Exception $e){
          return response()->json(['error'=>"Error"]);
        }

    }

      public function updateModule(Request $request){
          try{
              $id = $request->code;
              $idMo = $request->idMo;
              $name = $request->name;
              $date = Carbon::now();
              Module::updateOrInsert(
                  ['id' => $idMo],
                  ['id' => $id ,'level_id' => $request->session()->get('id_level'),'name' => $name,'created_at' => $date, 'updated_at' => $date]
              );

             return response()->json(['success'=>"update successfully."]);
          }catch(Exception $e){
              return response()->json(['error'=>"Error"]);
          }
      }

      public function deleteModule(Request $request){
          try{
              $id = $request->id;
              $d = Module::whereId($id)->delete();
              if($d >= 1){
                  return response()->json(['success'=>"deleted successfully."]);
              }else{
                  return response()->json(['error'=>"Error "]);
              }
          }catch(Exception $e){
              return response()->json(['error'=>"Error"]);
          }
      }

      public function deleteLotModules(Request $request){
          try{
              $ids = $request->ids;
              $d = Module::whereIn('id',explode(",",$ids))->delete();
              if($d >= 1){
                  return response()->json(['success'=>"deleted successfully."]);
              }else{
                  return response()->json(['error'=>"Error "]);
              }
          }catch(Exception $e){
              return response()->json(['error'=>"Error"]);
          }
      }
}
