<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Division;
use App\Models\Level;
use App\Models\Module;
use App\Models\Trainer;
use App\Models\Teaching;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Methodes\MethodesTrainer;
use App\Models\Time_planning;
use Exception;

class moduleTrainerController extends Controller
{
    public function form($id){
        try{

                $trainer = Trainer::whereId($id)->first();
                $divisions = Division::all();
                $func = new MethodesTrainer();
                $tab = array();
                $lev = array();
                $mod = array();
                $div = array();
                $divs = $func -> listDivModLev($id);
                for($i = 0 ; $i < count($divs) ; $i++){
                    $tab = explode(",",$divs[$i]);
                    $mod[$i] = $tab[0];
                    $lev[$i] = $tab[1];
                    $div[$i] = $tab[2];
                }
                $time_planning = Time_planning::whereId($trainer->time_planning_id)->value('file');
                return [$divisions, $trainer, $mod, $lev, $div, $time_planning];
        }catch(Exception $e){
            return redirect('listTrainers')->with("erreur","Error while showing form for trainer update");
        }
    }

    public function formTrainer($id = null){

            $browseTrainer = new Trainer;
            if(session('user') == 'Supervisor'){
                if($id == null){
                    if($this->authorize('add', $browseTrainer)){
                        $divisions = Division::all();
                        return view('ismo.TableData.Trainers.addTrainer', compact('divisions'));
                    }
                }else{
                    if($this->authorize('edit', $browseTrainer)){
                        $values = $this->form($id);
                        return view('ismo.TableData.Trainers.addTrainer', ['divisions' => $values[0],'trainer' => $values[1],'module' => $values[2], 'level' => $values[3], 'division' => $values[4], 'fileName' => $values[5]]);
                    }
                }

            }else{
                if($id == null){
                    $divisions = Division::all();
                    return view('ismo.TableData.Trainers.addTrainer', compact('divisions'));
                }else{
                    $values = $this->form($id);
                    return view('ismo.TableData.Trainers.addTrainer', ['divisions' => $values[0],'trainer' => $values[1],'module' => $values[2], 'level' => $values[3], 'division' => $values[4], 'fileName' => $values[5]]);
                }
            }

    }


    function fetch(Request $request)
    {
        try{
            $select = $request->get('select');
            $value = $request->get('value');
            $dependent = $request->get('dependent');
            $last = substr($dependent, -1);
            if(is_numeric($last)){
                $division = "Division" . $last ;
                $level = "Level" . $last ;
                $dependent = substr($dependent, 0, -1);
            }else{
                $division = "Division";
                $level = "Level";
            }

            $output = '<option value="">Select '.ucfirst($dependent).'</option>';
            if($value != ""){
                if($select == $division){
                    $data = Division::whereName($value)->firstOrFail()->levels;
                    $request->session()->put('codeLev',$data[0]->division_id);
                    foreach($data as $key => $value){
                        $output .= '<option value="'.$value->name.'">'.$value->name.'</option>';
                    }
                }else if($select == $level){
                    $data = Level::whereName($value)->whereDivision_id($request->session()->get('codeLev'))->firstOrFail()->modules;
                    foreach($data as $key => $value){
                        $output .= '<option value="'.$value->name.'">'.$value->name.'</option>';
                    }
                }
            }
            echo $output;
        }catch(Exception $e){
            //'<option value="">Undefined Ofsset: 0</option>'
            echo  $output .= $e->getMessage();
        }
    }

