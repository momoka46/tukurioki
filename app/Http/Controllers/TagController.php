<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Models\Tag;


class TagController extends Controller
{

//     public function search(Request $request)
// {
//     $query = $request->input('query');
//     $tags = Tag::where('name', 'LIKE', "%{$query}%")->get();
//     return response()->json($tags);
// }
// public function store(Request $request)
// {
//     $recipe = new Recipe();
//     $recipe->name = $request->input('recipe.name');
//     // 他のレシピ情報を保存...
//     $recipe->save();

//     // タグの保存
//     $tags = json_decode($request->input('tags'), true);
//     $tagIds = [];
//     foreach ($tags as $tagName) {
//         $tag = Tag::firstOrCreate(['name' => $tagName]);
//         $tagIds[] = $tag->id;
//     }
//     $recipe->tags()->sync($tagIds);

//     return redirect('/recipes');
// }


    //
}
