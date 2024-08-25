@extends('layouts.app')

@section('content')

    <div class="container">

        <h3 align="center" class="mt-5">Employee Management</h3>

        <div class="row">
            <div class="col-md-2">
            </div>
            <div class="col-md-8">

            <div class="form-area">
                <form method="POST" action="{{ route('reservation.update', $reservation->id_resv) }}">
                {!! csrf_field() !!}
                  @method("PATCH")
                    <div class="row">
                        <div class="col-md-6">
                            <label>Date D'arrivée</label>
                            <input type="date" class="form-control" name="date_arr" value="{{ $reservation->date_arr }}">
                        </div>
                        <div class="col-md-6">
                            <label>Date de départ</label>
                            <input type="date" class="form-control" name="date_dep" value="{{ $reservation->date_dep }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label>Nbr d'adultes</label>
                            <input type="number" class="form-control" name="nbr_adultes" value="{{ $reservation->nbr_adultes }}">
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <label>Nombres d'enfants</label>
                            <input type="number" class="form-control" name="nbr_enfants">

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <label>Nombres de chambres</label>
                            <input type="number" class="form-control" name="nbr_chambres">

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <label>Prix Sans remise</label>
                            <input type="number" class="form-control" name="prix_sans_rem">

                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-12">
                            <label>Remise</label>
                            <input type="number" class="form-control" name="remise">
                        </div>
                    </div>

                    
                    <div class="row">
                        <div class="col-md-12 mt-3">
                            <input type="submit" class="btn btn-primary" value="Update">
                        </div>

                    </div>
                </form>
            </div>

            </div>
        </div>
    </div>

@endsection


@push('css')
    <style>
        .form-area{
            padding: 20px;
            margin-top: 20px;
            background-color:#b3e5fc;
        }

        .bi-trash-fill{
            color:red;
            font-size: 18px;
        }

        .bi-pencil{
            color:green;
            font-size: 18px;
            margin-left: 20px;
        }
    </style>
@endpush