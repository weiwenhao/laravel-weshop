<?php

namespace App\Http\Controllers;

use App\Models\Active;
use Illuminate\Http\Request;

class ActiveController extends Controller
{
    public function show($active_id)
    {
        $active = Active::find($active_id);
        return view('active.show', compact('active'));
    }
}
