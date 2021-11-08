<?php
require_once(ROOT_PATH.'/Models/Main.php');

class MainController {
    private $Main;

    public function __construct() {
        //リクエストパラメータの取得
        $this->request['get'] = $_GET;
        $this->request['post'] = $_POST;
        //モデルのplayerオブジェクト生成
        $this->Main = new Main();
    }    

    //XSS対策：エスケープ処理
    public function h($s){
        return htmlspecialchars($s,ENT_QUOTES,'UTF-8');
    }
    //ユーザ名の取得
    public function getUsername($data){
        if(!empty($data["login_user"]['mail'])){
            $name = $this->Main->getUsername($data["login_user"]['mail']);
            return $name;
        }
        
        
    }
    //ログインユーザの情報取得
    public function getUserDetail($data){
        if(!empty($data["login_user"]['mail'])){
            $name = $this->Main->getUserDetail($data["login_user"]['mail']);

            return $name;
        }
        
    }
    

    //バリデーション
    public function tournamentValidate($data){
        //エラーメッセージ変数の配列化
        $errorArr = array();
        //空チェック
        if(empty($data['tournament_name'])){
            $errorArr['tournament_name'] = "大会名は必須入力です。";
        }
        if(mb_strlen($data['tournament_name']) > 20){
            $errorArr['tournament_name'] = '大会名は20文字以内です';
        }
        if(empty($data['date_time'])){
            $errorArr['date_time'] = "日時は必須入力です。";
        }elseif(date('Y-m-d',strtotime($data['date_time'])) < date('Y-m-d')){
                $errorArr['date_time'] = "正しい日時を入力して下さい。";
            
        } 
        if(empty($data['field'])){
            $errorArr['field'] = "会場は必須入力です。";
        }if(mb_strlen($data['field']) > 20){
            $errorArr['field'] = '会場は20文字以内です';
        }
        if(empty($data['address'])){
            $errorArr['address'] = "住所は必須入力です。";
        }elseif(!preg_match("/(.*?[都道府県])(.*?[市区町村])/u", $data['address'])){
            $errorArr['address'] = "住所を正しく入力して下さい。";
        }
        if(empty($data['sports_name'])){
            $errorArr['sports_name'] = "種目は必須入力です。";
        }if(mb_strlen($data['sports_name']) > 20){
            $errorArr['sports_name'] = '種目は20文字以内です';
        }
        if(empty($data['licence'])){
            $errorArr['licence'] = "参加資格は必須入力です。";
        }if(mb_strlen($data['licence']) > 20){
            $errorArr['licence'] = '参加資格は20文字以内です';
        }
        if(empty($data['expense'])){
            $errorArr['expense'] = "参加費用は必須入力です。";
        }if(mb_strlen($data['expense']) > 20){
            $errorArr['expense'] = '参加費用は20文字以内です';
        }
        if(empty($data['tel'])){
            $errorArr['tel'] = "電話番号は必須入力です。";
        }
        if(!preg_match("/^[0-9]{11}$/",$data['tel'])){ 
            $errorArr['tel'] = "電話番号は0-9の数字のみでご入力ください。";
        } 
        if(empty($data['mail'])){
            $errorArr['mail'] = "メールアドレスは必須入力です。";
        }elseif(!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9._-]+)+$/" , $data['mail'])){
            $errorArr['mail'] = "メールアドレスを正しく入力してください。";
        }
        if(empty($data['limit_datetime'])){
            $errorArr['limit_datetime'] = "日時は必須入力です。";
        }elseif(date('Y-m-d',strtotime($data['limit_datetime'])) < date('Y-m-d')){
            $errorArr['limit_datetime'] = "正しい日時を入力して下さい。";
        }elseif(date('Y-m-d',strtotime($data['date_time'])) < date('Y-m-d',strtotime($data['limit_datetime']))){
            $errorArr['limit_datetime'] = "開催日時より前の日付です。";
        
        }
       
        return $errorArr;
    }
    //個人登録のバリデーション
    public function singleValidate($data){
        //エラーメッセージ変数の配列化
        $error = array();
        //氏名＝空チェック＋文字制限
        if(empty($data['name'])){
            $error['name'] = '氏名は必須入力です';
        }
        if(mb_strlen($data['name']) > 10){
            $error['name'] = '氏名は10文字以内です';
        }
        //フリガナ＝空チェック＋文字制限
        if(empty($data['kana'])){
            $error['kana'] = 'フリガナは必須入力です';
        }
        if(mb_strlen($data['kana']) > 10){
            $error['kana'] = 'フリガナは10文字以内です';
        }
        //年齢＝空チェック＋数字のみ
        if(empty($data['age'])){
            $error['age'] = "年齢は必須入力です。";
        }elseif(!preg_match("/^[0-9]+$/", $data['age'])){
            $error['age'] = "数字しか入力できません。";
        }
        //チーム名＝空チェック＋文字制限
        if(empty($data['team_name'])){
            $error['team_name'] = 'チーム名は必須入力です';
        }
        if(mb_strlen($data['team_name']) > 20){
            $error['team_name'] = 'チーム名は20文字以内です';
        }
        //性別＝空チェック＋文字制限
        if(!isset($data['sex'])){
            $error['sex'] = '性別を選択して下さい';
        }
        //電話番号＝空チェック＋文字制限
        if(empty($data['tel'])){
            $error['tel'] = '電話番号は必須入力です';
        }elseif(!preg_match("/^[0-9]{11}$/",$data['tel'])){ 
            $error['tel'] = "電話番号は0-9の数字のみでご入力ください。";
        } 
        return $error;
    }
    //団体のバリデーション
    public function groupValidate($data){
        //エラーメッセージ変数の配列化
        $error = array();
        //氏名＝空チェック＋文字制限
        if(empty($data['name'])){
            $error['name'] = '団体名は必須入力です';
        }
        if(mb_strlen($data['name']) > 20){
            $error['name'] = '団体名は20文字以内です';
        }
        //フリガナ＝空チェック＋文字制限
        if(empty($data['kana'])){
            $error['kana'] = 'フリガナは必須入力です';
        }
        if(mb_strlen($data['kana']) > 20){
            $error['kana'] = 'フリガナは20文字以内です';
        }
        //チーム人数＝空チェック＋数字のみ
        if(empty($data['team_number'])){
            $error['team_number'] = "チーム人数は必須入力です。";
        }elseif(!preg_match("/^[0-9]+$/", $data['team_number'])){
            $error['team_number'] = "数字しか入力できません。";
        }elseif($data['team_number'] != ($data['man'] + $data['woman'])){
            $error['team_number'] = "正しい人数を入力して下さい。";

        }
        //男の人数＝空チェック＋数字のみ
        if(!isset($data['man'])){
            $error['man'] = "人数は必須入力です。";
        }elseif(!preg_match("/^[0-9]+$/", $data['man'])){
            $error['man'] = "数字しか入力できません。";
        }
        //女の人数＝空チェック＋数字のみ
        if(!isset($data['woman'])){
            $error['woman'] = "人数は必須入力です。";
        }elseif(!preg_match("/^[0-9]+$/", $data['man'])){
            $error['woman'] = "数字しか入力できません。";
        }
        //電話番号＝空チェック＋文字制限
        if(empty($data['tel'])){
            $error['tel'] = '電話番号は必須入力です';
        }elseif(!preg_match("/^[0-9]{11}$/",$data['tel'])){ 
            $error['tel'] = "電話番号は0-9の数字のみでご入力ください。";
        } 
        return $error;
    }

    //大会の追加
    public function tourAdd($userData){
        $this->Main->tourAdd($userData);
    }
    //大会の削除
    public function tourDelete($id){
        $this->Main->tourDelete($id);
    }
    //大会の編集
    public function tourUpdate($data){
        $this->Main->tourUpdate($data);
    }


    //個人参加登録
    public function singleAdd($userData){
        $this->Main->singleAdd($userData);
    }
    //個人編集後更新処理
    public function singleUpdate($userData){
        $this->Main->singleUpdate($userData);
    }
    //個人登録情報削除
    public function singleDelete($userData){
        $this->Main->singleDelete($userData);
    }


    //団体参加登録
    public function groupAdd($userData){
        $this->Main->groupAdd($userData);
    }
    //団体編集後更新処理
    public function groupUpdate($userData){
        $this->Main->groupUpdate($userData);
    }
    //個人登録情報削除
    public function groupDelete($userData){
        $this->Main->groupDelete($userData);
    }

     //データ一覧
    public function tournament(){
        $page = 0;
        //Undefined index:対策
        if(isset($this->request['get']['page'])){
            $page = $this->request['get']['page'];
        }
        //引数ページの選手の全データを変数へ格納
        $tournaments = $this->Main->findAll($page);
        //選手の数を数えた値を変数へ格納
        $tournament_count = $this->Main->countAll();
         
        $params = [
            'pages' => $tournament_count / 9,
            'tournaments' => $tournaments
        ];
        return $params;  
    } 
    //詳細情報取得
    public function detail(){
        $params =[];
        if(!empty($this->request['get']['tournament_id'])){
            //idによる情報取得
            $detail = $this->Main->findById($this->request['get']['tournament_id']);

        }elseif(!empty($this->request['get']['id'])){
            //idによる情報取得
            $detail = $this->Main->findById($this->request['get']['id']);

        } else{
            $detail = $this->Main->findById($this->request['post']['tournament_id']);
        }
        $params = [
            'detail' =>$detail
        ];
        return $params;
    }

    //詳細情報取得
    public function detail_get($data){
        $params =[];
        if(!empty($this->Main->detail_get($data))){
            //idによる情報取得
            $detail = $this->Main->detail_get($data);

        } 
        $params = [
            'detail' =>$detail
        ];
        return $params;
    }

    

    //個人登録一覧
    public function singleRegister($id){
        $page = 0;
        $params = [];
        $Info = [];
        //Undefined index:対策
        if(isset($this->request['get']['page'])){
            $page = $this->request['get']['page'];
        }

        $Info = $this->Main->singleRegister($id,$page);

        $tournament_count = $this->Main->singleAll($id);

        $params = [
            'pages' => $tournament_count / 4,
            'Info' =>$Info
        ];
        return $params;
    }
    //個人詳細情報
    public function singleDetail($id){
        $params = [];
        $Info = [];
        $Info = $this->Main->singleDetail($id);
        $params = [
            'Info' =>$Info
        ];
        return $params;

    }
    //団体登録一覧
    public function groupRegister($id){
        $page = 0;
        $params = [];
        $Info = [];
        //Undefined index:対策
        if(isset($this->request['get']['page'])){
            $page = $this->request['get']['page'];
        }
        $Info = $this->Main->groupRegister($id,$page);
        $tournament_count = $this->Main->groupAll($id);
        $params = [
            'pages' => $tournament_count / 4,
            'Info' =>$Info
        ];
        return $params;
    }
    //団体詳細情報
    public function groupDetail($id){
        $params = [];
        $Info = [];
        $Info = $this->Main->groupDetail($id);
        $params = [
            'Info' =>$Info
        ];
        return $params;

    }

    public function tourDate($date){

        $page = 0;
        $params = [];
        $Info = [];
        //Undefined index:対策
        if(isset($this->request['get']['page'])){
            $page = $this->request['get']['page'];
        }
        
        $Info = $this->Main->tourDate($date,$page);

        $tournament_count = $this->Main->dateAll($date);

        $params = [
            'pages' => $tournament_count / 4,
            'Info' =>$Info
        ];
        return $params;
        
    }

    public function search($data){
        $page = 0;
        $params = [];
        $Info = [];
        //Undefined index:対策
        if(isset($this->request['get']['page'])){
            $page = $this->request['get']['page'];
        }
        $Info = $this->Main->search($data,$page);

        $tournament_count = $this->Main->searchAll($data);

        $params = [
            'pages' => $tournament_count / 4,
            'Info' =>$Info
        ];
        return $params;
    
    }
        
}




?>