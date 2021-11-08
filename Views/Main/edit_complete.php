<?php
session_start();
//コントローラーの読み込み
require_once(ROOT_PATH.'Controllers/MainController.php');
//インスタンス化
$main = new MainController();
//ダイレクトアクセス禁止
if(!isset($_POST['name'])){
    header("Location: ./main.php");
       exit();
} 
$detail = $main->detail();

if(!empty($_POST['team_name'])){
    //個人の登録処理
    $main->singleUpdate($_POST);
}else{
    //団体の登録処理
    $main->groupUpdate($_POST);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="/css/style.css">
    <title>編集完了</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <!-- Bootstrap CSS --> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="../js/index.js" defer></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>
<!-- Bootstrap JavaScript Bundle with Popper -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<!-- ヘッダー読み込み --> 
<?php require_once(ROOT_PATH.'Views/Main/header.php');?>
<div class="detail_back">
    <div class="delete_back_box">
        <div class="header_middle">
            <h2><?= $main->h($detail['detail'][0]['tournament_name'])?></h2>
        </div>

        <div class="delete_box">
            <div class="delete_box_inner">
                <p>登録情報の更新が完了しました！</p>
                <p><a href="/Main/main.php">大会一覧へ</a>を押し確認してください。</p>
            </div>
        </div>
    </div>
</div>

</body>
</html>