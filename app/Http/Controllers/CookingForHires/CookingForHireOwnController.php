<?php

namespace App\Http\Controllers\CookingForHires;

use App\Http\Controllers\Controller;
use App\Models\Cooking_for_hire;
use Illuminate\Http\Request;

class CookingForHireOwnController extends Controller
{
    public $model = Cooking_for_hire::class;

    public function list(Request $request)
    {
        return $this->model::where('status', 1)->get();
    }
}
