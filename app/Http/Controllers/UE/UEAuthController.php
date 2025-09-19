<?php

declare(strict_types=1);

namespace App\Http\Controllers\UE;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\LoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UEAuthController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        $user = User::where('email', $request->email)->first();
        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'Unauthorized'], 401);
            /*throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);*/
        }
        $token = $user->createToken('ue-token-' . $user->id)->plainTextToken;
        return response()->json(['user_id' => $user->id, 'token' => $token], 200);
    }

    public function user(Request $request): JsonResponse
    {
        return response()->json($request->user());
    }

    public function refresh(Request $request): JsonResponse
    {
        $user = $request->user();
        // Revoke all tokens...
        $user->tokens()->delete();
        // ...then create a new one
        $newToken = $user->createToken('ue-token');

        return response()->json(['token' => $newToken->plainTextToken]);
    }

    public function logout(Request $request): JsonResponse
    {
        // TODO: save game data on logout/client disconnect
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Successfully logged out']);
    }
}
