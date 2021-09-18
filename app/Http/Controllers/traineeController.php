<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absences_delay;
use App\Models\Trainee;
use Exception;

class traineeController extends Controller
{
    public function listAbsences_delay(Request $request){
        try{
            $id = $request->id;
            $request->session()->put('idTrainee',$id);
            if($id != null){
                $absences_delays = Trainee::whereId(session('idTrainee'))->first()->absences_delayes;
                $nameTrainee = Trainee::whereId(session('idTrainee'))->first();
                return view('ismo.TableData.Trainee.TableAbsences_delays', ['absences_delays' => $absences_delays , 'nameTrainee' => $nameTrainee ]);
            }
        }catch(Exception $e){
            session(['titleErreur' => 'Erreur!']);
            return redirect('/division')->with("erreur","Error when choosing to display the absence and delay of the trainee." );
        }
    }

    public function deleteAbsences(Request $request){
        try{
            $id = $request->input('id');
            $d = Absences_delay::whereId($id)->delete();
            if($d == 1){
                return redirect('listAbsences_delays')->with("success","Absence information has been deleted successfully");
            }else{
                $request->session()->put('titleErreur','Error');
                return redirect('listAbsences_delays')->with("erreur","Error while deleting absence information");
            }
        }catch(Exception $e){
            $request->session()->put('titleErreur','Error');
            return redirect('listAbsences_delays')->with("erreur","Error while deleting absence information");
        }
    }

    public function deleteLotAbsences(Request $request){
        try{
            $ids = $request->ids;
            $d = Absences_delay::whereIn('id',explode(",",$ids))->delete();
            if($d >= 1){
                return response()->json(['success'=>"deleted successfully."]);
            }else{
                return response()->json(['error'=>"Error "]);
            }
        }catch(Exception $e){
            return response()->json(['error'=>"Error"]);
        }
    }

    public function updateAbsence(Request $request){
        try{
            $id = $request->code;
            $idAbs = $request->idAbs;
            $type = $request->type;
            $remark = $request->remark;
            $idTrainee = session('idTrainee');

            $first_time = date("Y-m-d H:i:s",strtotime($request->first_date_time));
            $last_time = date("Y-m-d H:i:s",strtotime($request->last_date_time));

            $idAbsence = Absences_delay::whereId($idAbs)->first();
            if($idAbsence != null){
                $updateAbs = Absences_delay::whereId($idAbs)->update(['id' => $id,"type" => $type, "remark" => $remark, "first_date_time" => $first_time, "last_date_time" => $last_time, "trainee_id" => $idTrainee ]);

                if($updateAbs > 0){
                    return response()->json(['success'=>"Data updated successfully."]);
                }else{
                    return response()->json(['error'=>"Error"]);
                }
            }else{
                $Absence = new Absences_delay();
                $Absence->id = $id; $Absence->type = $type; $Absence->remark = $remark; $Absence->first_date_time = $first_time; $Absence->last_date_time = $last_time; $Absence->trainee_id = $idTrainee;
                $saveAbs = $Absence->save();
                if( $saveAbs > 0){
                    return response()->json(['success'=>"Data saved successfully."]);
                }else{
                    return response()->json(['error'=>"Error"]);
                }
            }

        }catch(Exception $e){
            return response()->json(['error'=>"Error"]);
        }
    }
}
