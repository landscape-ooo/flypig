<?php
        /*
         * API单入口
         */
         

        $username = $_POST['username'];
        $password = md5($_POST['password']);

       
        $sql = "select * from ".dbprefix."app_muser where username='$username' and password='$password' limit 1";
       
        $userNum = $DB->once_num_rows($sql);
        $strUser = $DB->once_fetch_assoc($sql);
       
        if(empty($username) || empty($password)){
       
                echo '1';
               
        }elseif(empty($userNum)){
       
                echo '2';
               
        }else{
       
                $arrUserData = array(
               
                        'uid'                   => $strUser['id'],
                        'uname'         => $strUser['username'],
                        'tname'         => $strUser['truename'],
                        'email'         => $strUser['email'],
                        'face'                  => $strUser['face'],
                        'blog'          => $strUser['blog'],
                        'signed'                => $strUser['signed'],
                        'city'                  => $strUser['city'],
                        'ip'                    => $strUser['ip'],
                        'updatetime'    => $strUser['updatetime'],
               
                );
       
               
                echo json_encode($arrUserData);
               
        }
