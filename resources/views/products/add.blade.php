@extends('layouts.main')
@section('title', '商品新規登録')
@section('page-title', '商品新規登録')

@section('head')
<link rel="stylesheet" type="text/css" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="container">
<div style="border: 2px solid black; padding: 5px;">
  <table>
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
        
        <div class="item">
        <tr>
        <th><label><div>商品名<span style="color: red;">*</span></div></label></th>
        <td><input type="text" placeholder="商品名を入力してください" name="product_name" class="input-field"></td>
        </tr>
        </div>

        <div class="item">
        <tr>
        <th><label><div>メーカー名<span style="color: red;">*</span></div></label></th>
        <td><select name="company_id" class="input-field">
            @foreach($companies as $company)
                <option value="{{ $company->id }}">{{ $company->company_name }}</option>
            @endforeach
        </select></td>
        </tr>
        </div>
        
        <div class="item">
        <tr>
        <th><label><div>価格<span style="color: red;">*</span></label></th>
        <td><input type="text" placeholder="価格を入力してください" name="price" class="input-field"></td>
        </tr>
        </div>

        <div class="item">
        <tr>
        <th><label><div>在庫数<span style="color: red;">*</span></label></th>
        <td><input type="text" placeholder="在庫数を入力してください" name="stock" class="input-field"></td>
        </tr>
        </div>

        <div class="item">
        <tr>
        <th><label>コメント</label></th>
        <td><textarea name="comment" class="input-field"></textarea></td>
        </tr>
        </div>

        <div class="item">
        <tr>
        <th><label>商品画像</label></th>
        <td><input type="file" name="img_path" accept="image/png, image/jpeg"></td>
        <br><br>
        </tr>
        </div>
        </table>
        </div>

        <div style="text-align: right;">
            <input type="submit" value="新規登録">
            <a href="{{ route('products.index') }}"><button type='button'>戻る</button></a>
        </div>
    </form>
</div>
@endsection
