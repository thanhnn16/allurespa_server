<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;

class ImageController extends Controller
{

    public function userImageUpload(Request $request): string
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $image = $request->file('image');
        $imageName = time() . '.' . $image->extension();

        $imagePath = public_path('uploads/img/users/avatar/' . $imageName);

        Image::make($image)->resize(300, 300, function ($constrain) {
            $constrain->aspectRatio();
        })->encode('jpg')->save($imagePath);

        return $imagePath;
    }
}
