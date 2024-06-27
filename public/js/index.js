$(document).ready(function() {
  // フォームが送信されたときのイベントハンドラ
  $('#search-form').on('submit', function(event) {
    // デフォルトのフォーム送信動作をキャンセル
    event.preventDefault();

    // AJAXリクエストを送信
    $.ajax({
      url: '{{ route("products.search") }}', // リクエストURL（検索APIエンドポイント）
      type: 'GET', // リクエストの種類（GET）
      data: $(this).serialize(), // フォームのデータをシリアライズして送信
      success: function(response) {
        // 成功時の処理
        var results = $('#search-results'); // 結果を表示する要素
        results.empty(); // 前回の結果をクリア

        // 結果がある場合
        if (response.products.length > 0) {
          // テーブルを作成
          var table = $('<table>').addClass('table');
          var thead = $('<thead>').append('<tr><th>ID</th><th>商品画像</th><th>商品名</th><th>価格</th><th>在庫数</th><th>メーカー名</th><th></th><th></th></tr>');
          table.append(thead);

          // テーブルのボディを作成
          var tbody = $('<tbody>');
          response.products.forEach(function(product) {
            var row = $('<tr>');
            row.append('<td>' + product.id + '</td>');
            if (product.img_path) {
              row.append('<td><img src="{{ asset("storage/productImages") }}/' + product.img_path + '" style="width: 100px; height: 100px; object-fit: cover;"></td>');
            } else {
              row.append('<td>商品画像</td>');
            }
            row.append('<td>' + product.product_name + '</td>');
            row.append('<td>' + product.price + '</td>');
            row.append('<td>' + product.stock + '</td>');
            row.append('<td>' + product.company.company_name + '</td>');
            row.append('<td><a href="{{ route("products.show", "") }}/' + product.id + '"><button>詳細</button></a></td>');
            row.append('<td><form action="{{ route("products.destroy", "") }}/' + product.id + '" method="POST" onsubmit="return confirm(\'本当に削除してもよろしいですか？\');">@csrf @method("DELETE")<button type="submit">削除</button></form></td>');
            tbody.append(row);
          });

          table.append(tbody);
          results.append(table); // テーブルを結果表示エリアに追加
        } else {
          // 結果がない場合のメッセージ
          results.append('<p>該当する商品はありません。</p>');
        }
      },
      error: function(xhr) {
        // エラー時の処理
        console.log(xhr.responseText);
      }
    });
  });
});

// $(function() {
//   // ボタンがクリックされた場合
//   $('button').on('click', function(){
//      //ここでサーバーに対しての通信を行う。情報の指定（ここではdataに格納）、送信先、データの型（Json）等を記述
//      $.ajax({
//       type: 'get',
//       url: '/todos.json',
//       data: {
//         todo: {
//           content: todo
//         }
//       },
//       dataType: 'json' //データをjson形式で飛ばす
//     })
//     //↓フォームの送信に成功した場合の処理
//     .done(function(data) {
//       var html = buildHTML(data);
//       $('.todos').append(html); //$.append関数は操作後はDOMに要素が追加された状態になる。
//                                 //todosクラスに引数で指定したdataのHTML要素を追加。

//       textField.val(''); //
//     })
//     //↓フォームの送信に失敗した場合の処理
//     .fail(function() {
//       alert('error');
//     });
//     return false;
//   });
// });

