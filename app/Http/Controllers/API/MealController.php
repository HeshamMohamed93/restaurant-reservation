<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Meal;

class MealController extends Controller
{
    public function listMenuItems()
    {
        $meals = Meal::paginate(10);
        return response()->json($meals);
    }
}
