@extends('layouts.main')
@section('title','商品情報詳細画面')
@section('page-title','商品情報詳細画面')
@section('content')

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

    <a href="{{ route('products.edit',$product->id) }}"><button type='button'>編集</button></a>
    <a href="{{ route('products.index',$product->id) }}"><button type='button'>戻る</button></a>

@endsection
