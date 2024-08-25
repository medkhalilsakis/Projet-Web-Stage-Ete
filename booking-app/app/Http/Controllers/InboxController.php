<?php

namespace App\Http\Controllers;

use App\Models\Inbox;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Exception;

class InboxController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $messages = Inbox::all();
            return response()->json($messages, Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to retrieve messages'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('inbox.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nom' => 'required|string|max:255',
                'email' => 'required|string|email|max:255',
                'message' => 'required|string',
            ]);

            $inbox = new Inbox();
            $inbox->nom = $validated['nom'];
            $inbox->email = $validated['email'];
            $inbox->message = $validated['message'];
            $inbox->etat = false;
            $inbox->save();

            return response()->json(['success' => 'Message sent successfully'], Response::HTTP_CREATED);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to store message'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $message = Inbox::findOrFail($id);

            $message->etat = true;
            $message->save();

            return response()->json($message, Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Message not found'], Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to retrieve message'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $message = Inbox::findOrFail($id);
            return view('inbox.edit', compact('message'));
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Message not found'], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $validated = $request->validate([
                'nom' => 'required|string|max:255',
                'email' => 'required|string|email|max:255',
                'message' => 'required|string',
                'etat' => 'required|boolean',
            ]);

            $message = Inbox::findOrFail($id);
            $message->nom = $validated['nom'];
            $message->email = $validated['email'];
            $message->message = $validated['message'];
            $message->etat = $validated['etat'];
            $message->save();

            return response()->json(['success' => 'Message updated successfully'], Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Message not found'], Response::HTTP_NOT_FOUND);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to update message'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $message = Inbox::findOrFail($id);
            $message->delete();

            return response()->json(['success' => 'Message deleted successfully'], Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Message not found'], Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to delete message'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
