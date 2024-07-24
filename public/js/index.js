$(document).ready(function() {
  // CSRFトークンをすべてのAjaxリクエストに追加
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  const searchProducts = () => {
    $.ajax({
      url: '/nonestep7/public/api/products',
      type: 'GET',
      data: $('#search-form').serialize(),
      success: function(response) {
        var results = $('#search-results');
        results.empty();
  
        if (response.products.length > 0) {
          var table = $('<table>').addClass('table tablesorter'); // 'tablesorter'クラスを追加
          var thead = $('<thead>').append('<tr><th>ID</th><th>商品画像</th><th>商品名</th><th>価格</th><th>在庫数</th><th>メーカー名</th><th></th><th></th></tr>');
          table.append(thead);
  
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
  
            var showUrl = "/nonestep7/public/products/" + product.id;
            row.append('<td><a href="' + showUrl + '"><button>詳細</button></a></td>');
  
            row.append('<td><button class="deletebutton" type="button" data-product-id="' + product.id + '">削除</button></td>');
  
            tbody.append(row);
          });
  
          table.append(tbody);
          results.append(table);
  
          // tablesorter プラグインの初期化
          $(".tablesorter").tablesorter({
            sortList: [[0,1]] // 初期表示時はid降順
          });
  
        } else {
          results.append('<p>該当する商品はありません。</p>');
        }
      },
      error: function(xhr) {
        console.log(xhr.responseText);
      }
    });
  }

  $('#search-form').on('submit', function(event) {
    event.preventDefault();
    searchProducts();
  });

  searchProducts();
});

$(document).on('click', ".deletebutton", function(event) {
  event.preventDefault();

  if (!confirm('本当に削除してもよろしいですか？')) {
    return;
  }

  const product_id = $(this).data("product-id");

  $.ajax({
    url: '/nonestep7/public/products/' + product_id,
    type: 'POST',
    headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    data: {
      _method: 'DELETE',
    },
    success: function(response) {
      $(event.target).closest('tr').remove();
      alert('削除が成功しました');
    },
    error: function(xhr) {
      console.error('削除処理中にエラーが発生しました', xhr.responseText);
      alert('削除に失敗しました');
    }
  });
});
