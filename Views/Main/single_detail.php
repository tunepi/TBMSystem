<?php
session_start();
//コントローラーの読み込み
require_once(ROOT_PATH.'Controllers/MainController.php');
//インスタンス化
$main = new MainController();
//ダイレクトアクセス禁止
if(!isset($_SESSION['flg5']) || $_SESSION['flg5'] !== 1){
    header("Location: ./main.php");
       exit();
}  

//個人の情報取得
$singles = $main->singleDetail($_GET);
//大会情報取得
$detail = $main->detail();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="/css/style.css">
    <title>個人詳細情報</title>
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
    <div class="detail_box">
        <div class="header_middle">
            <h2>参加者情報</h2>
            <div>
                <a href="singles_register.php?id=<?php echo $main->h($_GET['tournament_id']);?>"style="margin-left:20px;">戻る</a>
                <a href="single_edit.php?id=<?php echo $main->h($singles['Info'][0]['id']);?>&tournament_id=<?php echo $main->h($_GET['tournament_id']);?>"style="margin-left:20px;">編集</a>
                <a href="single_group_delete.php?id=<?php echo $main->h($singles['Info'][0]['id']);?>&tournament_id=<?php echo $main->h($_GET['tournament_id']);?>&dlt=0"style="margin-left:20px;" id="delete">削除</a>
            </div> 
        </div>

        <div class="user_detail_box">
            <div class="add_Info_box">
                <div class="add_box">
                    <div class="tour_detail_inner">
                        <div class="tour_detail"><label>氏名:</label></div>
                        <div><span><?php echo $main->h($singles['Info'][0]['name']);?></span></div>
                    </div>
                    <div class="tour_detail_inner">
                        <div class="tour_detail"><label>フリガナ:</label></div>
                        <div><span><?php echo $main->h($singles['Info'][0]['kana']);?></span></div>
                    </div>
                    <div class="tour_detail_inner">
                        <div class="tour_detail"><label>年齢:</label></div>
                        <div><span><?php echo $main->h($singles['Info'][0]['age']);?>歳</span></div>
                    </div>
                    <div class="tour_detail_inner">
                        <div class="tour_detail"><label>チーム名:</label></div>
                        <div><span><?php echo $main->h($singles['Info'][0]['team_name']);?></span></div>
                    </div>
                    <div class="tour_detail_inner">
                        <div class="tour_detail"><label>性別:</label></div>
                        <div><span><?php if($singles['Info'][0]['sex'] === '0'){echo '男性';}else{ echo'女性';}?></span></div>
                    </div>
                    <div class="tour_detail_inner">
                        <div class="tour_detail"><label>電話番号:</label></div>
                        <div><span><?php echo $main->h($singles['Info'][0]['tel']);?></span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>