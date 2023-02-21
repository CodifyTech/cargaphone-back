<?php

namespace App\Http\Controllers;

use App\Exceptions\InternalServerErrorException;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class FraseController extends Controller
{
    public function index()
    {
        try {
            $frase = DB::table('frases')
                    ->inRandomOrder()
                    ->limit(1)
                    ->get();
            return response()->json($frase);
        } catch (\Exception $e) {
            throw new InternalServerErrorException();
        }
    }
}
