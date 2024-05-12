@extends('layouts.main')
@section('title', '商品情報編集')
@section('page-title', '商品情報編集')

@section('head')
<link rel="stylesheet" type="text/css" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="container">
<div style="border: 2px solid black; padding: 5px;">
  <table>
    <form action="{{ route('products.update', $product->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('put')
        @if ($errors->any())
            <div class="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <tr>
        <th><label>ID</label></th>
        <td><span>{{ $product->id }}</span></td>
        </tr>

        <tr>
        <th><label>商品名<span style="color: red;">*</span></div></label></th>
        <td><input type="text" placeholder="商品名を入力してください" value="{{ $product->product_name }}" name="product_name" class="input-field"></td>
        </tr>

        <tr>
        <th><label>メーカー名<span style="color: red;">*</span></div></label></th>
        <td><select name="company_id" class="input-field">
            @foreach($companies as $company)
                <option value="{{$company->id}}" {{ $product->company_id == $company->id ? 'selected' : '' }}>{{ $company->company_name }}</option>
            @endforeach
        </select></td>
        </tr>

        <tr>
        <th><label>価格<span style="color: red;">*</span></div></label></th>
        <td><input type="text" placeholder="価格を入力してください" value="{{ $product->price }}" name="price" class="input-field"></td>
        </tr>

        <tr>
        <th><label>在庫数<span style="color: red;">*</span></div></label></th>
        <td><input type="text" placeholder="在庫数を入力してください" value="{{ $product->stock }}" name="stock" class="input-field"></td>
        </tr>

        <tr>
        <th><label>コメント</label></th>
        <td><textarea name="comment" class="input-field">{{ $product->comment }}</textarea></td>
        </tr>

        <tr>
        <th><label>現在の商品画像</label></th>
        <td><img src="{{ asset('storage/productImages/' . $product->img_path) }}" alt="商品画像" style="max-width: 200px; max-height: 200px;"></td>
        </tr>

        <tr>
        <th><label>新しい商品画像を選択</label></th>
        <td><input type="file" name="img_path" accept=".png, .jpg, .jpeg"></td>
        </tr>
        </table>

        <div style="text-align: right;"><input type="submit" value="更新">
        <a href="{{ route('products.show', $product->id) }}"><button type='button'>戻る</button></a>
        </div>
      
      </form>
      </table>
      </div>  
@endsection

