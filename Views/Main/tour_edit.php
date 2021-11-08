<?php
session_start();
//コントローラーの読み込み
require_once(ROOT_PATH.'Controllers/MainController.php');
//インスタンス化
$main = new MainController();
//ダイレクトアクセス禁止
if(!isset($_SESSION['flg3']) || $_SESSION['flg3'] !== 1){
    header("Location: ./main.php");
       exit();
} 
//大会情報、大会名取得
$tournaments = $main->detail();
$tournament = $main->tournament();

if(isset($tournament)){
    //初期値の日付挿入用処理
    $day=date("Y-m-d",strtotime($tournaments['detail'][0]['date_time']));
    $time=date("h:i",strtotime($tournaments['detail'][0]['date_time']) );
    $timeval=$day."T".$time;

    $dat=date("Y-m-d",strtotime($tournaments['detail'][0]['limit_datetime']));
    $time=date("h:i",strtotime($tournaments['detail'][0]['limit_datetime']) );
    $limitTime=$day."T".$time;
}

if($_SERVER["REQUEST_METHOD"] === "POST"){ 
    $data = $_POST;  
    //エラーがあったら$errorに格納
    $error = $main->tournamentValidate($data);
    if($error === []){//エラーがなければリダイレクト
        //ダイレクトアクセスフラグ
        $_SESSION['flg3'] = 2;
       //一覧ページへ
       header("Location: /Main/tour_edit_complete.php",true,307);
       exit();
    }
    //送信後INPUTへの挿入用
    $day=date("Y-m-d",strtotime($_POST['date_time']));
    $time=date("h:i",strtotime($_POST['date_time']));
    $postTime=$day."T".$time;

    $day=date("Y-m-d",strtotime($_POST['limit_datetime']));
    $time=date("h:i",strtotime($_POST['limit_datetime']));
    $postLimit=$day."T".$time;
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
<!-- ヘッダー読み込み --> 
<?php require_once(ROOT_PATH.'Views/Main/header.php');?>
<div class="add_back">
    <div class="add_Info_box">
    <form action="./tour_edit.php" method="post">
        <div class="header_middle">
            <h2><?= $main->h($tournaments['detail'][0]['tournament_name'])?></h2>
            <div class="add_btn">
                <a href="./tour_detail.php?id=<?php if(!empty($_GET['id'])){echo $main->h($_GET['id']);}else{ echo $main->h($_POST['tournament_id']);}?>">戻る</a>
                <input type="submit" value="追加" id = "confirm">
                <input type="hidden" name="user_id" value="<?php echo $main->h($_SESSION['login_user']['0']);?>">
                <input type="hidden" name="tournament_id" value="<?php if(!empty($_GET['id'])){echo $main->h($_GET['id']);}else{ echo $main->h($_POST['tournament_id']);} ?>">
            </div> 
        </div>
        <div class="user_detail_box">
            <div class="add_Info_box">
                <div class="add_box">
                    <div class="row mb-3">
                        <span class = "error"><?php if(!empty($error['tournament_name'])){ echo $error['tournament_name'];}?></span>
                        <label for="colFormLabel" class="col-sm-2 col-form-label">大会名</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="colFormLabel" placeholder="大会名" name="tournament_name" value="<?php if(isset($_POST['tournament_name'])){ echo $main->h($_POST['tournament_name']);}else{ echo $main->h($tournaments['detail'][0]['tournament_name']);}?>">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <span class = "error"><?php if(!empty($error['date_time'])){ echo $error['date_time'];}?></span>
                        <label for="colFormLabel" class="col-sm-2 col-form-label">日時</label>
                        <div class="col-sm-10">
                            <input type="datetime-local" class="form-control" id="colFormLabel" placeholder="日時" name="date_time" value="<?php if(!empty($_POST['date_time'])){ echo $main->h($postTime);}else{ echo $main->h($timeval);}?>">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <span class = "error"><?php if(!empty($error['field'])){ echo $error['field'];}?></span>
                        <label for="colFormLabel" class="col-sm-2 col-form-label">会場</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="colFormLabel" placeholder="会場" name="field" value="<?php if(isset($_POST['field'])){ echo $main->h($_POST['field']);}else{ echo $main->h($tournaments['detail'][0]['field']);}?>">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <span class = "error"><?php if(!empty($error['address'])){ echo $error['address'];}?></span>
                        <label for="colFormLabel" class="col-sm-2 col-form-label">住所</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="colFormLabel" placeholder="住所" name="address" value="<?php if(isset($_POST['address'])){ echo $main->h($_POST['address']);}else{ echo $main->h($tournaments['detail'][0]['address']);}?>">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <span class = "error"><?php if(!empty($error['sports_name'])){ echo $error['sports_name'];}?></span>
                        <label for="colFormLabel" class="col-sm-2 col-form-label">種目</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="colFormLabel" placeholder="種目" name="sports_name" value="<?php if(isset($_POST['sports_name'])){ echo $main->h($_POST['sports_name']);}else{ echo $main->h($tournaments['detail'][0]['sports_name']);}?>">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <span class = "error"><?php if(!empty($error['licence'])){ echo $error['licence'];}?></span>
                        <label for="colFormLabel" class="col-sm-2 col-form-label">参加資格</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="colFormLabel" placeholder="参加資格" name="licence" value="<?php if(isset($_POST['licence'])){ echo $main->h($_POST['licence']);}else{ echo $main->h($tournaments['detail'][0]['licence']);}?>">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <span class = "error"><?php if(!empty($error['expense'])){ echo $error['expense'];}?></span>
                        <label for="colFormLabel" class="col-sm-2 col-form-label">参加費用</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="colFormLabel" placeholder="参加費用" name="expense" value="<?php if(isset($_POST['expense'])){ echo $main->h($_POST['expense']);}else{ echo $main->h($tournaments['detail'][0]['expense']);}?>">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <span class = "error"><?php if(!empty($error['tel'])){ echo $error['tel'];}?></span>
                        <label for="colFormLabel" class="col-sm-2 col-form-label">電話番号</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="colFormLabel" placeholder="電話番号" name="tel" value="<?php if(isset($_POST['tel'])){ echo $main->h($_POST['tel']);}else{ echo $main->h($tournaments['detail'][0]['tel']);}?>">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <span class = "error"><?php if(!empty($error['mail'])){ echo $error['mail'];}?></span>
                        <label for="colFormLabel" class="col-sm-2 col-form-label">メールアドレス</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" id="colFormLabel" placeholder="メールアドレス" name="mail" value="<?php if(isset($_POST['mail'])){ echo $main->h($_POST['mail']);}else{ echo $main->h($tournaments['detail'][0]['mail']);}?>">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <span class = "error"><?php if(!empty($error['limit_datetime'])){ echo $error['limit_datetime'];}?></span>
                        <label for="colFormLabel" class="col-sm-2 col-form-label">受付期限</label>
                        <div class="col-sm-10">
                            <input type="datetime-local" class="form-control" id="colFormLabel" placeholder="受付期限" name="limit_datetime" value="<?php if(!empty($_POST['limit_datetime'])){ echo $main->h($postLimit);}else{ echo $main->h($limitTime);}?>">
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