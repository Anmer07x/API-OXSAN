<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResultadosController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the authenticated patient's results.
     *
     * Only returns results that have been validated (signed).
     */
    public function index()
    {
        $user = auth('api')->user();

        // Retrieve results for the user, applying the 'signed' scope
        $resultados = $user->resultados()->signed()->orderBy('fecha_examen', 'desc')->get();

        return response()->json($resultados);
    }
}
