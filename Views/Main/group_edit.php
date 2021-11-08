<?php
session_start();
//コントローラーの読み込み
require_once(ROOT_PATH.'Controllers/MainController.php');
//インスタンス化
$main = new MainController();
//ダイレクトアクセス禁止
if(!isset($_SESSION['flg6']) || $_SESSION['flg6'] !== 1 && !isset($_GET['tournament_id'])){
    header("Location: ./main.php");
       exit();
}  
//団体情報取得
/* if(isset($_GET)){
    $groups = $main->groupDetail($_GET);
} */

//団体詳細情報取得
if(!empty($_GET)){
    $groups = $main->groupDetail($_GET);
}else{
    $id['id'] = $_POST['id'];
    $groups = $main->groupDetail($id);
}
$detail = $main->detail(); 

if($_SERVER["REQUEST_METHOD"] === "POST"){ 
    $data = $_POST;  
    //エラーがあったら$errorに格納
    $error = $main->groupValidate($data);
    if($error === []){//エラーがなければリダイレクト
        //ダイレクトアクセスフラグ
        $_SESSION['flg6'] = 2;
       //一覧ページへ
       header("Location: /Main/edit_complete.php",true,307);
       exit();
    }
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="/css/style.css">
    <title>団体編集</title>
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
    <form action="./group_edit.php" method="post">
        <div class="header_middle">
            <h2><?= $main->h($detail['detail'][0]['tournament_name'])?></h2>
            <div class="add_btn">
                <a href="./group_detail.php?id=<?php if(!empty($_GET['id'])){echo $main->h($_GET['id']);}else{ echo $main->h($groups['Info'][0]['id']);}?>&tournament_id=<?php if(!empty($_GET['tournament_id'])){echo $main->h($_GET['tournament_id']);}else{echo $main->h($id['id']);}?>">戻る</a>
                <input type="submit" value="登録" id = "confirm">
                <input type="hidden" name="user_id" value="<?php echo $main->h($_SESSION['login_user']['0']);?>">
                <input type="hidden" name="tournament_id" value="<?php if(isset($_GET['tournament_id'])){echo $main->h($_GET['tournament_id']);}elseif($_POST['id']){echo $main->h($_POST['id']);}?>">
                <input type="hidden" name="id" value="<?php if(isset($_GET['id'])){echo $main->h($_GET['id']);}elseif($_POST['id']){echo $main->h($_POST['id']);}?>">
            </div> 
        </div>
        <div class="user_detail_box">
            <div class="add_Info_box">
                <div class="add_box">
                    <h3>登録情報を入力してください</h3>
                    <div class="row mb-3">
                        <span class = "error"><?php if(!empty($error['name'])){ echo $error['name'];}?></span>
                        <label for="colFormLabel" class="col-sm-2 col-form-label">団体名：</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="colFormLabel" placeholder="団体名" name="name" value="<?php if(!empty($_POST['name'])){echo $main->h($_POST['name']);}elseif(!empty($groups['Info'][0]['name'])){echo $main->h($groups['Info'][0]['name']);}?>">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <span class = "error"><?php if(!empty($error['kana'])){ echo $error['kana'];}?></span>
                        <label for="colFormLabel" class="col-sm-2 col-form-label">フリガナ：</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="colFormLabel" placeholder="フリガナ" name="kana" value="<?php if(!empty($_POST['kana'])){echo $main->h($_POST['kana']);}elseif(!empty($groups['Info'][0]['kana'])){echo $main->h($groups['Info'][0]['kana']);}?>">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <span class = "error"><?php if(!empty($error['team_number'])){ echo $error['team_number'];}?></span>    
                        <label for="colFormLabel" class="col-sm-2 col-form-label">チーム人数：</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="colFormLabel" placeholder="チーム人数" name="team_number" value="<?php if(!empty($_POST['team_number'])){echo $main->h($_POST['team_number']);}elseif(!empty($groups['Info'][0]['team_number'])){echo $main->h($groups['Info'][0]['team_number']);}?>">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <span class = "error"><?php if(!empty($error['man'])){ echo $error['man'];}?></span>
                        <label for="colFormLabel" class="col-sm-2 col-form-label">男性人数：</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="colFormLabel" placeholder="男性" name="man" value="<?php if(!empty($_POST['man'])){echo $main->h($_POST['man']);}elseif(!empty($groups['Info'][0]['man'])){echo $main->h($groups['Info'][0]['man']);}?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <span class = "error"><?php if(!empty($error['woman'])){ echo $error['woman'];}?></span>
                        <label for="colFormLabel" class="col-sm-2 col-form-label">女性人数：</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="colFormLabel" placeholder="女性" name="woman" value="<?php if(!empty($_POST['woman'])){echo $main->h($_POST['woman']);}elseif(!empty($groups['Info'][0]['woman'])){echo $main->h($groups['Info'][0]['woman']);}?>">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <span class = "error"><?php if(!empty($error['tel'])){ echo $error['tel'];}?></span>
                        <label for="colFormLabel" class="col-sm-2 col-form-label">電話番号：</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="colFormLabel" placeholder="電話番号" name="tel" value="<?php if(!empty($_POST['tel'])){echo $main->h($_POST['tel']);}elseif(!empty($groups['Info'][0]['tel'])){echo $main->h($groups['Info'][0]['tel']);}?>">
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