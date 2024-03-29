@extends('layouts.main')
@section('title','商品情報詳細画面')
@section('page-title','商品情報詳細画面')
@section('content')
<h2>商品情報詳細画面</h2>
<div class="container">
  <table>  
      <tr>
        <th>ID</th><td>{{$product->id}}</td>
      </tr>
      <tr>
        <th>商品画像</th><td>商品画像</td>
      </tr>
      <tr>
        <th>商品名</th><td>{{$product->product_name}}</td>
      </tr>
      <tr>
        <th>価格</th><td>{{$product->price}}</td>
      </tr>
      <tr>
        <th>在庫数</th><td>{{$product->stock}}</td>
      </tr>
      <tr>
        <th>メーカー名</th><td>{{$product->company->company_name}}</td>
      </tr>
  </table>

<div>  
    <th><a href="{{ route('products.edit', $product->id) }}"><button>編集</button></a></th>
</div>

<div>  
    <th><a href="{{ route('products.index') }}"><button>戻る</button></a></th>
</div>

@endsection
