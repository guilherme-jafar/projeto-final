<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContaProfessorController extends Controller
{
    public function register(Request $request){


        return response()->json([
            'message' => 'New post created'
        ]);
    }


}
