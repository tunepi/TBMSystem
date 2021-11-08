<?php
session_start();

setcookie("PHPSESSID", '', time() - 1800, '/');
//コントローラーの読み込み
require_once(ROOT_PATH.'Controllers/LoginController.php');
//インスタンス化
$login = new LoginController();

if($_SERVER["REQUEST_METHOD"] === "POST"){ 
    $data = $_POST;  
    //エラーがあったら$errorに格納
    $error = $login->login_validate($data);
    //メールアドレス、パスワード等を抽出して格納
    $params = $login->login($data);
    
    if(!$params){

    }elseif($error === []){//エラーがなければリダイレクト
       //一覧ページへ
       header("Location: /Main/main.php",true,307);
       exit();
    }
}    

//設定ファイル
require_once(ROOT_PATH.'Views/Logins/config.php');
 
$helper = $fb->getRedirectLoginHelper();

$scope = ['public_profile'];

$loginUrl = $helper->getLoginUrl('http://localhost:8888/Logins/fbcallback.php', $scope);



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
    <header>
        <h2 class="logo">TBMSystem</h2>
    </header>
    <div class="back_box">
    <form class="login_form" action="/Logins/login.php" method="post">
        <div class="login_container">
            <div class="login_wrapper">
                <div class="login_box">
                    <h3>Login</h3>
                    <div style="border-bottom:solid 1px lightgray; margin-bottom:30px;"></div>
                    <!-- メールアドレス -->
                    <span><?php if(!empty($error['email'])){ echo $error['email'];}elseif(!empty($_SESSION['msg'])){echo $login->h($_SESSION['msg']);}?></span>
                    <div style="margin-bottom:30px;">
                        <div class="row mb-3">
                            <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10">
                            <input type="email" class="form-control" id="inputEmail2" name="email" value="<?php if(!empty($_POST['email'])){echo $login->h($_POST['email']);}?>">
                            </div>
                        </div>
                    </div>
                    <!-- パスワード -->
                    <span><?php if(!empty($error['password'])){ echo $error['password'];}elseif(!empty($_SESSION['pass_msg'])){echo $login->h($_SESSION['pass_msg']);}?></span>
                    <div style="margin-bottom:30px;">
                        <div class="row mb-3">
                            <label for="inputPassword3" class="col-sm-2 col-form-label">Password</label>
                            <div class="col-sm-10">
                            <input type="password" class="form-control" id="inputPassword3" name="password" >
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">ログイン</button>
                    <div style="border-bottom:solid 1px lightgray; margin:30px 0;"></div>
                    <!-- APIログインボタン -->
                    <a href="./twitterLogin.php" class="btn btn-info" id="twitter">twitterでログイン</a>
                    <a href="<?php echo $loginUrl; ?>" class="btn btn-primary" id="facebook">facebookでログイン</a>
                    <!-- パスワードリセット、新規登録link -->
                    <div class="link">
                        <a href="./pass_reset.php" >パスワードをお忘れの方はこちら</a>
                        <a href="./new_register.php">新規登録の方はこちら</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
    </div>
    <!--セッションの初期化-->
    <?php //クッキー削除
       $_SESSION = array(); session_destroy();
    ?>
</body>
</html>