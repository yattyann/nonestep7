<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>商品情報編集画面</title>
</head>
<body>
  <form>
    <label>ID</label>

    <label>商品名</label> 
    <input type="text" placeholder="商品名を入力してください">
    <br>

    <label>メーカー名</label> 
    <select> 
      <option>アサヒ</option> 
      <option>コカ・コーラ</option> 
      <option>キリン</option> 
      <option>DyDo</option> 
    </select>
    <br> 

    <label>価格</label> 
    <input type="text" placeholder="価格を入力してください">
    <br>

    <label>在庫数</label> 
    <input type="text" placeholder="在庫数を入力してください">
    <br>

    <label>コメント</label> 
    <textarea></textarea>
    <br>

    <label>商品画像</label> 
    <input type="file" name="example" accept=".png, .jpg, .jpeg, .pdf, .doc">  
    <br>
    <br>

    <input type="submit" value="更新"> 
    <a href="{{ route('products.show') }}"><button type='button'>戻る</button></a>
  </form>
@endsection