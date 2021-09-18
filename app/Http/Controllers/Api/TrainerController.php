<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use App\Models\Division;
use App\Models\Level;
use App\Models\Group;
use App\Models\Trainee;

class TrainerController extends Controller
{

    public function levels(Request $request){
        try{
            $Levs = Division::whereName($request->filiere)->firstOrFail()->levels;
            return response()->json([
                'success' => 1,
                'niveaux' => $Levs
            ]);
        }catch(Exception $e){
            return $e->getMessage();
            return response()->json([
                'success' => 0,
                'niveaux' => ''.$e->getMessage()
            ]);
        }
    }

    public function groups(Request $request){
        try{
            $Grps = Level::whereId($request->levelId)->firstOrFail()->groups;
            return response()->json([
                'success' => 1,
                'groupes' => $Grps
            ]);
        }catch(Exception $e){
            return $e->getMessage();
            return response()->json([
                'success' => 0,
                'groupes' => ''.$e->getMessage()
            ]);
        }
    }

    public function stagiaires(Request $request){
        try{
            $Stags = Group::whereId($request->groupeId)->firstOrFail()->trainees;
            return response()->json([
                'success' => 1,
                'stagiaires' => $Stags
            ]);
        }catch(Exception $e){
            return $e->getMessage();
            return response()->json([
                'success' => 0,
                'stagiaires' => ''.$e->getMessage()
            ]);
        }
    }

    public function absences(Request $request){
        try{
            $Stags = Trainee::whereId($request->stagiaireId)->firstOrFail()->absences_delayes;
            return response()->json([
                'success' => 1,
                'absences' => $Stags
            ]);
        }catch(Exception $e){
            return $e->getMessage();
            return response()->json([
                'success' => 0,
                'absences' => ''.$e->getMessage()
            ]);
        }
    }

}
