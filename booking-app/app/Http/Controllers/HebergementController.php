<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hebergement;
use App\Models\Chambre;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;

class HebergementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hebergements = Hebergement::all();
        return response()->json($hebergements);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Not used as this is for API.
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'code_hb' => 'required|string|unique:hebergements,code_hb',
                'nom' => 'required|string',
                'type' => 'required|string|in:hotel,maison,appartement,villa',
                'adresse' => 'required|string',
                'nbr_de_chambres' => 'required|integer',
                'description' => 'required|string',
                'pts_forts' => 'nullable|string',
                'num_tel' => 'nullable|string',
            ]);

            $hebergement = Hebergement::create($validatedData);

            return response()->json([
                'message' => 'Hébergement ajouté avec succès.',
                'status' => 200,
                'hebergement' => $hebergement,
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Erreur de validation.',
                'errors' => $e->errors(),
            ], 422);
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return response()->json([
                    'message' => 'Erreur de duplication. Le code_hb existe déjà.',
                ], 409);
            }
            return response()->json([
                'message' => 'Erreur lors de l\'ajout de l\'hébergement.',
                'error' => $e->getMessage(),
            ], 500);
        } catch (\Exception $e) {
            \Log::error('Erreur lors de l\'ajout de l\'hébergement: ', ['error' => $e->getMessage()]);
            return response()->json([
                'message' => 'Une erreur inattendue est survenue.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $code_hb)
    {
        try {
            $hebergement = Hebergement::findOrFail($code_hb);
            return response()->json($hebergement);
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la récupération de l\'hébergement: ', ['error' => $e->getMessage()]);
            return response()->json([
                'message' => 'Hébergement non trouvé.',
                'error' => $e->getMessage(),
            ], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $code_hb)
    {
        // Not used as this is for API.
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $code_hb)
    {
        try {
            $validatedData = $request->validate([
                'nom' => 'sometimes|string',
                'type' => 'sometimes|string|in:hotel,maison,appartement,villa',
                'adresse' => 'sometimes|string',
                'nbr_de_chambres' => 'sometimes|integer',
                'description' => 'nullable|string',
                'pts_forts' => 'nullable|string',
                'num_tel' => 'nullable|string',
            ]);

            $hebergement = Hebergement::findOrFail($code_hb);
            $hebergement->update($validatedData);

            return response()->json([
                'message' => 'Hébergement mis à jour avec succès!',
                'hebergement' => $hebergement,
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Erreur de validation.',
                'errors' => $e->errors(),
            ], 422);
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return response()->json([
                    'message' => 'Erreur de duplication. Une valeur unique existe déjà.',
                ], 409);
            }
            return response()->json([
                'message' => 'Erreur lors de la mise à jour de l\'hébergement.',
                'error' => $e->getMessage(),
            ], 500);
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la mise à jour de l\'hébergement: ', ['error' => $e->getMessage()]);
            return response()->json([
                'message' => 'Erreur lors de la mise à jour de l\'hébergement.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $code_hb)
    {
        try {
            $hebergement = Hebergement::findOrFail($code_hb);
            $hebergement->delete();

            return response()->json([
                'message' => 'Hébergement supprimé avec succès!'
            ]);
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la suppression de l\'hébergement: ', ['error' => $e->getMessage()]);
            return response()->json([
                'message' => 'Erreur lors de la suppression de l\'hébergement.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getAvailableRooms()
    {
        $hebergements = Hebergement::all();
        $results = [];

        foreach ($hebergements as $hebergement) {
            $registeredRoomsCount = Chambre::where('code_hb', $hebergement->code_hb)->count();
            if ($registeredRoomsCount < $hebergement->nbr_de_chambres) {
                $results[] = $hebergement;
            }
        }

        return response()->json($results);
    }


    public function stats(Request $request)
    {
        $totalHebergements = Hebergement::count();
        $totalChambres = Chambre::count();
        $totalChambresDisponibles = Chambre::where('disponibilite', true)->count();

        $moyennePersonnesParChambre = Chambre::avg('nb_personnes_max');

        $hebergementsAvecChambresDisponibles = Hebergement::whereHas('chambres', function ($query) {
            $query->where('disponibilite', true);
        })->count();

        $statsParHebergement = Hebergement::withCount([
            'chambres as total_chambres' => function ($query) {
                $query->select(\DB::raw('count(*)'));
            },
            'chambres as total_chambres_disponibles' => function ($query) {
                $query->where('disponibilite', true);
            }
        ])->get();

        return response()->json([
            'total_hebergements' => $totalHebergements,
            'total_chambres' => $totalChambres,
            'total_chambres_disponibles' => $totalChambresDisponibles,
            'moyenne_personnes_par_chambre' => $moyennePersonnesParChambre,
            'hebergements_avec_chambres_disponibles' => $hebergementsAvecChambresDisponibles,
            'stats_par_hebergement' => $statsParHebergement,
        ]);
    }
}
