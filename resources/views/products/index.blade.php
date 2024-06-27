@extends('layouts.main')
@section('title','商品一覧')
@section('page-title','商品一覧')

@section('head')
<link rel="stylesheet" type="text/css" href="{{ asset('css/index.css') }}">
@endsection

@section('script')
  <!-- jQueryの読み込み -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  <!-- スクリプトの実行 -->
  <script src="{{ asset('js/index.js') }}"></script>
@endsection

@section('sort')
<div class="sort-area">
  <form method="get" action="{{ route('products.index') }}" id="search-form">
    <input type="text" class="form-input" placeholder="キーワードを入力してください" name="keyword">
    <select name="company_id" class="form-select">
      <option value="">メーカーを選択</option>
      @foreach($companies as $company)
      <option value="{{ $company->id }}">{{ $company->company_name }}</option>
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
<div id="search-results">
  <!-- 検索結果をここに表示 {!! $products->appends(request()->query())->links('') !!} -->
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

