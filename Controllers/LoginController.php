<?php
require_once(ROOT_PATH.'/Models/Login.php');

class LoginController {
    private $Login;

    public function __construct() {
        //リクエストパラメータの取得
        $this->request['get'] = $_GET;
        $this->request['post'] = $_POST;
        //モデルのplayerオブジェクト生成
        $this->Login = new Login();
    }    

    //登録ページのバリデーション
    public function register_validate($register_data){
        //エラーメッセージ用変数
        $err = [];
        if($register_data['name'] === ''){
            $err['name'] = 'ユーザ名は必須入力です';

        }
        if(!$register_data['email'] = filter_input(INPUT_POST,'email')){
            $err['email'] = 'メールアドレスを入力してください';
        }

        $register_data['password'] = filter_input(INPUT_POST,'password');
        if(!preg_match("/\A[a-z\d]{1,8}+\z/i",$register_data['password'])){
            $err['password'] = 'パスワードは8文字以下にしてください';
        }

        return $err;
    }
    //ログインページのバリデーション
    public function login_validate($login_data){
        //エラーメッセージ用変数
        $err = [];
        if(!$login_data['email'] = filter_input(INPUT_POST,'email')){
            $err['email'] = 'メールアドレスを入力してください';
        }

        
        if(!$login_data['password'] = filter_input(INPUT_POST,'password')){
            $err['password'] = 'パスワードを入力してください';

        }
        return $err;        
    }

    public function Reset_validate($register_data){
        //エラーメッセージ用変数
        $err = [];
        if(!$register_data['email'] = filter_input(INPUT_POST,'email')){
            $err['email'] = 'メールアドレスを入力してください';
        }

        $register_data['password'] = filter_input(INPUT_POST,'password');
        if(!preg_match("/\A[a-z\d]{1,8}+\z/i",$register_data['password'])){
            $err['password'] = 'パスワードは英数字8文字以下にしてください';
        }

        $register_data['password_conf'] = filter_input(INPUT_POST,'password_conf');
        if($register_data['password'] !==  $register_data['password_conf']){
            $err['password_conf'] = '確認用パスワードと異なります';
        }

        return $err;
    }

    //メールアドレス、パスワードの照合メソッド
    public function login($data){
        $result = false;
        //emailからデータを抽出するメソッドの呼び出し 
        $users = $this->Login->getUserByEmail($data['email']);
        //メールアドレスが異なるエラー処理
        if(!$users){
            $_SESSION['msg'] = 'メールアドレスが異なります';
            return $result;
        }
        //パスワードが異なるエラー処理
        if(password_verify($data['password'],$users['password'])){
            session_regenerate_id(true);
            $_SESSION['login_user'] = $users;
            $params = [
                'users' => $users
            ];
            return $params; 
        }else{
            $_SESSION['pass_msg'] = 'パスワードが異なります';
            return $result;
        }
    }
    //パスワードをハッシュ化してDBに登録するメソッド
    public function userRegister($userData){
        $this->Login->userRegister($userData);
    }

    public function passReset($data){
        $this->Login->passReset($data);
    }

    //XSS対策：エスケープ処理
    public function h($s){
        return htmlspecialchars($s,ENT_QUOTES,'UTF-8');
    }

}




?>