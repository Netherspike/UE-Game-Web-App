<?php

declare(strict_types=1);

namespace App\Http\Controllers\UE;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UEAuthController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
   public function login(LoginRequest $request): JsonResponse
   {
       if (Auth::attempt($request->validated())) {
           $token = $request->user()->createToken('ue-token');
           return response()->json(['user_id' => Auth::id(), 'token' => $token->plainTextToken], 200);
       }

       return response()->json(['error' => 'Unauthorized'], 401);
   }
}
