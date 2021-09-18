<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trainer;
use App\Models\Division;
use App\Models\Level;
use App\Models\Module;
use App\Models\Time_planning;
use Illuminate\Support\Facades\Storage;
use App\Imports\TrainersImport;
use Exception;

class trainersController extends Controller
{
    public function uploadExcel() {
        $browseTrainer = new Trainer;
        if(session('user') == 'Supervisor'){
            if($this->authorize('add', $browseTrainer)){
                return view('ismo.TableData.Trainers.import_excelTrainers');
            }
        }
    }

    public function listTrainers(){
        $browseTrainer = new Trainer;
        if(session('user') == 'Supervisor'){
            if($this->authorize('browse', $browseTrainer)){
                $trainers = Trainer::all();
                return view('ismo.TableData.Trainers.tableTrainers', compact('trainers'));
            }
        }else{
            $trainers = Trainer::all();
            return view('ismo.TableData.Trainers.tableTrainers', compact('trainers'));
        }
    }

    public function delete(Request $request){
        try{
            $id = $request->input('id');
            $d = Trainer::whereId($id)->delete();
            return $d;
        }catch(Exception $e){
            $request->session()->put('titleErreur','Error');
            return redirect('listTrainers')->with("erreur","Error while deleting trainer information");
        }
    }
    public function deleteTrainer(Request $request){
            $browseTrainer = new Trainer;
            if(session('user') == 'Supervisor'){
                if($this->authorize('delete', $browseTrainer)){
                   $d= $this->delete($request);
                    if($d == 1){
                        return redirect('listTrainers')->with("success","Trainer information has been deleted successfully");
                    }else{
                        $request->session()->put('titleErreur','Error');
                        return redirect('listTrainers')->with("erreur","Error while deleting trainer information");
                    }
                }
            }else{
                $d= $this->delete($request);
                if($d == 1){
                    return redirect('listTrainers')->with("success","Trainer information has been deleted successfully");
                }else{
                    $request->session()->put('titleErreur','Error');
                    return redirect('listTrainers')->with("erreur","Error while deleting trainer information");
                }
            }
    }

    public function deleteLotTrainers(Request $request){
        try{
            $ids = $request->ids;
            $d = Trainer::whereIn('id',explode(",",$ids))->delete();
            if($d >= 1){
                return response()->json(['success'=>"deleted successfully."]);
            }else{
                return response()->json(['error'=>"Error "]);
            }
        }catch(Exception $e){
            return response()->json(['error'=>"Error"]);
        }
    }

    public function selectFile($id){
        try{
            $data = Time_planning::find($id);
            return response()->file(Storage::path($data->file));
        }catch(Exception $e){
            return redirect('listTrainers')->with("erreur","Error while show file of time plainer");
        }
    }

    function import(Request $request)
    {
        $this->validate($request, [
        'select_file'  => 'required|mimes:xls,xlsx'
        ]);

        $file = $request->file('select_file')->store('public/filesExcel');

        if($file != null)
        {
            $traImport = new TrainersImport;
            try{
                $import = $traImport->import($file);
                if($traImport->failures()->isNotEmpty()){
                    return back()->withFailures($traImport->failures());
                }else if($import){
                    return redirect('listTrainers')->with('success', 'Excel Data Imported successfully.');
                }
            }Catch(Exception $e){
                return back()->with('erreur',$e->getMessage());
            }
        }
       // $request->session()->put('titleErreur','Error');
        return back()->with('erreur', 'erreur Imported Excel Data .');

    }


}
