<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function store()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }
}