    function saveUpdate(Request $request){
            $index = $request->input('index');
            $func = new MethodesTrainer();
            $contSelect = $request->input('contSelect');
            $id = $request->input('id');
            $b = null;

            if(!empty($index)){$b = false;}else{$b = true;}

            $this->validate($request, [
                'id'  => ['required','min:5','max:10',Rule::unique('trainers','id')->ignore($index)],
                'first_name'  => 'required|min:3|max:25',
                'last_name'  => 'required|min:3|max:25',
                'age'  => 'required|integer',
                'email' => ['required','email:rfc,dns',Rule::unique('trainers','email')->ignore($index)],
                'division'  => 'required',
                'level'  => 'required',
                'module'  => 'required',
                'file'  => [Rule::requiredIf($b)],
            ]);

            if(!empty($index)){
                try{
                    $obj = $func -> ObjTrainerUpd(new Trainer(),$request,$index);

                    if ($obj == false){
                        $request->session()->put('titleErreur','Error');
                        return back()->with("erreur","Error while updating file" );
                    }else{
                        $boll = Trainer::whereId($index)->update(json_decode(json_encode($obj), true));
                        $request->session()->get('name');
                        $del = 0;
                        if($boll == 1){
                            $index = null;
                            if( intval($contSelect) > 0){
                                $del = $func ->deleteData($id);
                                if($del > 0){
                                    $index = $func -> updateData($request->input('division'),$request->input('level'),$request->input('module'),$id);

                                    for($i = 1 ; $i <= intval($contSelect) ; $i++){
                                        $index = $func -> updateData($request->input('division' . $i),$request->input('level' . $i),$request->input('module' . $i),$id);
                                    }
                                }

                            }else if(intval($contSelect) == 0){
                                $del = $func ->deleteData($id);
                                if($del == 1){
                                    $index = $func -> updateData($request->input('division'),$request->input('level'),$request->input('module'),$id);
                                }
                            }
                            if($index == true){
                                return redirect('listTrainers')->with("success","Trainer information updated successfully");
                            }else{
                                $request->session()->put('titleErreur','Error');
                                return redirect('listTrainers')->with("erreur","Error while updating the units taught by the trainer" );
                            }
                        }else{
                            $request->session()->put('titleErreur','Error');
                            return redirect('listTrainers')->with("erreur","Error when updating trainer information");
                        }
                    }
                }catch(Exception $e){
                    $request->session()->put('titleErreur','Error');
                    return redirect('listTrainers')->with("erreur","Error when updating trainer information  " . $e->getMessage());
                }
            }else{
                try{
                    $obj = $func -> ObjTrainerSav(new Trainer(),$request);
                    if ($obj == false){
                        $request->session()->put('titleErreur','Error');
                        return back()->with("erreur","Error while saving file" );
                    }else{
                        $bool = null;
                        $b = $obj->save();
                        if($b == 1){
                            if( intval($contSelect) > 0){
                                $bool = $func -> saveData($request->input('division'),$request->input('level'),$request->input('module'),$id);

                                for($i = 1 ; $i <= intval($contSelect) ; $i++){
                                    $bool = $func -> saveData($request->input('division' . $i),$request->input('level' . $i),$request->input('module' . $i),$id);
                                }

                            }else if(intval($contSelect) == 0){
                                $bool = $func -> saveData($request->input('division'),$request->input('level'),$request->input('module'),$id);
                            }
                            if($bool == true){
                                return redirect('listTrainers')->with("success","Trainer information saved successfully");
                            }else{
                                $request->session()->put('titleErreur','Error');
                                return redirect('listTrainers')->with("erreur","Error while memorizing the units taught by the trainer" . $bool);
                            }
                        }else{
                            $request->session()->put('titleErreur','Error');
                            return redirect('listTrainers')->with("erreur","Error while saving trainer information" );
                        }
                    }
                }catch(Exception $e){
                    $request->session()->put('titleErreur','Error');
                    return redirect('listTrainers')->with("erreur","Error while saving trainer information  " . $e->getMessage());
                }
            }
    }

    public function listData(Request $request){
        try{
            $func = new MethodesTrainer();
            $id = $request->id;
            $div = $func -> listDivModLev($id);

            return response()->json(['success'=> $div]);
        }catch(Exception $e){
            return response()->json(['error'=>$e->getMessage()]);
        }
    }
}
