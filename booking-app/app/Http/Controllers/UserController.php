<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Dashuser;

use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = Dashuser::all();
        return response()->json($users);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'date_naiss' => 'required|date',
            'IDCARD' => 'required|string',
            'nationalite' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string',
            'genre' => 'required|string',
        ]);

        $existingUser = $this->VerifExistance($request->IDCARD);
        if ($existingUser) {
            return response()->json(['error' => 'Utilisateur avec ce IDCARD existe déjà'], 409);
        }else{
            $uniqueEmail = $this->verifuniquemail($request->email);
            if ($uniqueEmail) {
                return response()->json(['error' => 'Adresse email déjà utilisée'], 409);
            }else{
                $user = Dashuser::create([
                    'nom' => $request->nom,
                    'prenom' => $request->prenom,
                    'date_naiss' => $request->date_naiss,
                    'IDCARD' => $request->IDCARD,
                    'nationalite' => $request->nationalite,
                    'email' => $request->email,
                    'password' => bcrypt($request->password),
                    'genre' => $request->genre,
                ]);
            
                return response()->json(['message' => 'Utilisateur créé avec succès', 'user' => $user], 201);
            }
        }       
    }

    /**
     * Vérifie l'existence d'un utilisateur par IDCARD.
     */
    private function VerifExistance($idCard)
    {
        return Dashuser::where('IDCARD', $idCard)->exists();
    }

    /**
     * Vérifie l'unicité d'une adresse email.
     */
    private function verifuniquemail($email)
    {
        return Dashuser::where('email', $email)->exists();
    }

    public function login(Request $request)
    {
        $email = $request->email;
        $pwd = $request->password;
    
        $user = Dashuser::where('email', $email)->first();
    
        if ($user) {
            if (Hash::check($pwd, $user->password)) {
                return response()->json(['message' => 'Authentification réussie', 'user' => $user], 200);
            } else {
                return response()->json([
                    'error' => 'Identifiants incorrects'
                ], 401);
            }
        } else {
            return response()->json([
                'error' => 'Identifiants incorrects'
            ], 401);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $idcard)
    {
        try {
            $user = Dashuser::where('IDCARD', $idcard)->first();
    
            if ($user) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Utilisateur trouvé',
                    'data' => $user
                ]);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'Utilisateur non trouvé'
                ], 404);
            }
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la récupération de l\'utilisateur: ', ['error' => $e->getMessage()]);
            return response()->json([
                'status' => 500,
                'message' => 'Erreur interne du serveur',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nom' => 'sometimes|required|string',
            'prenom' => 'sometimes|required|string',
            'date_naiss' => 'sometimes|required|date',
            'IDCARD' => 'sometimes|required|string',
            'nationalite' => 'sometimes|required|string',
            'email' => 'sometimes|required|email',
            'password' => 'sometimes|nullable|string',
            'genre' => 'sometimes|required|string',
        ]);

        $user = Dashuser::find($id);
        if (!$user) {
            return response()->json(['error' => 'Utilisateur non trouvé'], 404);
        }

        $user->nom = $request->input('nom', $user->nom);
        $user->prenom = $request->input('prenom', $user->prenom);
        $user->date_naiss = $request->input('date_naiss', $user->date_naiss);
        $user->IDCARD = $request->input('IDCARD', $user->IDCARD);
        $user->nationalite = $request->input('nationalite', $user->nationalite);
        $user->email = $request->input('email', $user->email);
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }
        $user->genre = $request->input('genre', $user->genre);

        $user->save();

        return response()->json(['message' => 'Utilisateur mis à jour avec succès', 'user' => $user], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = Dashuser::find($id);
        if ($user) {
            $user->delete();
            return response()->json(['message' => 'Utilisateur supprimé avec succès'], 200);
        } else {
            return response()->json(['error' => 'Utilisateur non trouvé'], 404);
        }
    }

    public function stats(Request $request)
    {
        $totalUsers = Dashuser::count();
        $usersByGenre = Dashuser::select('genre', DB::raw('count(*) as total'))
            ->groupBy('genre')
            ->get();
    
        $usersByNationality = Dashuser::select('nationalite', DB::raw('count(*) as total'))
            ->groupBy('nationalite')
            ->get();
    
        $averageAge = DB::table('dashusers')
            ->select(DB::raw('AVG(TIMESTAMPDIFF(YEAR, date_naiss, CURDATE())) as average_age'))
            ->value('average_age');
    
        $usersByAge = DB::table('dashusers')
            ->select(DB::raw("
                SUM(CASE WHEN TIMESTAMPDIFF(YEAR, date_naiss, CURDATE()) < 20 THEN 1 ELSE 0 END) AS 'under_20',
                SUM(CASE WHEN TIMESTAMPDIFF(YEAR, date_naiss, CURDATE()) BETWEEN 20 AND 39 THEN 1 ELSE 0 END) AS '20_39',
                SUM(CASE WHEN TIMESTAMPDIFF(YEAR, date_naiss, CURDATE()) BETWEEN 40 AND 59 THEN 1 ELSE 0 END) AS '40_59',
                SUM(CASE WHEN TIMESTAMPDIFF(YEAR, date_naiss, CURDATE()) >= 60 THEN 1 ELSE 0 END) AS '60_and_over'
            "))
            ->first();
    
        return response()->json([
            'total_users' => $totalUsers,
            'users_by_genre' => $usersByGenre,
            'users_by_nationality' => $usersByNationality,
            'average_age' => $averageAge,
            'users_by_age' => $usersByAge
        ]);
    }
    

}
