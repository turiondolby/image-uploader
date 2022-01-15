<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ImageController extends Controller
{
    public function index()
    {
        return view('images.index');
    }

    public function show()
    {
        //return all images
    }

    public function store(Request $request)
    {
        //validate the incoming file
        $request->validate([
            'image' => 'bail|required|file|image'
        ]);

        //save the file in storage
        $path = $request->file('image')->store('public/images');

        if (! $path) {
            return response()->json(['error' => 'The file could not be saved.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $uploadedFile =$request->file('image');

        //create image model
        $image = Image::create([
            'name' => $uploadedFile->hashName(),
            'extension' => $uploadedFile->extension(),
            'size' => $uploadedFile->getSize()
        ]);

        //return image model back to the frontend
        return $image;
    }
}
