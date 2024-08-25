<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chambre;
use App\Models\Hebergement;

class ChambreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $query = Chambre::query();

    if ($request->has('code_hb')) {
        $query->where('code_hb', $request->query('code_hb'));
    }

    $chambres = $query->get();

    return response()->json($chambres);
}
public function updateDispo(Request $request, string $num_chambre)
{
    $request->validate([
        'disponibilite' => 'required|boolean',
    ]);

    $chambre = Chambre::where('num_chambre', $num_chambre)->first();

    if (!$chambre) {
        return response()->json(['message' => 'Chambre non trouvée'], 404);
    }

    $chambre->disponibilite = $request->input('disponibilite');
    $chambre->save();

    return response()->json(['message' => 'Disponibilité mise à jour avec succès']);
}
public function GetChambresByCodeHb(string $code_hb)
{
    $chambres = Chambre::where('code_hb', $code_hb)->get();

    if($chambres->isEmpty()) {
        return response()->json(['message' => 'Aucune chambre trouvée pour cet hébergement.'], 404);
    }

    return response()->json($chambres, 200);
}



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'num_chambre' => 'required|string|unique:chambres,num_chambre',
            'code_hb' => 'required|string|exists:hebergements,code_hb',
            'disponibilite' => 'required|boolean',
            'prix_par_nuit' => 'required|numeric',
            'nb_personnes_max' => 'required|integer',
            'description' => 'required|string',
        ]);

        try {
            $hebergement = Hebergement::where('code_hb', $validatedData['code_hb'])->firstOrFail();

            $existingRoomsCount = Chambre::where('code_hb', $validatedData['code_hb'])->count();
            if ($existingRoomsCount >= $hebergement->nbr_de_chambres) {
                return response()->json([
                    'message' => 'Nombre maximum de chambres atteint pour cet hébergement.',
                ], 400);
            }

            $chambre = Chambre::create($validatedData);

            return response()->json([
                'message' => 'Chambre ajoutée avec succès!',
                'chambre' => $chambre,
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Erreur de validation.',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la création de la chambre: ', ['error' => $e->getMessage()]);
            return response()->json([
                'message' => 'Erreur lors de la création de la chambre.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $num_chambre)
    {
        $chambre = Chambre::findOrFail($num_chambre);
        return response()->json($chambre);
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $num_chambre)
    {
        $validatedData = $request->validate([
            'disponibilite' => 'sometimes|boolean',
            'prix_par_nuit' => 'sometimes|numeric',
            'nb_personnes_max' => 'sometimes|integer',
            'description' => 'sometimes|string',
        ]);
    
        try {
            $chambre = Chambre::findOrFail($num_chambre);
            $chambre->update($validatedData);
    
            return response()->json([
                'message' => 'Chambre mise à jour avec succès!',
                'chambre' => $chambre,
            ]);
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la mise à jour de la chambre: ', ['error' => $e->getMessage()]);
            return response()->json([
                'message' => 'Erreur lors de la mise à jour de la chambre.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $num_chambre)
    {
        try {
            $chambre = Chambre::findOrFail($num_chambre);
            $chambre->delete();

            return response()->json([
                'message' => 'Chambre supprimée avec succès!'
            ]);
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la suppression de la chambre: ', ['error' => $e->getMessage()]);
            return response()->json([
                'message' => 'Erreur lors de la suppression de la chambre.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function stats(Request $request)
{
    $totalChambres = Chambre::count();

    $totalChambresDisponibles = Chambre::where('disponibilite', true)->count();

    $moyennePersonnesParChambre = Chambre::avg('nb_personnes_max');

    $statsParHebergement = Hebergement::withCount([
        'chambres as total_chambres' => function ($query) {
            $query->select(\DB::raw('count(*)'));
        },
        'chambres as total_chambres_disponibles' => function ($query) {
            $query->where('disponibilite', true);
        }
    ])->get();

    return response()->json([
        'total_chambres' => $totalChambres,
        'total_chambres_disponibles' => $totalChambresDisponibles,
        'moyenne_personnes_par_chambre' => $moyennePersonnesParChambre,
        'stats_par_hebergement' => $statsParHebergement,
    ]);
}

}
