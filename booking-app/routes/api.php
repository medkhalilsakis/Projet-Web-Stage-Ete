<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\HebergementController;
use App\Http\Controllers\ChambreController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\OffreController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\InboxController;

// Routes pour les images
Route::post('images', [ImageController::class, 'store']);
Route::get('images/{code_hb}', [ImageController::class, 'show']);
Route::delete('images/{code_hb}', [ImageController::class, 'destroy']);
Route::get('images/chambre/{num_chambre}', [ImageController::class, 'ImagesByCh']);
Route::get('/images/existence/{code_hb}', [ImageController::class, 'verifExistence']);
Route::get('/images/existence2/{num_chambre}', [ImageController::class, 'verifExistenceCh']);
Route::delete('/images/deletebyID/{id}', [ImageController::class, 'destroyById']);
Route::delete('/images/deletebyID2/{num_chambre}', [ImageController::class, 'destroyByNumCh']);

// Routes pour les réservations
Route::get('reservations', [ReservationController::class, 'index']);
Route::post('reservations', [ReservationController::class, 'store']);
Route::get('reservations/{code_hb}', [ReservationController::class, 'show']);
Route::get('reservations/{code_hb}/chambre/{num_chambre}', [ReservationController::class, 'showByCh']);
Route::get('reservations/client/{idcard}', [ReservationController::class, 'GetResByClient']);
Route::put('reservations/{id}', [ReservationController::class, 'update']);
Route::delete('reservations/{id}', [ReservationController::class, 'delete']);
Route::delete('reservations/client/{idcard}', [ReservationController::class, 'DeleteResByClient']);
Route::get('reservationstats', [ReservationController::class, 'stats']);


// Routes pour les hébergements
Route::post('hebergements', [HebergementController::class, 'store']);
Route::get('hebergements', [HebergementController::class, 'index']);
Route::get('hebergements/{code_hb}', [HebergementController::class, 'show']);
Route::delete('hebergements/{code_hb}', [HebergementController::class, 'destroy']);
Route::put('hebergements/{code_hb}', [HebergementController::class, 'update']);
Route::get('/hebergements/available', [HebergementController::class, 'getAvailableRooms']);
Route::get('hebergementstats', [HebergementController::class, 'stats']);

// Routes pour les chambres
Route::get('chambres', [ChambreController::class, 'index']);
Route::post('chambres', [ChambreController::class, 'store']); 
Route::get('chambres/{num_chambre}', [ChambreController::class, 'show']); 
Route::get('chambres/heb/{code_hb}', [ChambreController::class, 'GetChambresByCodeHb']); 
Route::put('chambres/{num_chambre}', [ChambreController::class, 'update']);
Route::put('chambres/dispo/{num_chambre}', [ChambreController::class, 'updateDispo']);
Route::delete('chambres/{num_chambre}', [ChambreController::class, 'destroy']);
Route::get('chambresstat', [ChambreController::class, 'stats']);

// Routes pour les utilisateurs

Route::get('users', [UserController::class, 'index']); 
Route::get('users/{idcard}', [UserController::class, 'edit']); 
Route::put('users/{id}', [UserController::class, 'update']);
Route::delete('users/{id}', [UserController::class, 'destroy']);
Route::post('users', [UserController::class, 'store']);
Route::post('login', [UserController::class, 'login']);
Route::get('usersstats', [UserController::class, 'stats']); 


Route::get('blogs', [BlogController::class, 'index']);  
Route::get('blogsalea', [BlogController::class, 'alea']);  
Route::post('blogs', [BlogController::class, 'store']);  
Route::get('blogs/{id}', [BlogController::class, 'show']);  
Route::put('blogs/{id}', [BlogController::class, 'update']);  
Route::delete('blogs/{id}', [BlogController::class, 'destroy']);  
Route::get('blogstags', [BlogController::class, 'Tags']);  
Route::get('blogscategories', [BlogController::class, 'Categories']);  


Route::get('/offres', [OffreController::class, 'index']);
Route::post('/offres', [OffreController::class, 'store']);
Route::get('/offres/{id}', [OffreController::class, 'show']);
Route::put('/offres/{id}', [OffreController::class, 'update']);
Route::delete('/offres/{id}', [OffreController::class, 'destroy']);


Route::post('inbox', [InboxController::class, 'store']); 
Route::get('inbox', [InboxController::class, 'index']);
Route::get('inbox/{id}', [InboxController::class, 'show']); 
Route::put('inbox/{id}', [InboxController::class, 'update']);
Route::delete('inbox/{id}', [InboxController::class, 'destroy']);
