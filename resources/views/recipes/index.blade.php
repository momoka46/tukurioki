<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>作り置きレシピ</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="{{asset('css/base.css')}}">
    </head>
    <body>
    <x-app-layout>
        <h1>作り置きレシピサイト</h1>
        <a href='/recipes/create'>create</a>

        @foreach ($recipes as $recipe )
        <div class="recipe">
            <h2 class="name">
            <a href="/recipes/{{ $recipe->id }}">{{ $recipe->name}}</a>

            </h2>
        </div>
        
        @endforeach
        </x-app-layout>
        
    </body>
</html>