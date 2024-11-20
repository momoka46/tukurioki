<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>○○</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <script src="https://kit.fontawesome.com/51be2a60a3.js" crossorigin="anonymous"></script>
    <style>
    /* いいね押下時の色 */
    .liked {
        color: orangered;
        transition: .2s;
    }
    .flexbox {
        align-items: center;
        display: flex;
    }
    .count-num {
        font-size: 20px;
        margin-left: 10px;
    }
    .fa-heart {
        font-size: 30px;
    }
    </style>
</head>
<body>
    <x-app-layout>
        <h1 class="text-2xl,title">{{ $recipe->name }}</h1>
        <div>
            <!-- 画像表示 -->
            <div>
                <img src="{{ $recipe->image }}" alt="画像が読み込めません。">
            </div>

            <!-- いいね機能 -->
            <h1>お気に入り</h1>
            <div><p>{{ $recipe->content }}</p></div>

            @auth
                @if($recipe->isLikedByAuthUser())
                    <!-- いいね済み -->
                    <div class="flexbox">
                        <i class="fa-regular fa-heart like-btn liked" id="{{ $recipe->id }}"></i>
                        <p class="count-num">{{ $recipe->likes->count() }}</p>
                    </div>
                @else
                    <!-- いいね未済み -->
                    <div class="flexbox">
                        <i class="fa-regular fa-heart like-btn" id="{{ $recipe->id }}"></i>
                        <p class="count-num">{{ $recipe->likes->count() }}</p>
                    </div>
                @endif
            @endauth

            @guest
                <p>loginしていません</p>
            @endguest

            <div>
    <h2>調理時間</h2>
    <p>{{ $recipe->cookingtime }} 分</p>
</div>

<div>
    <h2>冷凍保管時間</h2>
    <p>{{ $recipe->frozen_storage }} 日</p>
</div>

<div>
    <h2>冷蔵保管時間</h2>
    <p>{{ $recipe->cold_storage }} 日</p>
</div>
            <div>
                <!-- 材料表示 -->
            <h2>材料</h2>
            <ul>
                @foreach ($ingredients as $ingredient)
                    <li>{{ $ingredient->name }}: {{ $ingredient->quantity }}</li>
                @endforeach
            </ul>
               
            </div>
            <!-- 手順表示 -->
            <h2>調理手順</h2>
                <ol>
                @foreach ($recipe->steps as $index => $step)
                        <li>{{ $index + 1 }}:{{ $step->step }}</li>
                    @endforeach
                </ol>
            
        </div>

        <div class="footer">
            <a href="/">戻る</a>
        </div>
    </x-app-layout>

    <script>
        // いいねボタンのhtml要素を全て取得
        const likeBtns = document.querySelectorAll('.like-btn');
        
        // すべてのいいねボタンにイベントを設定
        likeBtns.forEach(likeBtn => {
            likeBtn.addEventListener('click', async (e) => {
                const clickedEl = e.target;
                clickedEl.classList.toggle('liked'); // 色を切り替え

                const recipeId = clickedEl.id; // レシピのIDを取得

                // サーバーに「いいね」を送信
                const res = await fetch('/recipes/like', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ recipe_id: recipeId })
                })
                .then(res => res.json())
                .then(data => {
                    // いいね数を更新
                    clickedEl.nextElementSibling.innerHTML = data.likesCount;
                })
                .catch(() => {
                    alert('処理が失敗しました。画面を再読み込みし、通信環境の良い場所で再度お試しください。');
                });
            });
        });
    </script>
</body>
</html>
