@extends('layouts.app')

@section('content')

    <div class="container">


        <h3 align="center" class="mt-5">Reservation Management</h3>

        <div class="row">
            <div class="col-md-2">
            </div>
            <div class="col-md-8">

            <div class="form-area">
                <form method="POST" action="{{ route('reservation.store') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <label>Date D'arrivée</label>
                            <input type="date" class="form-control" name="date_arr">
                        </div>
                        <div class="col-md-6">
                            <label>Date de départ</label>
                            <input type="date" class="form-control" name="date_dep">

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label>Nombres d'adultes</label>
                            <input type="number" class="form-control" name="nbr_adultes">

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
                            <input type="submit" class="btn btn-info" value="Register">
                        </div>

                    </div>
                </form>
            </div>

                <table class="table mt-5">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Employee Name</th>
                        <th scope="col">DOB</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>

                        @foreach ( $reservations as $key => $reservation )

                        <tr>
                            <td scope="col">{{ ++$key }}</td>
                            <td scope="col">{{ $reservation->date_arr }}</td>
                            <td scope="col">{{ $reservation->date_dep }}</td>
                            <td scope="col">{{ $reservation->nbr_adultes }}</td>
                            <td scope="col">

                            <a href="{{  route('reservation.edit', $reservation->id_resv) }}">
                            <button class="btn btn-primary btn-sm">
                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit
                            </button>
                            </a>
                            
                            <form action="{{ route('reservation.destroy', $reservation->id_resv) }}" method="POST" style ="display:inline">
                             @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                            </td>

                          </tr>

                        @endforeach




                    </tbody>
                  </table>
            </div>
        </div>
    </div>

@endsection


@push('css')
    <style>
        .form-area{
            padding: 20px;
            margin-top: 20px;
              background-color:#FFFF00;
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