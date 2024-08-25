<!-- resources/views/pages/show.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Reservation Details</h3>
        <div>
            <p><strong>Date d'arrivée:</strong> {{ $reservation->date_arr }}</p>
            <p><strong>Date de départ:</strong> {{ $reservation->date_dep }}</p>
            <p><strong>Nombre d'adultes:</strong> {{ $reservation->nbr_adultes }}</p>
            <p><strong>Nombre d'enfants:</strong> {{ $reservation->nbr_enfants }}</p>
            <p><strong>Nombre de chambres:</strong> {{ $reservation->nbr_chambres }}</p>
            <p><strong>Prix sans remise:</strong> {{ $reservation->prix_sans_rem }}</p>
            <p><strong>Remise:</strong> {{ $reservation->remise }}</p>
        </div>
        <a href="{{ route('reservation.index') }}" class="btn btn-secondary">Back to List</a>
    </div>
@endsection
