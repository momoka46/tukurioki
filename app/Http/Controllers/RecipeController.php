<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use Cloudinary;
use App\Models\Step;
use Auth;


class RecipeController extends Controller
{
    public function index(Recipe $recipe)
{
    return $recipe->get();
}

public function create()
{
    return view('recipes.create');
}

public function store(Request $request, Recipe $recipe)
    {
       
        //dd($request);
        // //cloudinaryへ画像を送信し、画像のURLを$image_urlに代入している
         $image_url = Cloudinary::upload($request->file('image')->getRealPath())->getSecurePath();
        //dd($image_url);  //画像のURLを画面に表示
        
        $input = $request['recipe'];
       
       
        $input += ['image' => $image_url];   //追加
        $input["user_id" ] = Auth()->id();//連想配列
        //dd($input);
        $recipe->fill($input)->save();

        //stepの保存方法for
        $textInput=$request->input("step");

        foreach($textInput as $index=>$stepText){
            $step=new Step;
            //
            $step->fill( [
                //'recipe_id' => $recipe->id, // 保存したレシピのIDをセット
                'number' => $index + 1, // インデックスを使用してnumberを設定
                'step' => $stepText, // 手順のテキストをセット
            ]);$recipe->steps()->save($step); // リレーション経由で保存
        }
        

        return redirect('/recipes/' . $recipe->id);
    }

    public function show(Recipe $recipe)
    {
        $steps = $recipe->steps;
        // return view('/recipes/show')->with(['recipe' => $recipe]);
    return view('recipes.show', compact('recipe', 'steps')); // $stepsをビューに渡す
    
}

}