<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use Cloudinary;
use App\Models\Step;
use App\Models\User;
use App\Models\Ingredient;
use App\Models\Tag;
use Auth;


class RecipeController extends Controller
{
    // これはすべてのレシピを取ってきている。その件数を制限する方法はカリキュラム解答７－２解説３参照
    public function index(Recipe $recipe)
    {
        //return $recipe->get();
        return view('recipes.index')->with(['recipes' => $recipe->get()]);
    }

    public function create(Tag $tag)
    {
        return view('recipes.create')->with(['tags' => $tag->get()]); 

    }

    public function store(Request $request, Recipe $recipe)
    {

        //dd($request);
        // //cloudinaryへ画像を送信し、画像のURLを$image_urlに代入している
        $image_url = Cloudinary::upload($request->file('image')->getRealPath())->getSecurePath();
        //dd($image_url);  //画像のURLを画面に表示

        $input = $request['recipe'];
        $input += ['image' => $image_url];   //追加
        $input += [
            'cookingtime' => $request->input('recipe.cookingtime'),
            'frozen_storage' => $request->input('recipe.frozen_storage'),
            'cold_storage' => $request->input('recipe.cold_storage'),
        ];
        $input["user_id"] = Auth()->id();//連想配列
        //dd($input);
        $recipe->fill($input)->save();


        //stepの保存方法for
        $textInput = $request->input("step");
        foreach ($textInput as $index => $stepText) {
            $step = new Step;
            $step->fill([
                //'recipe_id' => $recipe->id, // 保存したレシピのIDをセット
                'number' => $index + 1, // インデックスを使用してnumberを設定
                'step' => $stepText, // 手順のテキストをセット
            ]);
            $recipe->steps()->save($step); // リレーション経由で保存
        }
        // 材料の保存
        $ingredientsInput = $request->input("ingredients");
        foreach ($ingredientsInput as $ingredientData) {
            $ingredient = new Ingredient;
            $ingredient->fill([
                'name' => $ingredientData['name'],
                'quantity' => $ingredientData['quantity'],
            ]);
            $recipe->ingredients()->save($ingredient);
        }

        // タグの保存処理
        if ($request->has('tags')) {
            $tags = $request->input('tags');  // フォームから送信されたタグの配列を取得
            foreach ($tags as $tagName) {
                // タグが存在するかチェック
                
                $tag =Tag::firstOrCreate(['name' => $tagName]);  // 新規作成または既存のタグを取得
                $recipe->tags()->attach($tag->id);  // レシピとタグを紐付け
                dd($tag);
            }
        }

        return redirect('/recipes/' . $recipe->id);
    }

    public function show(Recipe $recipe)
    {
        $steps = $recipe->steps;
        $ingredients = $recipe->ingredients;
        // 冷凍・冷蔵期間をビューに渡す
        $frozenStorage = $recipe->frozen_storage;
        $coldStorage = $recipe->cold_storage;
        // return view('/recipes/show')->with(['recipe' => $recipe]);
        return view('recipes.show', compact('recipe', 'steps', 'ingredients', 'frozenStorage', 'coldStorage')); // ビューに渡す

    }

}