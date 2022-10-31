<?php

namespace App\Http\Controllers\params;

use App\Http\Controllers\Controller;
use App\Models\Correction;
use Illuminate\Http\Request;

class CorrectionController extends Controller
{
    public function list(Request $request)
    {
        return Correction::get();
    }
}
