<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Division;
use App\Models\Level;
use App\Models\Group;
use Exception;
use Illuminate\Support\Arr;

class divisionController extends Controller
{
    public function listDivisions(){
        $divisions = Division::all();
        return view('ismo.admin.selectChoice', compact('divisions'));
    }

    function fetch(Request $request)
    {
        try{
        $select = $request->get('select');
        $value = $request->get('value');
        $dependent = $request->get('dependent');

        $output = '<option value="">Select '.ucfirst($dependent).'</option>';
        if($value != ""){
            if($select == "Division"){
                $data = Division::whereName($value)->firstOrFail()->levels;
                $request->session()->put('codeLev',$data[0]->division_id);
                foreach($data as $key => $value){
                    $output .= '<option value="'.$value->name.'">'.$value->name.'</option>';
                }
            }else if($select == "Level"){
                $data = Level::whereName($value)->whereDivision_id($request->session()->get('codeLev'))->firstOrFail()->groups;
                foreach($data as $key => $value){
                    $output .= '<option value="'.$value->name.'">'.$value->name.'</option>';
                }
            }
        }
        echo $output;
        }catch(Exception $e){
            echo  $output .= '<option value="">Undefined Ofsset: 0</option>';
        }
    }


    function show(Request $request){
        try{
            $this->validate($request, [
                'division'  => 'required',
                'level'  => 'required',
                'group'  => 'required',
            ]);

            $division = $request->get('division');
            $level = $request->get('level');
            $group = $request->get('group');
            $idGroup = "";
            $trainees = array();

            $data = Division::whereName($division)->firstOrFail()->levels;
            if($data != null){
                foreach($data as $key => $value){
                    if($value->name == $level){
                        $grp = Level::whereId($value->id)->firstOrFail()->groups;
                        foreach($grp as $key => $value){
                            if($value->name == $group){
                                $idGroup = $value->id;
                                break;
                            }
                        }
                    }
                }
            }

            $request->session()->put('idGroup',$idGroup);
            $request->session()->put('division',$division);
            $request->session()->put('level',$level);
            $request->session()->put('group',$group);

            return redirect('listTrainee');
        }catch(Exception $e){
            return back()->with('erreur',$e->getMessage());
        }

    }

}
