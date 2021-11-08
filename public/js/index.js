//ポップアップ削除機能
//deleteクラスがクリックされた時にイベントを起動
$('#delete').off('click'); 
$('#delete').on('click',function(event){
    //定数宣言でdeleteクラスのハイパーリンクを定数へ代入
    const url = $(this).attr("href");
    //ハイパーリンク起動を一度止める
    event.preventDefault();
    //ポップアップによる条件分岐
    if(window.confirm("削除しますか？")){
       //条件分岐がtrueの時ハイパーリンクを起動させる
       window.location.href = url;
    }
  });
  //登録の確認画面
  $('#add').off('click'); 
  $('#add').on('click',function(e){
    //ポップアップによる条件分岐
    if(window.confirm("下記内容で登録していいですか？")){
        //何もしない
    }else{
        //キャンセル時イベントの停止
        e.preventDefault();
    }
  }); 
  //編集の確認画面
  $('#confirm').off('click'); 
  $('#confirm').on('click',function(e){
    //ポップアップによる条件分岐
    if(window.confirm("下記内容で更新していいですか？")){
        //何もしない
    }else{
        //キャンセル時イベントの停止
        e.preventDefault();
    }
  }); 

