<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SessionController extends Controller
{
    // Start a new chat session and return a unique session ID
    public function generateSession(Request $request)
    {
        $sessionId = Str::uuid()->toString();

        return response()->json([
            'session_id' => $sessionId
        ]);
    }
}
