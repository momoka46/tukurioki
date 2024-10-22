<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;

class RecipeController extends Controller
{
    public function index(Recipe $recipe)//インポートしたPostをインスタンス化して$postとして使用。
{
    return $recipe->get();//$recipeの中身を戻り値にする。
}

    
}

