<?php
/*
* 注册
* By QINIAO
*/

//SEO设置
$title = '注册';

//程序主体
switch($ts){
        case "":
       
                if($TS_USER['user'] != 'XXOO') header("Location: /index.php");
               
                $tpl->assign('title',$title);
                $tpl->display('register.html');
                break;
       
        case "do":      

                $arrData = array(
                        'username'      => $_POST['username'],
                        'password'              => $_POST['password'],
                        'repassword'    => $_POST['repassword'],
                        'truename'              => $_POST['truename'],
                        'email'                 => $_POST['email'],
                );
               
                if($_SERVER['SERVER_NAME'] == 'dev.thinksaas.cn'){
                        $aipUrl = 'http://dev.thinksaas.cn/index.php?app=muser&ac=api&api=register';
                }else{
                        $aipUrl = 'http://www.thinksaas.cn/index.php?app=muser&ac=api&api=register';
                }
               
                $userData = $tsApi->post($arrData,$aipUrl);
               
                if($userData == '1'){
                        qiMsg("所有必选项都不能为空！","点击返回","/index.php?app=muser&ac=register");
                }elseif($userData == '2'){
                        qiMsg("用户名只允许数字和英文，且长度在4~16个字符之间！","点击返回","/index.php?app=muser&ac=register");
                }elseif($userData == '3'){
                        qiMsg("该用户名已被注册，请换一个重试！","点击返回","/index.php?app=muser&ac=register");
                }elseif($userData == '4'){
                        qiMsg("两次输入密码不正确！","点击返回","/index.php?app=muser&ac=register");
                }elseif($userData == '5'){
                        qiMsg("姓名长度必须在4和20之间","点击返回","/index.php?app=muser&ac=register");
                }elseif($userData == '6'){
                        qiMsg("Email邮箱输入有误","点击返回","/index.php?app=muser&ac=register");
                }else{
               
                        $_SESSION['tsuser'] = array(
                       
                                'uid'                   => $userData->uid,
                                'uname'         => $userData->uname,
                                'tname'         => $userData->tname,
                                'email'         => $userData->email,
                                'face'                  => $userData->face,
                                'blog'          => $userData->blog,
                                'signed'                => $userData->signed,
                                'city'                  => $userData->city,
                                'ip'                    => $userData->ip,
                                'updatetime'    => $userData->updatetime,
                       
                        );
               
                        $_SESSION['uid']                                = $userData->uid;
                        $_SESSION['username']   = $userData->uname;
                        $_SESSION['truename']           = $userData->tname;
                        $_SESSION['email']                      = $userData->email;

                        header('Location: /index.php');
               
                }
               
                break;
}
