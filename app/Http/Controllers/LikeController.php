<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{

    public function likeRecipe(Request $request)
    {
        $user_id = \Auth::id();
        //jsのfetchメソッドで記事のidを送信しているため受け取ります。
        $recipe_id = $request->recipe_id;
        //自身がいいね済みなのか判定します
        $alreadyLiked = Like::where('user_id', $user_id)->where('recipe_id', $recipe_id)->first();

        if (!$alreadyLiked) {
        //こちらはいいねをしていない場合の処理です。つまり、post_likesテーブルに自身のid（user_id）といいねをした記事のid（post_id）を保存する処理になります。
            $like = new Like();
            $like->recipe_id = $recipe_id;
            $like->user_id = $user_id;
            $like->save();
        } else {
            //すでにいいねをしていた場合は、以下のようにpost_likesテーブルからレコードを削除します。
            Like::where('recipe_id', $recipe_id)->where('user_id', $user_id)->delete();
        }
        //ビューにその記事のいいね数を渡すため、いいね数を計算しています。
        $recipe = Recipe::where('id', $recipe_id)->first();
        $likesCount = $recipe->likes->count();

        $param = [
            'likesCount' =>  $likesCount,
        ];
        //ビューにいいね数を渡しています。名前は上記のlikesCountとなるため、フロントでlikesCountといった表記で受け取っているのがわかると思います。
        return response()->json($param);
    }
}
