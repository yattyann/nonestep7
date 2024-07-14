@extends('layouts.main')
@section('title','商品一覧')
@section('page-title','商品一覧')

@section('head')
<link rel="stylesheet" type="text/css" href="{{ asset('css/index.css') }}">
<!-- tablesorterのCSSを追加 -->
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.3/css/theme.default.min.css">
@endsection

@section('script')
<!-- jQueryの読み込み -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<!-- tablesorterの読み込み -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.3/js/jquery.tablesorter.min.js"></script>
<!-- スクリプトの実行 -->
<script src="{{ asset('js/index.js') }}"></script>
<script>
  $(document).ready(function() {
    // CSRFトークンをすべてのAjaxリクエストに追加
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    const searchProducts = () => {
      $.ajax({
        url: '{{ route('products.search') }}', // URLが正しいか確認
        type: 'GET',
        data: $('#search-form').serialize(),
        success: function(response) {
          var results = $('#search-results');
          results.empty();

          if (response.products.length > 0) {
            var table = $('<table>').attr('id', 'product-table').addClass('table tablesorter');
            var thead = $('<thead>').append('<tr><th>ID</th><th>商品画像</th><th>商品名</th><th>価格</th><th>在庫数</th><th>メーカー名</th><th></th><th></th></tr>');
            table.append(thead);

            var tbody = $('<tbody>');
            response.products.forEach(function(product) {
              var row = $('<tr>');
              row.append('<td>' + product.id + '</td>');
              if (product.img_path) {
                row.append('<td><img src="{{ asset('storage/productImages/') }}/' + product.img_path + '" style="width: 100px; height: 100px; object-fit: cover;"></td>');
              } else {
                row.append('<td>商品画像なし</td>');
              }
              row.append('<td>' + product.product_name + '</td>');
              row.append('<td>' + product.price + '</td>');
              row.append('<td>' + product.stock + '</td>');
              row.append('<td>' + product.company_name + '</td>');

              var showUrl = "{{ url('products/show') }}/" + product.id;
              row.append('<td><a href="' + showUrl + '"><button>詳細</button></a></td>');

              row.append('<td><button class="deletebutton" type="button" data-product-id="' + product.id + '">削除</button></td>');

              tbody.append(row);
            });

            table.append(tbody);
            results.append(table);

            // tablesorterを再初期化
            $("#product-table").tablesorter({
              sortList: [[0,1]] // 初期表示時はID降順
            });

            bindDeleteForms();
          } else {
            results.append('<p>該当する商品はありません。</p>');
          }
        },
        error: function(xhr) {
          console.log("Ajax request failed: ", xhr);
          alert("Error: " + xhr.statusText + " (" + xhr.status + ")");
        }
      });
    }

    $('#search-form').on('submit', function(event) {
      event.preventDefault();
      searchProducts();
    });

    searchProducts();

    function bindDeleteForms() {
      $(".deletebutton").on('click', function(event) {
        event.preventDefault();

        if (!confirm('本当に削除してもよろしいですか？')) {
          return;
        }

        const product_id = $(this).data("product-id");

        $.ajax({
          url: '/nonestep7/public/products/' + product_id,
          type: 'DELETE',
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
    }
  });
</script>
@endsection

@section('sort')
<div class="sort-area">
  <form method="get" action="{{ route('products.index') }}" id="search-form">
    <input type="text" class="form-input" placeholder="キーワードを入力してください" name="keyword" value="{{ request('keyword') }}">
    <select name="company_id" class="form-select">
      <option value="">メーカーを選択</option>
      @foreach($companies as $company)
      <option value="{{ $company->id }}" @if(request('company_id') == $company->id) selected @endif>{{ $company->company_name }}</option>
      @endforeach
    </select>
    <h3>絞り込み機能</h3>
    <div>
        <label for="min_price">価格下限:</label>
        <input type="number" class="form-input" placeholder="価格下限を入力してください" name="min_price" id="min_price" value="{{ request('min_price') }}">
    </div>
    <div>
        <label for="max_price">価格上限:</label>
        <input type="number" class="form-input" placeholder="価格上限を入力してください" name="max_price" id="max_price" value="{{ request('max_price') }}">
    </div>
    <div>
        <label for="min_stock">在庫下限:</label>
        <input type="number" class="form-input" placeholder="在庫下限を入力してください" name="min_stock" id="min_stock" value="{{ request('min_stock') }}">
    </div>
    <div>
        <label for="max_stock">在庫上限:</label>
        <input type="number" class="form-input" placeholder="在庫上限を入力してください" name="max_stock" id="max_stock" value="{{ request('max_stock') }}">
    </div>
    <button type="submit" class="form-button">検索</button>
  </form>
</div>
@endsection

@section('content')
<div class="container">
  <div style="border: 2px solid black; padding: 5px;" id="search-results">
    <!-- 検索結果の表示 -->
  </div>
</div>
@endsection