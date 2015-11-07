<?php
/*
* 登录
* By QINIAO
*/

//SEO配置
$title = '登录';


//程序主体
switch($ts){
        case "":
               
                if($TS_USER['user'] != 'XXOO') header("Location: /index.php");
               
                $url = isset($_GET['url']) ? $_GET['url'] : 'index.php';
       
                $tpl->assign('title',$title);
                $tpl->assign('url',$url);
               
               
                $tpl->display('login.html');
                exit;
                break;
       
        //执行登录
        case "do":
                $username       = t($_POST['username']);
                $password               = t($_POST['password']);
               
                $url    = $_POST['url'];
               
                $arrData = array(
                        'username'      => $username,
                        'password'              => $password,
                );
               
               
                if($_SERVER['SERVER_NAME'] == 'dev.thinksaas.cn'){
                        $aipUrl = 'http://dev.thinksaas.cn/index.php?app=muser&ac=api&api=login';
                }else{
                        $aipUrl = 'http://www.thinksaas.cn/index.php?app=muser&ac=api&api=login';
                }
               
               
                $userData = $tsApi->post($arrData,$aipUrl);
               
                if($userData == '1'){
                        qiMsg('所有登录项都不能为空^_^','点击返回','/index.php?app=muser&ac=login');
                }elseif($userData == '2'){
                        qiMsg('用户名或者密码输入错误^_^','点击返回','/index.php?app=muser&ac=login');
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
                       
                //借用一下QQ的IP地址库
                function get_ip_place(){
                        $ip=file_get_contents("http://fw.qq.com/ipaddress");
                        $ip=str_replace('"',' ',$ip);
                        $ip2=explode("(",$ip);
                        $a=substr($ip2[1],0,-2);
                        $b=explode(",",$a);
                        return $b;
                }
               
                $ipcity=get_ip_place();
                       
                //更新最后登陆IP和登陆时间
                //$ip = getIp();
                $ip = t($ipcity[0]);
               
                //$city = iconv('utf-8', 'gb2312', $ipcity[2]);
               
                $city = mb_convert_encoding($ipcity[2],'utf8','gb2312');
               
                $city = t($city);
               
                $updatetime = time();
                $uid = $_SESSION['tsuser']['uid'];
               
                $DB->query("update ".dbprefix."app_muser set city='$city',ip='$ip',updatetime='$updatetime' where id='$uid'");
                       
                        /*
                         *添加Feed动态API
                         */
                       
                        $feedArrData = array(
                                'uid'           => $userData->uid,
                                'uname' => $userData->uname,
                                'tname' => $userData->tname,
                                'app_id'        => '2010091901',
                                'app_name'      => 'muser',
                                'app_icon'      => "/app/muser/icon.png",
                                'template'      => '{owner}{content}',
                                'data'  => array(
                                        'owner' => "<a href='/index.php?app=muser&ac=user&id=".$userData->uid."'>".$userData->tname."</a>",
                                        'content'       => '驾到本社区！',
                                )
                        );
                       
                        if($_SERVER['SERVER_NAME'] == 'dev.thinksaas.cn'){
                                $feedApiUrl = 'http://dev.thinksaas.cn/index.php?app=mfeed&ac=api&api=addfeed';
                        }else{
                                $feedApiUrl = 'http://www.thinksaas.cn/index.php?app=mfeed&ac=api&api=addfeed';
                        }
                        $feedApiData = $tsApi->post($feedArrData,$feedApiUrl);
                       
                        header('Location: /'.$url.'');
               
                }
               
                break;
       
        //退出    
        case "out":
                session_destroy();
                header('Location: /index.php');
                break;
               
}

