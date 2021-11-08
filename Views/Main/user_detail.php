<?php
session_start();
//コントローラーの読み込み
require_once(ROOT_PATH.'Controllers/MainController.php');
//インスタンス化
$main = new MainController();
//ダイレクトアクセス禁止
if(isset($_SESSION['login_user'])){
    
}elseif(isset($_SESSION['array']['name'])){

}elseif($_SESSION['fb_name']){

}else{
    header("Location: /Logins/login.php");
       exit();
}
//ユーザ情報の取得
$name = $main->getUserDetail($_SESSION);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="/css/style.css">
    <title>ログイン</title>
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
        <div class="header_middle" style="margin-bottom:20px;">
            <h2>ログインユーザ情報</h2>
            <div><a href="./main.php">トップページへ</a></div> 
        </div>
        <div class="add_Info_box">
            <div class="add_box">
                <div class="user_detail_box">
                    <?php if(isset($_SESSION['login_user'])):?>
                    <div class="detail">
                        <span>ユーザ名：</span>
                        <span><?php echo $main->h($_SESSION['login_user']['name']);?></span>
                    </div>
                    <div class="detail">
                        <span>メールアドレス：</span>
                        <span><?php echo $main->h($_SESSION['login_user']['mail']);?></span>
                    </div>
                    <!-- <div class="detail">
                        <span>パスワード：</span>
                        <span><?php echo $main->h($_SESSION['login_user']['password']);?></span>
                    </div> -->
                    <?php endif;?>

                    <?php if(isset($_SESSION['array']['name'])):?>
                    <div class="detail">
                        <span>ユーザ名：</span>
                        <span><?php echo $main->h($_SESSION['array']['name']);?></span>
                    </div>
                    <div class="detail">
                        <span>ユーザID：</span>
                        <span><?php echo $main->h($_SESSION['array']['screen_name']);?></span>
                    </div>
                    <?php endif;?>

                    <?php if(isset($_SESSION['fb_name'])):?>
                    <div class="detail">
                        <span>ユーザID：</span>
                        <span><?php echo $main->h($_SESSION['fb_id']);?></span>
                    </div>    
                    <div class="detail">
                        <span>ユーザ名：</span>
                        <span><?php echo $main->h($_SESSION['fb_name']);?></span>
                    </div>
                    
                    <div class="detail">
                        <span>苗字：</span>
                        <span><?php echo $main->h($_SESSION['fb_last_name']);?></span>
                    </div>
                    <div class="detail">
                        <span>名前：</span>
                        <span><?php echo $main->h($_SESSION['fb_first_name']);?></span>
                    </div>
                    <?php endif;?>
                </div>
            </div>    
        </div>
    </div>
</div>

</body>
</html>