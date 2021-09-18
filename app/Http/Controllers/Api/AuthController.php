<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Trainee;
use App\Models\Trainer;
use App\Models\Division;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login(Request $request){
        try{
        $this->validate($request, [
            'login'  => 'required',
            'password'  => 'required',
        ]);
        $trainer = Trainer::whereLogin($request->login)->wherePassword($request->password)->first();
        $trainee = Trainee::whereLogin($request->login)->wherePassword($request->password)->first();

        if(!empty($trainer)){

            return response()->json([
                'success' =>1,
                'type' => 'formateur',
                'user' => $trainer
            ]);
        }else if(!empty($trainee)){

            return response()->json([
                'success' =>1,
                'type' => 'stagiaire',
                'user' => $trainee
            ]);
        }else{
            return response()->json([
                'success' => 0,
                'message' => 'invalid credintials'
            ]);
        }
        }catch(Exception $e){
            return response()->json([
                'success' => 0,
                'message' => '' . $e->getMessage()
            ]);
        }
    }

    public function divisions(){
        try{

            $filieres = Division::all();

            return response()->json([
                'success' => 1,
                'filieres' => $filieres
            ]);
        }
        catch(Exception $e){
            return response()->json([
                'success' => 0,
                'filieres' => ''.$e->getMessage()
            ]);
        }
    }

    public function InsertImageTrainee(Request $request){

        try{
            $file = $request->file('file');
            $id = $request->id;
            $path = $file->store('public/images');
            $trainee = Trainee::whereId($id)->first();
            $trainee->image = $path;
            $bool = $trainee->save();
            $success = 0;
            if($bool > 0){
                $success = 1;
            }

            return response()->json([
                'success' => $success
            ]);
        } catch(Exception $e){
            return response()->json([
                'success' => 0
            ]);
        }
    }

}
