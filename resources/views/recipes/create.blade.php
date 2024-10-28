<!DOCTYPE HTML>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>○○</title>
</head>
<body>
    <h1>○○</h1>
    <form action="/recipes" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="title">
            <h2>Name</h2>
            <input type="text" name="recipe[name]" placeholder="Name"/>
        </div>

        <!-- 画像の投稿 -->
        <div class="image">
            <input type="file" name="image">
        </div>

        <!-- 手順追加 -->
        <div class="container ip-fields-container">
            <div class="row">
                <div class="col-sm-2 flex flex-center">
                    <label for="">手順 1</label>
                </div>
                <div class="col-sm-4">
                    <input type="text" id="step_0" class="form-control" placeholder="" name="step[0]" value="">
                </div>
                <div class="col-sm-4">
                    <button id="add-field-btn" type="button">+</button>
                </div>
            </div>
        </div>
       
        <input type="submit" value="store"/>
    </form>
    <div class="footer">
        <a href="/">戻る</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        var fieldCount = 1; // 1から開始

        $(document).on('click', '#add-field-btn', function() {
            var newField = $('<div class="row">' +
                '<div class="col-sm-2">' +
                '    <label for="step_' + fieldCount + '">手順 ' + (fieldCount + 1) + '</label>' + // 次の手順の番号を表示
                '</div>' +
                '<div class="col-sm-4">' +
                '    <input type="text" id="step_' + fieldCount + '" class="form-control" placeholder="" name="step[' + fieldCount + ']" value="">' +
                '</div>' +
                '<div class="col-sm-4">' +
                '    <button class="remove-field-btn" type="button">-</button>' +
                '</div>' +
                '</div>');

            $('.ip-fields-container').append(newField);
            fieldCount++; // 次のフィールドに移るためカウントを増やす
        });

        $(document).on('click', '.remove-field-btn', function() {
            $(this).closest('.row').remove();
            // 手順の番号を再計算する
            $('.ip-fields-container .row').each(function(index) {
                $(this).find('label').text('手順 ' + (index + 1)); // 手順の番号を更新
                $(this).find('input').attr('name', 'step[' + index + ']'); // 名前属性も更新
            });
            fieldCount = $('.ip-fields-container .row').length; // 現在の行数をカウント
        });
    </script>
</body>
</html>
