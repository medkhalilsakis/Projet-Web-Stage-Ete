<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Image;

class ImageController extends Controller
{
    /**
     * Store a newly created image in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
{
    $request->validate([
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'code_hb' => 'nullable|string|exists:hebergements,code_hb',
        'num_chambre' => 'nullable|string|exists:chambres,num_chambre',
    ]);

    $image = $request->file('image');
    $originalName = $image->getClientOriginalName();

    $fileName = uniqid() . '.' . $image->getClientOriginalExtension();

    $path = $image->storeAs('public/uploads/images', $fileName);

    $newImage = Image::create([
        'name' => $originalName,
        'path' => $fileName, 
        'mime_type' => $image->getClientMimeType(),
        'size' => $image->getSize(),
        'code_hb' => $request->input('code_hb'),
        'num_chambre' => $request->input('num_chambre'),
    ]);

    return response()->json([
        'name' => $newImage->name,
        'path' => $fileName, 
    ], 201);
}

    /**
     * Display the specified resource.
     */
    public function show(string $code_hb)
{
    try {
        $images = Image::where('code_hb', $code_hb)->get();
        
        if ($images->isEmpty()) {
            return response()->json(['error' => 'No images found for the given code_hb'], 404);
        }
        
        return response()->json($images, 200);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Failed to retrieve images: ' . $e->getMessage()], 500);
    }
}

    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $code_hb)
    {
    try {
        $images = Image::where('code_hb', $code_hb)->get();

        if ($images->isEmpty()) {
            return response()->json(['error' => 'No images found for the given code_hb'], 404);
        }else{

            foreach ($images as $image) {
                Storage::delete('public/uploads/images/' . $image->path);
                $image->delete();
            }

            return response()->json(['message' => 'Images deleted successfully!'], 200);
        }
    } catch (\Exception $e) {
        return response()->json(['error' => 'Failed to delete images: ' . $e->getMessage()], 500);
    }
}

    public function verifExistence(string $code_hb)
    {
        $imageExists = Image::where('code_hb', $code_hb)->exists();

        if ($imageExists) {
            return response()->json(['exists' => true], 200);
        } else {
            return response()->json(['exists' => false], 200);
        }
    }


    public function verifExistenceCh(string $num_chambre)
    {
        $imageExists = Image::where('num_chambre', $num_chambre)->exists();

        if ($imageExists) {
            return response()->json(['exists' => true], 200);
        } else {
            return response()->json(['exists' => false], 200);
        }
    }


    public function destroyById($id)
    {
        try {
            $image = Image::find($id);

            if (!$image) {
                return response()->json(['error' => 'Image not found'], 404);
            }

            Storage::delete('public/uploads/images/' . $image->path);

            $image->delete();

            return response()->json(['message' => 'Image deleted successfully!'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete image: ' . $e->getMessage()], 500);
        }
    }

    public function destroyByNumCh(string $num_chambre)
    {
        try {
            $images = Image::where('num_chambre', $num_chambre)->get();
    
            if ($images->isEmpty()) {
                return response()->json(['error' => 'No images found for the given code_hb'], 404);
            }else{
    
                foreach ($images as $image) {
                    Storage::delete('public/uploads/images/' . $image->path);
                    $image->delete();
                }
    
                return response()->json(['message' => 'Images deleted successfully!'], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete images: ' . $e->getMessage()], 500);
        }
    }

    public function ImagesByCh(string $num_chambre)
{
    try {
        $images = Image::where('num_chambre', $num_chambre)->get();
        
        if ($images->isEmpty()) {
            return response()->json(['error' => 'No images found for the given room number'], 404);
        }
        
        return response()->json($images, 200);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Failed to retrieve images: ' . $e->getMessage()], 500);
    }
}



}


