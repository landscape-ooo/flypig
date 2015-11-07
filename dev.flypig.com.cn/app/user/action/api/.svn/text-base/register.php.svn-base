<?php
        /*
         * API单入口
         */
         

        $uname  =       trim($_POST['uname']);
        $password               =       trim($_POST['password']);
        $repassword     =       trim($_POST['repassword']);
        $tname  = trim($_POST['tname']);
        $email                  = t($_POST['email']);

       
        $res = $DB->once_num_rows("SELECT * FROM ".dbprefix."app_muser WHERE uname='$uname'");
       
        if(empty($uname) || empty($password) || empty($repassword) || empty($tname) || empty($email)){
                echo '1';//所有必选项都不能为空！
        }elseif(!preg_match('/^[a-zA-Z0-9]{4,16}$/', $uname)){
                echo '2';//用户名只允许数字和英文，且长度在4~16个字符之间！
        }elseif($res > 0){
                echo '3';//该用户名已被注册，请换一个重试！
        }elseif($password != $repassword){
                echo '4';//两次输入密码不正确！
        }elseif(strlen($tname) < 4 || strlen($tname) > 20){
                echo '5';//姓名长度必须在4和20之间
        }elseif(valid_email($email) == false){
                echo '6';//Email邮箱输入有误!
        }else{
       
                $arrData = array(
                        'uname' => $uname,
                        'password' => md5($password),
                        'tname' => $tname,
                        'email'         => $email,
                        'addtime'               => time(),
                        'updatetime'    => time(),
                );
               
                //插入用户
                $uid = $DB->insertArr($arrData,'app_muser');
               
                $userData = $DB->once_fetch_assoc("select ");
               
                echo json_encode($userData);
        }
?>
