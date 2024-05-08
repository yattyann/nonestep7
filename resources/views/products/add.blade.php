@extends('layouts.main')
@section('title', '商品新規登録画面')
@section('page-title', '商品新規登録')

@section('head')
<link rel="stylesheet" type="text/css" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="container">
    <form action="{{ route('products.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <label>商品名<span>*</span></label>
        <input type="text" placeholder="商品名を入力してください" name="product_name">
        <br>

        <label>メーカー名<span>*</span></label>
        <select name="company_id">
            @foreach($companies as $company)
                <option value="{{ $company->id }}">{{ $company->company_name }}</option>
            @endforeach
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
        <input type="file" name="img_path" accept="image/png, image/jpeg">
        <br><br>

        <input type="submit" value="新規登録">
        <a href="{{ route('products.index') }}"><button type='button'>戻る</button></a>
    </form>
    </div>
@endsection
