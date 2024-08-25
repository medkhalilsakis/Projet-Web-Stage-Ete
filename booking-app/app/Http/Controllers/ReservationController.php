<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{
    protected $reservation;

    public function __construct()
    {
        $this->reservation = new Reservation();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reservations = $this->reservation->all();
        return response()->json([
            'reservations' => $reservations,
            'message' => 'Liste des réservations',
            'status' => 200
        ]);
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
        $validatedData = $request->validate([
            'date_arr' => 'required|date',
            'date_dep' => 'required|date',
            'client' => 'required|string',
            'nbr_adultes' => 'required|integer',
            'nbr_enfants' => 'required|integer',
            'nbr_chambres' => 'required|integer',
            'code_hb' => 'required|string|exists:hebergements,code_hb',
            'num_chambre' => 'required|string|exists:chambres,num_chambre',
            'prix_total' => 'required|numeric',
        ]);

        try {
            $reservation = $this->reservation->create($validatedData);

            return response()->json([
                'message' => 'Réservation créée avec succès!',
                'reservation' => $reservation,
            ], 201);
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la création de la réservation: ', ['error' => $e->getMessage()]);
            return response()->json([
                'message' => 'Erreur lors de la création de la réservation.',
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
            $reservations = $this->reservation->where('code_hb', $code_hb)->get();
    
            if ($reservations->isEmpty()) {
                return response()->json([
                    'message' => 'Aucune réservation trouvée pour cet hébergement.',
                    'status' => 404
                ], 404);
            }
    
            return response()->json([
                'reservations' => $reservations,
                'message' => 'Liste des réservations pour cet hébergement',
                'status' => 200
            ]);
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la récupération des réservations: ', ['error' => $e->getMessage()]);
            return response()->json([
                'message' => 'Erreur lors de la récupération des réservations.',
                'error' => $e->getMessage(),
                'status' => 500
            ], 500);
        }
    }



    public function showByCh(string $code_hb, string $num_chambre)
    {
        try {
            $reservations = $this->reservation->where('code_hb', $code_hb)
                                              ->where('num_chambre', $num_chambre)
                                              ->get();
    
            if ($reservations->isEmpty()) {
                return response()->json([
                    'message' => 'Aucune réservation trouvée pour cet hébergement et cette chambre.',
                    'status' => 404
                ], 404);
            }
    
            return response()->json([
                'reservations' => $reservations,
                'message' => 'Liste des réservations pour cet hébergement et cette chambre',
                'status' => 200
            ]);
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la récupération des réservations: ', ['error' => $e->getMessage()]);
            return response()->json([
                'message' => 'Erreur lors de la récupération des réservations.',
                'error' => $e->getMessage(),
                'status' => 500
            ], 500);
        }
    }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        // Not used as this is for API.
    }

    /**
     * Update a reservation via JSON request.
     */
    public function update(Request $request, int $id)
    {
        $validatedData = $request->validate([
            'client' => 'sometimes|string', 
            'date_arr' => 'required|date',
            'date_dep' => 'required|date',
            'nbr_adultes' => 'required|integer',
            'nbr_enfants' => 'required|integer',
            'nbr_chambres' => 'required|integer',
            'prix_total' => 'required|numeric',   
        ]);

        try {
            $reservation = $this->reservation->findOrFail($id);
            $reservation->update($validatedData);

            return response()->json([
                'message' => 'Réservation mise à jour avec succès!',
                'reservation' => $reservation,
                'status' => 200
            ]);
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la mise à jour de la réservation: ', ['error' => $e->getMessage()]);
            return response()->json([
                'message' => 'Erreur lors de la mise à jour de la réservation.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete a reservation via JSON request.
     */
    public function delete(int $id)
    {
        try {
            $reservation = $this->reservation->findOrFail($id);
            $reservation->delete();

            return response()->json([
                'message' => 'Réservation supprimée avec succès!',
                'status' => 200
            ]);
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la suppression de la réservation: ', ['error' => $e->getMessage()]);
            return response()->json([
                'message' => 'Erreur lors de la suppression de la réservation.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function GetResByClient(string $idcard)
    {
        try {
            $reservations = $this->reservation->where('client', $idcard)->get();
    
            if ($reservations->isEmpty()) {
                return response()->json([
                    'message' => 'Aucune réservation trouvée pour ce client.',
                    'status' => 404
                ], 404);
            }
    
            return response()->json([
                'reservations' => $reservations,
                'message' => 'Liste des réservations pour ce client',
                'status' => 200
            ]);
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la récupération des réservations: ', ['error' => $e->getMessage()]);
            return response()->json([
                'message' => 'Erreur lors de la récupération des réservations.',
                'error' => $e->getMessage(),
                'status' => 500
            ], 500);
        }
    }

    public function stats()
{
    try {
        $totalReservations = $this->reservation->count();

        $reservationsByHebergement = $this->reservation->select('code_hb', DB::raw('count(*) as total'))
            ->groupBy('code_hb')
            ->get();

        $reservationsByChambre = $this->reservation->select('num_chambre', DB::raw('count(*) as total'))
            ->groupBy('num_chambre')
            ->get();

        $reservationsByNumber = $this->reservation->select(DB::raw('nbr_adultes, nbr_enfants, count(*) as total'))
            ->groupBy('nbr_adultes', 'nbr_enfants')
            ->get();

        $reservationsByPeriod = DB::table('reservations')
            ->select(DB::raw('DATE_FORMAT(date_arr, "%Y-%m") as period, count(*) as total'))
            ->groupBy('period')
            ->get();

        return response()->json([
            'total_reservations' => $totalReservations,
            'reservations_by_hebergement' => $reservationsByHebergement,
            'reservations_by_chambre' => $reservationsByChambre,
            'reservations_by_number' => $reservationsByNumber,
            'reservations_by_period' => $reservationsByPeriod,
            'message' => 'Statistiques des réservations',
            'status' => 200
        ]);
    } catch (\Exception $e) {
        \Log::error('Erreur lors de la récupération des statistiques de réservations: ', ['error' => $e->getMessage()]);
        return response()->json([
            'message' => 'Erreur lors de la récupération des statistiques de réservations.',
            'error' => $e->getMessage(),
            'status' => 500
        ], 500);
    }
}

}
