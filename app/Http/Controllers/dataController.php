<?php

namespace App\Http\Controllers;

use App\Models\Trainee;
use App\Models\Account;
use App\Models\Division;
use App\Models\Level;
use App\Models\Group;
use App\Http\Controllers\Methodes\Functions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Imports\TraineesImport;
use Exception;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class dataController extends Controller
{

    public function listTrainee(){
        $trainees = Group::whereId(session('idGroup'))->firstOrFail()->trainees;
        $listTrainees = array();
        $i = 0;
        foreach ($trainees as $trainee){
        $account = Account::whereId($trainee->id)->first();
        $list = array_merge((array)json_decode($trainee),(array)json_decode($account));
        $listTrainees[$i] =$list;
        $i++;
        }
        $object = json_decode(json_encode($listTrainees), FALSE);
        return view('ismo.TableData.tableData', ['listTrainees' => $object]);
    }

    public function addUpdateTrainee($id = null)
    {
        $browseTrainee = new Trainee;
    //    if(session('user') == 'Supervisor'){
            if($this->authorize('edit', $browseTrainee)){
                if($id == null){
                    return view('ismo.admin.addTrainee');
                }else{
                    $trainee = Trainee::whereId($id)->first();
                    $account = Account::whereId($id)->first();
                    return view('ismo.admin.addTrainee', ['trainee' => $trainee,'account' => $account]);
                }
            }
    /*    }else{
            if($id == null){
                return view('ismo.admin.addTrainee');
            }else{
                $trainee = Trainee::whereId($id)->first();
                $account = Account::whereId($id)->first();
                return view('ismo.admin.addTrainee', ['trainee' => $trainee,'account' => $account]);
            }
        } */
    }

    public function choiceUpload() {
        $browseTrainee = new Trainee;
        if(session('user') == 'Supervisor'){
            if($this->authorize('add', $browseTrainee)){
                return view('ismo/TableData/choiceUpload');
            }
        }else{
            return view('ismo/TableData/choiceUpload');
        }
    }

    public function addTrainee(Request $request)
    {
        $index = $request->input('index');

        $this->validate($request, [
            'id'  => ['required','min:5','max:10',Rule::unique('trainees','id')->ignore($index)],
            'first_name'  => 'required|min:3|max:25',
            'last_name'  => 'required|min:3|max:25',
            'age'  => 'required|integer',
            'email' => ['required','email:rfc,dns',Rule::unique('trainees','email')->ignore($index)],
            'gender' => ['required',
            function ($attribute, $value, $fail) {
                if (Str::of($value)->lower() != 'male' && Str::of($value)->lower() != 'female' ) {
                    $fail('The '.$attribute.' is invalid.');
                }
            },],
            'login' => ['required','string','min:8','max:25'],
            'password' => ['required', Password::min(8)->mixedCase(),'max:35'],
        ]);

        if(!empty($index)){
            try{
                $array = array_slice($request->all(),2);
                $arrayTrainee = array_slice($array,0,6);
                $idAcc = array_slice($request->all(),2,1);
                $array1 = array_slice($array, 6);
                if($idAcc != null){
                $arrayAcc = array_merge($idAcc,$array1);
                }
                $boll = Trainee::whereId($index)->update($arrayTrainee);
                $bollAcc = Account::whereId($index)->update($arrayAcc);
                $request->session()->get('name');
                if($boll == 1 && $bollAcc == 1){
                    return redirect('listTrainee')->with("success","Trainee information updated successfully" );
                }else{
                    $request->session()->put('titleErreur','Error');
                    return redirect('listTrainee')->with("erreur","Error when updating trainee information");
                }
            }catch(Exception $e){
                $request->session()->put('titleErreur','Error');
                return redirect('listTrainee')->with("erreur","Error when updating trainee information");
            }
        }else{
            $code = Trainee::whereId($request->input('id'))->first();
            $trainee = new Trainee();
            $func = new Functions();
            $grp_id = $request->session()->get('idGroup');

            $obj = $func -> createObj($trainee,$request,$grp_id);
            if($code == null){
                try{
                    $b = $obj->save();
                    if($b == 1){
                        return redirect('listTrainee')->with("success","Trainee information saved successfully");
                    }else{
                        $request->session()->put('titleErreur','Error');
                        return redirect('listTrainee')->with("erreur","Error while saving trainee information");
                    }
                }catch(Exception $e){
                    $request->session()->put('titleErreur','Error');
                    return redirect('listTrainee')->with("erreur","Error while saving trainee information");
                }
            }else {
                $request->session()->put('titleErreur','Error when add tarinee information');
                return redirect('tableData')->with("erreur","Trainee code already exists " );
            }
        }
    }

    public function delete(Request $request){
        try{
            $id = $request->input('id');
            $d = Trainee::whereId($id)->delete();
            if($d == 1){
                return redirect('tableData')->with("success","Trainee information has been deleted successfully");
            }else{
                $request->session()->put('titleErreur','Error');
                return redirect('tableData')->with("erreur","Error while deleting trainee information");
            }
        }catch(Exception $e){
            $request->session()->put('titleErreur','Error');
            return redirect('tableData')->with("erreur","Error while deleting trainee information");
        }
    }

    public function deleteTrainee(Request $request){
        $browseTrainee = new Trainee;
            if(session('user') == 'Supervisor'){
                if($this->authorize('delete', $browseTrainee)){
                    $this->delete($request);
                }
            }else{
                $this->delete($request);
            }
    }

    public function deleteLotTrainees(Request $request){
        try{
            $ids = $request->ids;
            $d = Trainee::whereIn('id',explode(",",$ids))->delete();
            if($d >= 1){
                return response()->json(['success'=>"deleted successfully."]);
            }else{
                return response()->json(['error'=>"Error "]);
            }
        }catch(Exception $e){
            return response()->json(['error'=>"Error"]);
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
            $traImport = new TraineesImport;
            try{
                $import = $traImport->import($file);
                if($traImport->failures()->isNotEmpty()){
                    return back()->withFailures($traImport->failures());
                }else if($import){
                    return redirect('listTrainee')->with('success', 'Excel Data Imported successfully.');
                }
            }Catch(Exception $e){
                return back()->with('erreur',$e->getMessage());
            }
        }
       // $request->session()->put('titleErreur','Error');
        return back()->with('erreur', 'erreur Imported Excel Data .');

    }
}
