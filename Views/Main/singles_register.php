<?php
session_start();
//コントローラーの読み込み
require_once(ROOT_PATH.'Controllers/MainController.php');
//インスタンス化
$main = new MainController();
//ダイレクトアクセス禁止
if(!isset($_SESSION['flg2']) || $_SESSION['flg2'] !== 1){
    header("Location: ./main.php");
       exit();
} 
//ダイレクトアクセスフラグ
$_SESSION['flg5'] = 1;
//個人登録情報取得
$singles = $main->singleRegister($_GET);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="/css/style.css">
    <title>個人登録一覧</title>
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
            <div>
                <h2>個人登録一覧</h2>
            </div>
            <div>
                <a href="./tour_detail.php?id=<?php echo $main->h($_GET['id']);?>">戻る</a>
            </div> 
        </div>

        <div class="tournament_date_box">
            <div class="change">
                <div class ="group_link">
                    <span style="color:gray;">個人</span>
                    <a href="groups_register.php?id=<?php echo $main->h($_GET['id']);?>">団体</a>
                </div>
                <div class = "arrow_group">
                    <?php
                    if(isset($_GET['page']) && $_GET['page'] !== '0'){
                        $page = $_GET['page'] - 1;
                        echo "<a href='./singles_register.php?page=".$page."&id=".$_GET['id']."'>&lt;</a>";
                    }else{
                        echo "<a style='color:lightgray;' >&lt;</a>";
                    }
                    ?>  
                    <?php
                    if(isset($_GET['page']) &&  $_GET['page']  < $singles['pages']-1 ){
                        $page = $_GET['page'] + 1;
                        echo "<a href='./singles_register.php?page=".$page."&id=".$_GET['id']."'>&gt;</a>";
                    }elseif(!isset($_GET['page']) || $_GET['page'] === '0'){
                        echo "<a href='./singles_register.php?page=1&id=".$_GET['id']."'>&gt;</a>";
                    }else{
                        echo "<a style='color:lightgray;' >&gt;</a>";
                    }
                    ?>
                </div>
            </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                    <th style="color:black;">個人名</th>
                    <th>フリガナ</th>
                    <th>性別</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($singles['Info'] as $single ):?>
                    <tr>
                    <td><a href="single_detail.php?id=<?php echo $main->h($single['id']);?>&tournament_id=<?php echo $main->h($_GET['id']);?>"><?php echo $main->h($single['name']);?></a></td>
                    <td><?php echo$main->h( $single['kana']); ?></td>
                    <td><?php if($single['sex'] === '0'){echo '男性';}else{ echo '女性';} ?></td>
                    </tr>  
                    <?php endforeach;?>
                </tbody>
            </table>

        </div>
    </div>
</div>

</body>
</html>