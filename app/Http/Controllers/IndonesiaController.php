<?php

namespace App\Http\Controllers;

use App\Models\Indonesia;
use Illuminate\Http\Request;

class IndonesiaController extends Controller
{
    public function index()
    {
        $indonesia = Indonesia::get();
        return response([
            'data' => $indonesia
        ], 200);
    }
}
