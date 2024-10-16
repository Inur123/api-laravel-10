<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    public function welcome()
    {
        return response()->json(['message' => 'Welcome to the API!']);
    }
}
