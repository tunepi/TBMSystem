<?php
session_start();
//コントローラーの読み込み
require_once(ROOT_PATH.'Controllers/LoginController.php');
//インスタンス化
$login = new LoginController();

if($_SERVER["REQUEST_METHOD"] === "POST"){ 
    $data = $_POST;  
    $error = $login->register_validate($data);
    //メソッドの呼び出し
    if(isset($_POST['email']) && $error === []){
        $login->userRegister($_POST); 
        header("Location: /Main/main.php",true,307);
        exit();
    }
}
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

    <form class="login_form" action="new_register.php" method="POST">
        <div class="register_reset_container">
            <div class="login_wrapper">
                <div class="login_box">
                    <h3>New Register</h3>
                    <div style="border-bottom:solid 1px lightgray; margin-bottom:30px;"></div>
                     <!-- ユーザネーム -->
                    <div style="margin-bottom:30px;">
                        <span><?php if(!empty($error['name'])){ echo $error['name'];}?></span>
                        <div class="row mb-3">
                            <label for="inputEmail3" class="col-sm-2 col-form-label">Username</label>
                            <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputEmail1" name="name" value="<?php if(!empty($_POST['name'])){echo $login->h($_POST['name']);}?>">
                            </div>
                        </div>
                    </div>
                    <!-- メールアドレス -->
                    <span><?php if(!empty($error['email'])){ echo $error['email'];}?></span>
                    <div style="margin-bottom:30px;">
                        <div class="row mb-3">
                            <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10">
                            <input type="email" class="form-control" id="inputEmail2" name="email" value="<?php if(!empty($_POST['email'])){echo $login->h($_POST['email']);}?>">
                            </div>
                        </div>
                    </div>
                    <!-- パスワード -->
                    <span><?php if(!empty($error['password'])){ echo $error['password'];}?></span>
                    <div style="margin-bottom:30px;">
                        <div class="row mb-3">
                            <label for="inputPassword3" class="col-sm-2 col-form-label">Password</label>
                            <div class="col-sm-10">
                            <input type="password" class="form-control" id="inputPassword3" name="password" value="<?php if(!empty($_POST['password'])){echo $login->h($_POST['password']);}?>">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">登録</button>
                    <div style="border-bottom:solid 1px lightgray; margin:30px 0;"></div>
                    <!-- ログインページへ遷移するlink -->
                    <a href="./login.php" type="submit" class="btn btn-info" id="login_link">ログインページへ</a>
                    
                </div>
            </div>
        </div>
    </form>
    <!--セッションの初期化-->
    <?php $_SESSION = array(); session_destroy();?>
</body>
</html>