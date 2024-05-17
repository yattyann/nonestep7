@extends('layouts.main')
@section('title','商品一覧')
@section('page-title','商品一覧')

@section('head')
<link rel="stylesheet" type="text/css" href="{{ asset('css/index.css') }}">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelector('.sort-area form').addEventListener('submit', function (event) {
        fetchProducts();
    });

    function fetchProducts() {
        const keyword = document.querySelector('input[name="keyword"]').value;
        const company_id = document.querySelector('select[name="company_id"]').value;

        fetch(`{{ route('products.index') }}?keyword=${encodeURIComponent(keyword)}&company_id=${encodeURIComponent(company_id)}`)
            .then(response => response.json())
            .then(data => {
                const tableBody = document.querySelector('table tbody');
                tableBody.innerHTML = '';
                data.products.forEach(product => {
                    const row = document.createElement('tr');

                    row.innerHTML = `
                        <td>${product.id}</td>
                        <td><img src="{{ asset('storage/productImages/') }}/${product.img_path ? product.img_path : 'default.jpg'}" style="width: 100px; height: 100px; object-fit: cover;"></td>
                        <td>${product.product_name}</td>
                        <td>${product.price}</td>
                        <td>${product.stock}</td>
                        <td>${product.company_name}</td>
                        <td><a href="{{ url('products') }}/${product.id}"><button>詳細</button></a></td>
                        <td>
                            <form action="{{ url('products') }}/${product.id}" method="POST" onsubmit="return confirm('本当に削除してもよろしいですか？');">
                                @csrf
                                @method('DELETE')
                                <button type="submit">削除</button>
                            </form>
                        </td>
                    `;
                    tableBody.appendChild(row);
                });
            })
            .catch(error => console.error('Error:', error));
    }
});
</script>

@endsection

@section('sort')
<div class="sort-area">
  <form method="get" action="{{ route('products.index') }}">
    <input type="text" placeholder="キーワードを入力してください" name="keyword">
    <select name="company_id">
      @foreach($companies as $company)
      <option value="{{ $company->id }}">{{ $company->company_name }}</option>
      @endforeach
    </select>
    <!-- 価格の下限と上限の入力フィールドを追加 -->
    <input type="text" placeholder="価格下限" name="min_price">
    <input type="text" placeholder="価格上限" name="max_price">
    <button type="submit">検索</button>
  </form>
</div>
@endsection

@section('content')
<div class="container">
<div style="border: 2px solid black; padding: 5px;">
  <table>  
      <thead>
        <tr>
          <th>ID</th>
          <th>商品画像</th>
          <th>商品名</th>
          <th>価格</th>
          <th>在庫数</th>
          <th>メーカー名</th>
          <th> </th>
          <th><a href="{{ route('products.create') }}"><button>新規登録</button></a></th>
        </tr>
      </thead>
      <tbody>
@foreach($products as $product)
        <tr>
          <td>{{ $product->id }}</td>
          @if($product->img_path)
          <td><img src="{{ asset('storage/productImages/' . $product->img_path) }}" style="width: 100px; height: 100px; object-fit: cover;"></td>
          @else
          <td>商品画像</td>
          @endif
          <td>{{ $product->product_name }}</td>
          <td>{{ $product->price }}</td>
          <td>{{ $product->stock }}</td>
          <td>{{ $product->company->company_name }}</td>
          <td><a href="{{ route('products.show', $product->id) }}"><button>詳細</button></a></td>
          <td>
          <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('本当に削除してもよろしいですか？');">
          @csrf
          @method('DELETE')
          <button type="submit">削除</button>
          </form>
          </td>
        </tr>
@endforeach
      </tbody>
  </table>
</div>
@endsection
