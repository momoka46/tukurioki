<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>○○</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
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
             <div><p>{{$post->content}}</p></div>
             <div></div>
              {{-- のちに使います --}}
    <script></script>

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
    </body>
</html>
