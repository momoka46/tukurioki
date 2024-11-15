<!DOCTYPE HTML>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>レシピ作成</title>
</head>
<body>
<x-app-layout>
    <h1>レシピ作成</h1>
  
    <form action="/recipes" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="title">
            <h2>料理名</h2>
            <input type="text" name="recipe[name]" placeholder="Name"/>
        </div>

        <h2>保存期間</h2>

        <!-- 画像の投稿 -->
        <div class="image">
        <h2>イメージ画僧</h2>
            <input type="file" name="image">
        </div>

        <div id="ingredient-inputs">
        <h2>材料</h2>
        <div class="ingredient-row">
            <input type="text" name="ingredients[0][name]" placeholder="材料名">
            <input type="text" name="ingredients[0][quantity]" placeholder="量">
        </div>

        </div>
    <button type="button" onclick="addIngredient()">材料を追加</button>
    

        <!-- 手順追加 -->
        <div class="container ip-fields-container">
        <h2>調理手順</h2>
            <div class="row" id="step-row-0">
                <div class="col-sm-2 flex flex-center">
                    <label for="step_0">手順 1</label>
                </div>
                <div class="col-sm-4">
                    <input type="text" id="step_0" class="form-control" placeholder="手順内容" name="step[0]" value="">
                </div>
                <div class="col-sm-4">
                    <button class="add-field-btn" type="button">+</button>
                </div>
            </div>
        </div>
        <input type="submit" value="レシピを投稿"/>
       
    </form>

    <div class="footer">
        <a href="/">戻る</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        let ingredientIndex = 1;
// 材料の追加
function addIngredient() {
    const container = document.getElementById('ingredient-inputs');
    const newRow = document.createElement('div');
    newRow.classList.add('ingredient-row');
    newRow.innerHTML = `
        <input type="text" name="ingredients[${ingredientIndex}][name]" placeholder="材料名">
        <input type="text" name="ingredients[${ingredientIndex}][quantity]" placeholder="量">
    `;
    container.appendChild(newRow);
    ingredientIndex++;
}
        var fieldCount = 1; // 次の手順の番号

        $(document).on('click', '.add-field-btn', function() {
            // 新しい手順フィールドを作成
            var newField = $('<div class="row" id="step-row-' + fieldCount + '">' +
                '<div class="col-sm-2">' +
                '    <label for="step_' + fieldCount + '">手順 ' + (fieldCount + 1) + '</label>' + // 手順番号
                '</div>' +
                '<div class="col-sm-4">' +
                '    <input type="text" id="step_' + fieldCount + '" class="form-control" placeholder="手順内容" name="step[' + fieldCount + ']" value="">' +
                '</div>' +
                '<div class="col-sm-4">' +
                '    <button class="remove-field-btn" type="button">-</button>' +
                '</div>' +
                '</div>');

            // 手順フィールドを追加
            $('.ip-fields-container').append(newField);
            fieldCount++; // 手順番号を増やす
        });

        $(document).on('click', '.remove-field-btn', function() {
            // 手順フィールドの削除
            $(this).closest('.row').remove();
            // 手順番号を再計算
            updateStepNumbers();
        });

        function updateStepNumbers() {
            // 現在の手順フィールドをリセットして番号を更新
            $('.ip-fields-container .row').each(function(index) {
                $(this).find('label').text('手順 ' + (index + 1)); // 番号を更新
                $(this).find('input').attr('name', 'step[' + index + ']'); // name属性の更新
                $(this).find('input').attr('id', 'step_' + index); // id属性の更新
            });
            fieldCount = $('.ip-fields-container .row').length; // 現在の行数を再設定
        }
    </script>
    </x-app-layout>
</body>
</html>
