@extends('layouts.main')
@section('title', '商品情報編集画面')
@section('page-title', '商品情報編集画面')

@section('head')
<link rel="stylesheet" type="text/css" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
    <form action="{{ route('products.update', $product->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('put')

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <label>ID</label>
        <span>{{ $product->id }}</span>
        <br>

        <label>商品名<span>*</span></label>
        <input type="text" placeholder="商品名を入力してください" value="{{ $product->product_name }}" name="product_name">
        <br>

        <label>メーカー名<span>*</span></label>
        <select name="company_id">
            @foreach($companies as $company)
                <option value="{{$company->id}}" {{ $product->company_id == $company->id ? 'selected' : '' }}>{{ $company->company_name }}</option>
            @endforeach
        </select>
        <br>

        <label>価格<span>*</span></label>
        <input type="text" placeholder="価格を入力してください" value="{{ $product->price }}" name="price">
        <br>

        <label>在庫数<span>*</span></label>
        <input type="text" placeholder="在庫数を入力してください" value="{{ $product->stock }}" name="stock">
        <br>

        <label>コメント</label>
        <textarea name="comment">{{ $product->comment }}</textarea>
        <br>

        <label>現在の商品画像</label>
        <img src="{{ asset('storage/productImages/' . $product->img_path) }}" alt="商品画像" style="max-width: 200px; max-height: 200px;">
        <br>

        <label>新しい商品画像を選択</label>
        <input type="file" name="img_path" accept=".png, .jpg, .jpeg">
        <br><br>

        <input type="submit" value="更新">
        <a href="{{ route('products.show', $product->id) }}"><button type='button'>戻る</button></a>
    </form>
@endsection
