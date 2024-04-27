@extends('layouts.main')
@section('title','商品一覧画面')
@section('page-title','商品一覧画面')

@section('head')
<link rel="stylesheet" type="text/css" href="{{ asset('css/index.css') }}">
@endsection

@section('sort')
<div class="sort-area">
  <form method="get" action="{{route('products.index')}}">
    <input type="text" placeholder="キーワードを入力してください" name="keyword">
    <select name="company_id">
      @foreach($companies as $company)
      <option value="{{$company->id}}">{{$company->company_name}}</option>
      @endforeach
    </select>
    <button type="submit">検索</button>
  </form>
</div>
@endsection

@section('content')
<div class="container">
  <table>  
      <tr>
        <th>ID</th>
        <th>商品画像</th>
        <th>商品名</th>
        <th>価格</th>
        <th>在庫数</th>
        <th>メーカー名</th>
        <th><a href="{{ route('products.create') }}"><button>新規登録</button></a></th>
      </tr>

@foreach($products as $product)
      <tr>
        <td>{{$product->id}}</td>
        @if($product->img_path)
        <td><img src="{{ asset('storage/productImages/' . $product->img_path) }}" style="width: 100px; height: 100px; object-fit: cover;"></td>
        @else
        <td>商品画像</td>
        @endif
        <td>{{$product->product_name}}</td>
        <td>{{$product->price}}</td>
        <td>{{$product->stock}}</td>
        <td>{{$product->company->company_name}}</td>
        <td><a href="{{ route('products.show',$product->id) }}"><button>詳細</button></a></td>
        <td>
        <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('本当に削除してもよろしいですか？');">
        @csrf
        @method('DELETE')
        <button type="submit">削除</button>
        </form>
        </td>
      </tr>
@endforeach

  </table>
</div>

@endsection
