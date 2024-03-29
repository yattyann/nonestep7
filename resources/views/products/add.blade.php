@extends('layouts.main')
@section('title','商品新規登録画面')
@section('content')
<h2>商品新規登録画面</h2>
  <form action="{{ route('products.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    <label>商品名</label> 
    <input type="text" placeholder="商品名を入力してください" name="product_name">
    <br>

    <label>メーカー名<span>*</span></label>
    <select name="company_id">
      <option value="1">アサヒ</option> 
      <option value="2">コカ・コーラ</option> 
      <option value="3">キリン</option> 
      <option value="4">DyDo</option> 
    </select>
    <br> 

    <label>価格<span>*</span></label> 
    <input type="text" placeholder="価格を入力してください" name="price">
    <br>

    <label>在庫数<span>*</span></label> 
    <input type="text" placeholder="在庫数を入力してください" name="stock">
    <br>

    <label>コメント</label> 
    <textarea name="comment"></textarea>
    <br>

    <label>商品画像</label> 
    <input type="file" name="img_path" accept=".png, .jpg, .jpeg, .pdf, .doc">  
    <br>
    <br>

    <input type="submit" value="新規登録"> 
    <a href="{{ route('products.index') }}"><button type='button'>戻る</button></a>
  </form>

@endsection