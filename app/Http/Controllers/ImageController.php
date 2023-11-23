<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;

class ImageController extends Controller
{
    public function showUploadForm(): Application|Factory|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('pages.upload');
    }

    
}
