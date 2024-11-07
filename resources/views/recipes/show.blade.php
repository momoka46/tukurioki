<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>○○</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <script src="https://kit.fontawesome.com/51be2a60a3.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <h1 class="title">
            {{ $recipe->name}}
        </h1>
        {{ $recipe->image }}
        <div>
            
            <!-- 画僧表示 -->
            <div>
                <img src="{{ $recipe->image }}" alt="画像が読み込めません。">
            </div>
            <!-- いいね機能 -->
             <div><p>{{$recipe->content}}</p></div>
             @auth
             @if($recipe->isLikedByAuthUser())
            {{-- こちらがいいね済の際に表示される方で、likedクラスが付与してあることで星に色がつきます --}}
            <div class="flexbox">
                <i class="fa-solid fa-star like-btn liked" id={{$recipe->id}}></i>
                <p class="count-num">{{$resipe->likes->count()}}</p>
            </div>
        @else
            <div class="flexbox">
                <i class="fa-solid fa-star like-btn" id={{$recipe->id}}></i>
                <p class="count-num">{{$recipe->likes->count()}}</p>
            </div>
        @endif
    @endauth

    @guest
        <p>loginしていません</p>
    @endguest
             <div></div>
              {{-- のちに使います --}}
    

            <!-- 手順表示 -->
          <div>
        <h2>調理手順</h2>
        <ol>
        <!-- ($recipe->steps as $step) -->
            @foreach ($recipe->steps as $step)
                <li>{{ $step->step }}</li> <!-- 手順のテキストを表示 -->
            @endforeach
        </ol>
    </div>
        </div>

        <div class="footer">
            <a href="/">戻る</a>
        </div>
        <script>
              //いいねボタンのhtml要素を取得します。
        const likeBtn = document.querySelector('.like-btn');
        //いいねボタンをクリックした際の処理を記述します。 
        likeBtn.addEventListener('click',async(e)=>{
            //クリックされた要素を取得しています。
            const clickedEl = e.target
            //クリックされた要素にlikedというクラスがあれば削除し、なければ付与します。これにより星の色の切り替えができます。      
            clickedEl.classList.toggle('liked')
            //記事のidを取得しています。
            const postId = e.target.id
            //fetchメソッドを利用し、バックエンドと通信します。非同期処理のため、画面がかくついたり、真っ白になることはありません。
            const res = await fetch('/recipe/like',{
                //リクエストメソッドはPOST
                method: 'POST',
                headers: {
                    //Content-Typeでサーバーに送るデータの種類を伝える。今回はapplication/json
                    'Content-Type': 'application/json',
                    //csrfトークンを付与
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                //バックエンドにいいねをした記事のidを送信します。
                body: JSON.stringify({ recipe_id: recipeId })
            })
            .then((res)=>res.json())
            .then((data)=>{
                //記事のいいね数がバックエンドからlikesCountという変数に格納されて送信されるため、それを受け取りビューに反映します。
                clickedEl.nextElementSibling.innerHTML = data.likesCount;
            })
            .catch(
            //処理がなんらかの理由で失敗した場合に実施したい処理を記述します。
            ()=>alert('処理が失敗しました。画面を再読み込みし、通信環境の良い場所で再度お試しください。'))

        })
        </script>
    </body>
</html>
