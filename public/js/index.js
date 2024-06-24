$(function() {
  // ボタンがクリックされた場合
  $('button').on('click', function(){
     //ここでサーバーに対しての通信を行う。情報の指定（ここではdataに格納）、送信先、データの型（Json）等を記述
     $.ajax({
      type: 'get',
      url: '/todos.json',
      data: {
        todo: {
          content: todo
        }
      },
      dataType: 'json' //データをjson形式で飛ばす
    })
    //↓フォームの送信に成功した場合の処理
    .done(function(data) {
      var html = buildHTML(data);
      $('.todos').append(html); //$.append関数は操作後はDOMに要素が追加された状態になる。
                                //todosクラスに引数で指定したdataのHTML要素を追加。

      textField.val(''); //
    })
    //↓フォームの送信に失敗した場合の処理
    .fail(function() {
      alert('error');
    });
    return false;
  });
});

