$(document).ready(function() {
  const searchproducts = () => {
    
    // AJAXリクエストを送信
    $.ajax({
      url: '/nonestep7/public/api/products', // リクエストURL（検索APIエンドポイント）
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
        row.append('<td><img src="/nonestep7/public/storage/productImages/' + product.img_path + '" style="width: 100px; height: 100px; object-fit: cover;"></td>');
        } else {
        row.append('<td>商品画像なし</td>');
      }
        row.append('<td>' + product.product_name + '</td>');
        row.append('<td>' + product.price + '</td>');
        row.append('<td>' + product.stock + '</td>');
        row.append('<td>' + product.company_name + '</td>');

    // `showProductUrl`は製品詳細ページのURLテンプレートで、`:id`プレースホルダーを含む
      var showUrl = "/nonestep7/public/products/show/" + product.id;

    // 新しいテーブル行のHTMLを作成し、詳細ボタンを追加
      row.append('<td><a href="' + showUrl + '"><button>詳細</button></a></td>');

    // CSRFトークンを取得
      var csrfToken = $('meta[name="csrf-token"]').attr('content');

    // 削除ボタンを含むフォームを作成
      row.append('<td><button class="deletebutton" type="submit" data-product-id="' + product.id + '">削除</button></td>');

    // `tbody`に新しい行を追加
      tbody.append(row);
    });
          
      table.append(tbody);

      // テーブルを結果表示エリアに追加
        results.append(table); 

      // 削除フォームの非同期処理を再バインド
        bindDeleteForms();
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
}
  
      // フォームが送信されたときのイベントハンドラ
        $('#search-form').on('submit', function(event) {
      // デフォルトのフォーム送信動作をキャンセル
          event.preventDefault();

          searchproducts();
      });

        searchproducts();
      // ページロード時に削除フォームをバインド
        bindDeleteForms();

        function bindDeleteForms() {
          $(".deletebutton").on('click', function(event) {
            event.preventDefault();

          if (!confirm('本当に削除してもよろしいですか？')) {
            return;
          }

          const product_id = $(this).data("product-id");
          console.log(product_id);

          $.ajax({
            url: '/nonestep7/public/products/' + product_id,
            type: 'POST',

          success: function(response) {
            form.closest('tr').remove();
            alert('削除が成功しました');
          },

          error: function(xhr) {
            console.error('削除処理中にエラーが発生しました', xhr.responseText);
            alert('削除に失敗しました');
          }
        });
      });
    }
});

