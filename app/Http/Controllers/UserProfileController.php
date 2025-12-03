<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    // Tienes que envolver el código con "public function show()"
    public function show()
    {
        return view('profile.custom-show');
    }
}