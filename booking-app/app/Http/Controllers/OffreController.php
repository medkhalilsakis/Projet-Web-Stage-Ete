<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Offre;
use Illuminate\Support\Str;

class OffreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $offres = Offre::all();
        return response()->json($offres);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'date_deb' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_deb',
            'image' => 'required|string|max:255',
        ]);

        $offre = new Offre();
        $offre->id_offre = Str::uuid(); 
        $offre->titre = $validatedData['titre'];
        $offre->description = $validatedData['description'];
        $offre->date_deb = $validatedData['date_deb'];
        $offre->date_fin = $validatedData['date_fin'];
        $offre->image = $validatedData['image'];
        $offre->save();

        return response()->json(['message' => 'Offre créée avec succès', 'offre' => $offre], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $offre = Offre::find($id);
        if ($offre) {
            return response()->json($offre);
        } else {
            return response()->json(['message' => 'Offre non trouvée'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'date_deb' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_deb',
            'image' => 'required|string|max:255',
        ]);

        $offre = Offre::find($id);
        if ($offre) {
            $offre->titre = $validatedData['titre'];
            $offre->description = $validatedData['description'];
            $offre->date_deb = $validatedData['date_deb'];
            $offre->date_fin = $validatedData['date_fin'];
            $offre->image = $validatedData['image'];
            $offre->save();

            return response()->json(['message' => 'Offre mise à jour avec succès', 'offre' => $offre]);
        } else {
            return response()->json(['message' => 'Offre non trouvée'], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $offre = Offre::find($id);
        if ($offre) {
            $offre->delete();
            return response()->json(['message' => 'Offre supprimée avec succès']);
        } else {
            return response()->json(['message' => 'Offre non trouvée'], 404);
        }
    }
}
