@extends('layouts.main')
@section('title','商品情報編集画面')
@section('page-title','商品情報編集画面')
@section('content')
  <form action="{{ route('products.update',$product->id) }}" method="post" enctype="multipart/form-data">
  @csrf
  @method('put')
  <label>ID</label>
  


  
    <label>商品名</label> 
    <input type="text" placeholder="商品名を入力してください" value="{{ $product->product_name }}">
    <br>

    <label>メーカー名</label>      
    <select> 
    @foreach($companies as $company)
      <option value="{{$company->id}}">{{$company->company_name}}</option>
    @endforeach
    </select>
    <br> 

    <label>価格</label> 
    <input type="text" placeholder="価格を入力してください" value="{{ $product->price }}">
    <br>

    <label>在庫数</label> 
    <input type="text" placeholder="在庫数を入力してください" value="{{ $product->stock }}">
    <br>

    <label>コメント</label> 
    <textarea>{{$product->comment}}</textarea>
    <br>

    <label>商品画像</label> 
    <input type="file" name="example" accept=".png, .jpg, .jpeg, .pdf, .doc">  
    <br>
    <br>

    <input type="submit" value="更新"> 
    <a href="{{ route('products.show',$product->id) }}"><button type='button'>戻る</button></a>
  </form>
@endsection