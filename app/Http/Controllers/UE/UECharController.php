<?php

declare(strict_types=1);

namespace App\Http\Controllers\UE;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class UECharController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(Auth::user()->characters);
    }
}
