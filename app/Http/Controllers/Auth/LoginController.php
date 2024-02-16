<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(LoginRequest $request)
    {
        // Get the user making the request
        $user = User::where('email', $request->email)->first();

        if ($user instanceof User) {
            
            // Check the hashed password
            if (Hash::check($request->password, $user->password)) {

                // Create a new token with an expiration time of a week and show the plain text just once.
                $token = $user->createToken(Str::random(12), ['*'], now()->addWeek());

                return response()->success([
                    'message' => "API Token created successfully.",
                    'token' => $token->plainTextToken,
                ]);
            }
        }

        // Fallback in case user does not exist or password does not match.
        return response()->json([
            'message' => "The provided credentials do not match our records.",
        ], 401);
    }
}
