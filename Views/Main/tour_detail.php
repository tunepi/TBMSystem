<?php
session_start();
//コントローラーの読み込み
require_once(ROOT_PATH.'Controllers/MainController.php');
//インスタンス化
$main = new MainController();
//ダイレクトアクセス禁止
if(!isset($_SESSION['flg']) || $_SESSION['flg'] !== 0){
    header("Location: ./main.php");
       exit();
} 
//ダイレクトアクセス禁止
$_SESSION['flg1'] = 1;
$_SESSION['flg2'] = 1;
$_SESSION['flg3'] = 1;
$_SESSION['flg4'] = 1;
//大会情報取得処理
$detail = $main->detail($_GET);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="/css/style.css">
    <title>大会の詳細</title>
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
            <h2><?= $main->h($detail['detail'][0]['tournament_name'])?></h2>
            <div>
                <a href="./main.php" style = "margin-right:15px;">戻る</a>
                <!-- 一般アカウントかつ受付期限内の時に表示 -->
                <?php if(date('Y-m-d') <= date('Y-m-d',strtotime($detail['detail'][0]['limit_datetime'])) && ((isset($_SESSION ["login_user"]['role']) && $_SESSION ["login_user"]['role'] === "0") || isset($_SESSION['array']['name']) || isset($_SESSION['fb_name']))):?>
                <a href="./single.php?id=<?php echo $main->h($detail['detail'][0]['id'])?>">個人登録</a>
                <a href="./group.php?id=<?php echo $main->h($detail['detail'][0]['id'])?>" style="margin-left:20px;">団体登録</a>
                <?php endif;?>
                <!-- 管理者アカウントなら表示 -->
                <?php if(!empty($_SESSION ["login_user"]['role']) && $_SESSION ["login_user"]['role'] === "1"):?>
                    <a href="./single.php?id=<?php echo $main->h($detail['detail'][0]['id'])?>">個人登録</a>
                    <a href="./group.php?id=<?php echo $main->h($detail['detail'][0]['id'])?>" style="margin-left:20px;">団体登録</a>    
                    <a href="singles_register.php?id=<?php echo $main->h($detail['detail'][0]['id'])?>" style="margin-left:20px;">参加者登録一覧</a>
                    <a href="tour_edit.php?id=<?php echo $main->h($detail['detail'][0]['id'])?>" style="margin-left:20px;">編集</a>
                    <a class="delete" href="tour_delete_complete.php?id=<?php echo $main->h($detail['detail'][0]['id'])?>" style="margin-left:20px;" id = "delete">削除</a>
                <?php endif;?>
            </div> 
        </div>
        <!-- 大会の詳細情報表示 -->
        <div class="user_detail_box">
            <div class="add_Info_box">
                <div class="add_box">
                    <div class="tour_detail_inner">
                        <div class="tour_detail"><label>大会名:</label></div>
                        <div><span><?= $main->h($detail['detail'][0]['tournament_name'])?></span></div>
                    </div>
                    <div class="tour_detail_inner">
                        <div class="tour_detail"><label>日時:</label></div>
                        <div><span><?= $main->h(date('Y年m月d日h時i分',strtotime($detail['detail'][0]['date_time'])))?></span></div>
                    </div>
                    <div class="tour_detail_inner">
                        <div class="tour_detail"><label>会場:</label></div>
                        <div><span><?= $main->h($detail['detail'][0]['field'])?></span></div>
                    </div>
                    <div class="tour_detail_inner">
                        <div class="tour_detail"><label>住所:</label></div>
                        <div><span><?= $main->h($detail['detail'][0]['address'])?></span></div>
                    </div>
                    <div class="tour_detail_inner">
                        <div class="tour_detail"><label>種目:</label></div>
                        <div><span><?= $main->h($detail['detail'][0]['sports_name'])?></span></div>
                    </div>
                    <div class="tour_detail_inner">
                        <div class="tour_detail"><label>参加資格:</label></div>
                        <div><span><?= $main->h($detail['detail'][0]['licence'])?></span></div>
                    </div>
                    <div class="tour_detail_inner">
                        <div class="tour_detail"><label>参加費用:</label></div>
                        <div><span><?= $main->h($detail['detail'][0]['expense'])?>円</span></div>
                    </div>
                    <div class="tour_detail_inner">
                        <div class="tour_detail"><label>電話番号:</label></div>
                        <div><span><?= $main->h($detail['detail'][0]['tel'])?></span></div>
                    </div>
                    <div class="tour_detail_inner">
                        <div class="tour_detail"><label>メールアドレス:</label></div>
                        <div><span><?= $main->h($detail['detail'][0]['mail'])?></span></div>
                    </div>
                    <div class="tour_detail_inner">
                        <div class="tour_detail"><label>受付期限:</label></div>
                        <div><span><?= $main->h(date('Y年m月d日h時i分',strtotime($detail['detail'][0]['limit_datetime'])))?></span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>