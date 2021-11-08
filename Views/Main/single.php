<?php
session_start();
//コントローラーの読み込み
require_once(ROOT_PATH.'Controllers/MainController.php');
//インスタンス化
$main = new MainController();
//ダイレクトアクセス禁止
if(!isset($_SESSION['flg1']) || $_SESSION['flg1'] !== 1){
    header("Location: ./main.php");
       exit();
} 
//大会情報取得
$detail = $main->detail(); 
if(!empty($_GET['id'])){
    $_SESSION['single_id'] = $_GET['id'];
}

if($_SERVER["REQUEST_METHOD"] === "POST"){ 
    $data = $_POST;  
    //エラーがあったら$errorに格納
    $error = $main->singleValidate($data);
    if($error === []){//エラーがなければリダイレクト
       //ダイレクトアクセスフラグ
       $_SESSION['flg1'] =2;
       header("Location: /Main/register_complete.php",true,307);
       exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="/css/style.css">
    <title>個人登録</title>
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
<div class="add_back">
    <div class="add_Info_box">
        <form action="./single.php" method="post">
            <div class="header_middle">
                <h2><?= $main->h($detail['detail'][0]['tournament_name'])?></h2>
                <div class="add_btn">
                    <a href="./tour_detail.php?id=<?php if(!empty($_GET['id'])){echo $main->h($_GET['id']);}else{ echo $main->h($detail['detail'][0]['id']);}?>">戻る</a>
                    <input type="submit" value="登録" id = "add" class="submit_single">
                    <input type="hidden" name="user_id" value="<?php if($_SESSION['login_user']['0']){echo $main->h($_SESSION['login_user']['0']);}?>">
                    <input type="hidden" name="tournament_id" value="<?php if(!empty($_GET['id'])){echo $main->h($_GET['id']);}else{ echo $main->h($_SESSION['single_id']);}?>">
                    
                </div> 
            </div>
            <div class="user_detail_box">
                <div class="add_Info_box">
                    <div class="add_box">
                        <h3>登録情報を入力してください</h3>
                        <div class="row mb-3">
                            <span class = "error"><?php if(!empty($error['name'])){ echo $error['name'];}?></span>
                            <label for="colFormLabel" class="col-sm-2 col-form-label">氏名：</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="colFormLabel" placeholder="氏名" name="name" value="<?php if(!empty($_POST['name'])){echo $main->h($_POST['name']);}?>">
                                
                            </div>
                        </div>

                        <div class="row mb-3">
                            <span class = "error"><?php if(!empty($error['kana'])){ echo $error['kana'];}?></span>
                            <label for="colFormLabel" class="col-sm-2 col-form-label">フリガナ：</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="colFormLabel" placeholder="フリガナ" name="kana" value="<?php if(!empty($_POST['kana'])){echo $main->h($_POST['kana']);}?>">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <span class = "error"><?php if(!empty($error['age'])){ echo $error['age'];}?></span>
                            <label for="colFormLabel" class="col-sm-2 col-form-label">年齢：</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="colFormLabel" placeholder="年齢" name="age" value="<?php if(!empty($_POST['age'])){echo $main->h($_POST['age']);}?>">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <span class = "error"><?php if(!empty($error['team_name'])){ echo $error['team_name'];}?></span>
                            <label for="colFormLabel" class="col-sm-2 col-form-label">チーム名：</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="colFormLabel" placeholder="チーム名" name="team_name" value="<?php if(!empty($_POST['team_name'])){echo $main->h($_POST['team_name']);}?>">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <span class = "error"><?php if(!empty($error['sex'])){ echo $error['sex'];}?></span>
                            <label for="colFormLabel" class="col-sm-2 col-form-label">性別：</label>
                            <div class="col-sm-10">
                                <input class="form-check-input" type="radio" id="flexRadioDefault1" name="sex" value="0" <?php if(isset($_POST['sex']) && $_POST['sex'] == 0){ echo 'checked';}?>>
                                <label class="form-check-label" for="flexRadioDefault1">
                                男性
                                </label>
                                <input class="form-check-input" type="radio" id="flexRadioDefault1" name = "sex" value="1" <?php if(isset($_POST['sex']) && $_POST['sex'] == 1){ echo 'checked';}?>>
                                <label class="form-check-label" for="flexRadioDefault1">
                                女性
                                </label>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <span class = "error"><?php if(!empty($error['tel'])){ echo $error['tel'];}?></span>
                            <label for="colFormLabel" class="col-sm-2 col-form-label">電話番号：</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="colFormLabel" placeholder="01234567890" name="tel" value="<?php if(!empty($_POST['tel'])){echo $main->h($_POST['tel']);}?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>    
        </form>
    </div>
</div>

</body>
</html>