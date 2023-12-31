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

    public function deleteUserAvatar($imageName): bool
    {
        $imagePath = public_path('uploads/img/users/avatar/' . $imageName);
        if (file_exists($imagePath)) {
            @unlink($imagePath);
            return true;
        }
        return false;
    }

    public function cosmeticImageUpload(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $image = $request->file('image');
        $imageName = time() . '.' . $image->extension();

        $imagePath = public_path('uploads/img/cosmetics/' . $imageName);

        Image::make($image)->resize(300, 300, function ($constrain) {
            $constrain->aspectRatio();
        })->encode('jpg')->save($imagePath);

        return $imagePath;

    }
}
