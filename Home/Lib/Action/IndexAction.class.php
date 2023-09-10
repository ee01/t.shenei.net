<?php
/***********************************************************
    [EasyTalk] (C)2009 - 2011 nextsns.com
    This is NOT a freeware, use is subject to license terms

    @Filename IndexAction.class.php $

    @Author hjoeson $

    @Date 2011-01-09 08:45:20 $
*************************************************************/

class IndexAction extends Action {

    public function index() {
        //URL跳转
        $u=$_GET['u'];
        if ($u) {
            $url = D('Url')->where("`key`='$u'")->find();
            if ($url) {
                D('Url')->setInc("times","`key`='$u'");
                header("location: ".str_replace('&amp;','&',$url['url']));
                exit;
            }
        }
        $this->tohome();
        //hottalk
        $data = D('ContentView')->where("retid=0 AND replyid=0")->order("posttime DESC")->limit('20')->select();
        if ($data) {
            foreach($data as $val) {
                $welData.='<li><div class="indexgbli"><table border="0" width="100%"><tr><td width="60px" valign="top"><a href="'.SITE_URL.'/'.$val['user_name'].'"><img src="'.sethead($val['user_head']).'"></a></td><td valign="top"><a href="'.SITE_URL.'/'.$val['user_name'].'" class="'.setvip($val['user_auth']).'">'.$val['nickname'].'</a>&nbsp;&nbsp;'.D('Content')->ubb($val['content_body']).'<div class="sp">'.timeop($val['posttime']).'&nbsp;&nbsp;通过'.$val['type'].'</div></td></tr></table></div></li>';
            }
        }
        //hotuser
        $data= D('Users')->field('user_id,user_name,nickname,user_head')->where("followme_num>0")->order('followme_num DESC')->limit(12)->select();
        if ($data) {
            foreach($data as $val) {
                $userlist.='<li><a href="'.SITE_URL.'/'.$val['user_name'].'"><img alt="'.$val['nickname'].'" src="'.sethead($val['user_head']).'"/><span>'.$val['nickname'].'</span></a></li>';
            }
        }
        //hottopic
        $data=D('Topic')->where('tuijian=1')->order('topictimes DESC')->limit(20)->select();
        if ($data) {
            foreach ($data as $val) {
                $topiclist.='<li><a href="'.SITE_URL.'/k/'.$val['topicname'].'">'.$val['topicname'].'</a></li>';
            }
        }
        $this->assign('topiclist',$topiclist);
        $this->assign('userlist',$userlist);
        $this->assign('welData',$welData);
        $this->display();
    }

    public function vip() {
        $this->assign('subname','用户认证');
        $this->display();
    }

    public function about() {
        $this->assign('subname','关于我们');
        $this->display();
    }

    public function faq() {
        $this->assign('subname','新手帮助');
        $this->display();
    }

    public function login() {
        $this->tohome();
        $this->assign('subname','登陆微博');
        $this->display();
    }

    public function register() {
        $this->tohome();
        //整合ucenter，激活功能 start
        if (ET_UC==TRUE) {
            $uModel=D('Users');
            $auth=$_REQUEST['auth'];
            $activation=$_POST['activation'];
            $password=$_POST['password'];
            if ($activation && ($activeuser = uc_get_user($activation))) {
                list($uid, $username) = $activeuser;
                list($uid, $username, $password, $email) = uc_user_login($username, $password);
                if($username && $uid>0) {
                    $sitedenie=explode('|',$this->site['regname']);
                    $deniedname=array_merge(C('DIFNAME'),$sitedenie);
                    if (in_array($username,$deniedname)) {
                        Cookie::set('setok','activation4');
                        header('location:'.SITE_URL.'/login');
                    }
                    $insert['user_name']=$username;
                    $insert['nickname']=$username;
                    $insert['user_head']=$uid;
                    $insert['password']=md5(md5($password));
                    $insert['mailadres']=$email;
                    $insert['signupdate']=time();
                    $regid = $uModel->add($insert);
                    if($regid) {
                        Cookie::set('authcookie', authcode("$username\t$regid",'ENCODE'), 31536000);
                        Cookie::set('setok','activation2');
                        header('location:'.ET_URL);
                    } else {
                        Cookie::set('setok','activation3');
                        header('location:'.SITE_URL.'/login');
                    }
                } else {
                    Cookie::set('setok','activation1');
                    header('location:'.SITE_URL.'/register?auth='.$auth);
                    exit;
                }
            }
            list($activeuser) = explode("\t", authcode($auth,'DECODE'));
            if ($auth && $activeuser) {
                $this->assign('activeuser',$activeuser);
                $this->assign('auth',$auth);
                $this->assign('subname','注册微博');
                $this->display('activation');
                exit;
            }
        }
        // end
        if ($this->site['closereg']==1) {
            $this->assign('type','closereg');
            $this->display('Error/index');
            exit;
        } else {
            $uModel=D('Users');
            $user=$uModel->getUser("user_name='$_GET[user_name]'");

            $this->assign('user',$user);
            $this->assign('subname','注册微博');
            $this->display();
        }
    }

    public function reset() {
        $this->tohome();
        $this->assign('subname','找回密码');
        $this->display();
    }

    public function dologin() {
        $this->tohome();
        $username = daddslashes($_POST["loginname"]);
        $userpass = md5(md5($_POST["password"]));
        $remember = $_POST["rememberMe"];

        //整合UCENTER
        if (ET_UC==TRUE) {
            list($uid, $username, $password, $email) = uc_user_login($_POST['loginname'], $_POST['password']);
            if($username && $uid>0) {
                $user = D("Users")->where("user_name='$username'")->field('user_id,user_name,password')->find();
                if(!$user) {
                    $sitedenie=explode('|',$this->site['regname']);
                    $deniedname=array_merge(C('DIFNAME'),$sitedenie);
                    if (in_array($username,$deniedname)) {
                        Cookie::set('setok','activation4');
                        header('location:'.SITE_URL.'/login');
                    }
                    $auth = rawurlencode(authcode("$username\t".time(), 'ENCODE'));
			        echo '<script>alert("您需要激活该帐号，才能进入微博!");window.location.href="'.SITE_URL.'/register?auth='.$auth.'"</script>';
                    exit;
                } else {
                    if (md5(md5($password))!=$user['password']) {//密码错误
                        Cookie::set('setok','login2');
                        header('location:'.SITE_URL.'/login');
                    }
                    if ($remember=="on") {
                        Cookie::set('authcookie', authcode("$user[user_name]\t$user[user_id]",'ENCODE'), 31536000);
                    } else {
                        Cookie::set('authcookie', authcode("$user[user_name]\t$user[user_id]",'ENCODE'));
                    }
                    $ucsynlogin = uc_user_synlogin($uid);
                    if ($this->site['loginindex']=='home') {
                        echo uc_html('<script type="text/javascript">setInterval(function(){window.location.href="'.SITE_URL.'/'.$user['user_name'].'";}, 1000);</script><p>登陆成功了，页面正在跳转中....</p><p><a href="'.SITE_URL.'/'.$user['user_name'].'">如果页面无法跳转，请点击这里</a>'.$ucsynlogin.'</p>');
                        exit;
                    } else {
                        echo uc_html('<script type="text/javascript">setInterval(function(){window.location.href="'.SITE_URL.'/pub";}, 1000);</script><p>登陆成功了，页面正在跳转中....</p><p><a href="'.SITE_URL.'/pub">如果页面无法跳转，请点击这里</a>'.$ucsynlogin.'</p>');
                        exit;
                    }
                }
            } else {
                Cookie::set('setok','login2');
                header('location:'.SITE_URL.'/login');
            }
        //end
        } else {
            $user = D("Users")->where("(user_name='$username' OR mailadres='$username') AND password='$userpass'")->field('user_id,user_name,userlock')->find();
            if($user) {
                if ($user["userlock"]==1) {
                    Cookie::set('setok','login1');
                    header('location:'.SITE_URL.'/login');
                } else {
                    if ($remember=="on") {
                        Cookie::set('authcookie', authcode("$user[user_name]\t$user[user_id]",'ENCODE'), 31536000);
                    } else {
                        Cookie::set('authcookie', authcode("$user[user_name]\t$user[user_id]",'ENCODE'));
                    }
                    //默认跳转地址
                    if ($this->site['loginindex']=='home') {
                        header('location:'.SITE_URL.'/'.$user['user_name']);
                    } else {
                        header('location:'.SITE_URL.'/Pub');
                    }
                }
            } else {
                Cookie::set('setok','login2');
                header('location:'.SITE_URL.'/login');
            }
        }
    }

    public function doreset() {
        $this->tohome();
        $uModel=D('Users');

        $mailadres = daddslashes(trim($_POST["mailadres"]));
        $user=$uModel->getUser("mailadres='$mailadres'");
        if ($mailadres && $user['user_id']) {
            $seedstr =split(" ",microtime(),5);
            $seed =$seedstr[0]*10000;
            srand($seed);
            $pass =rand(10000,100000);
            $md5_pass=md5(md5($pass));

            $title="“".$this->site['sitename']."”找回密码";
            $url=SITE_URL."/checkreset/".base64_encode("user_name=$user[user_name]&mailadres=$user[mailadres]&user_id=$user[user_id]&dateline=".time());
            $send='<p>尊敬的用户：</p>
            <p style="text-indent:2em">您刚才通过“找回密码”服务申请了重置密码，请点击如下地址重新设置密码，该地址有效期为5小时。如不是您本人申请，请忽略本邮件。</p>
            <p style="text-indent:2em">点击地址：<a href="'.$url.'" target="_blank">'.$url.'</a></p>
            <p style="float:right">当前时间：'.date("Y-m-d H:i:s").'<br/>'.$this->site['sitename'].'</p>';

            A('Api')->senMail($title,$send,$mailadres);

            Cookie::set('setok','reset2');
            header('location:'.SITE_URL.'/reset');
        } else {
            Cookie::set('setok','reset1');
            header('location:'.SITE_URL.'/reset');
        }
    }

    public function checkreset() {
        $this->tohome();
        $uModel=D('Users');
        $urldata=$_REQUEST['urldata'];
        parse_str(base64_decode($urldata));

        if (time()-$dateline>3600*5) {
            Cookie::set('setok','reset3');//该地址已经过期，请重新“找回密码”
            header('location:'.SITE_URL.'/reset');
            exit;
        } else {
            $user=$uModel->getUser("user_id='$user_id' AND user_name='$user_name' AND mailadres='$mailadres'");
            if (!$user['user_id']) {
                Cookie::set('setok','reset4');//地址验证失败，请重新“找回密码”
                header('location:'.SITE_URL.'/reset');
                exit;
            }
        }

        $this->assign('subname','找回密码');
        $this->assign('user',$user);
        $this->assign('urldata',$urldata);
        $this->assign('type','find');
        $this->display('reset');
    }

    public function setpass() {
        $this->tohome();
        $uModel=D('Users');
        $urldata=$_REQUEST['urldata'];
        parse_str(base64_decode($urldata));
        $pass1 = md5(md5(trim($_POST["pass1"])));
        $pass2 = md5(md5(trim($_POST["pass2"])));

        if (time()-$dateline>3600*5) {
            Cookie::set('setok','reset3');//该地址已经过期，请重新“找回密码”
            header('location:'.SITE_URL.'/reset');
        } else {
            $user=$uModel->getUser("user_id='$user_id' AND user_name='$user_name' AND mailadres='$mailadres'");
            if ($user['user_id']) {
                if ($pass1 && $pass1==$pass2) {
                    $uModel->where("user_id='$user[user_id]'")->setField('password',$pass1);
                    if (ET_UC==TRUE) {
                        uc_user_edit($user['user_name'],'',$_POST["pass1"],'',1);
                    }
                    Cookie::set('setok','reset5');
                    header('location:'.SITE_URL.'/login');
                } else {
                    Cookie::set('setok','account1');
                    header('location:'.SITE_URL.'/checkreset/'.$urldata);
                }
            } else {
                Cookie::set('setok','reset4');
                header('location:'.SITE_URL.'/reset');
            }
        }
    }

    public function regcheck() {
        $this->tohome();
        $uModel=D('Users');

        $sitedenie=explode('|',$this->site['regname']);
        $deniedname=array_merge(C('DIFNAME'),$sitedenie);

        $invitecode=trim($_POST['invitecode']);
        $inviteuid=trim($_POST['inviteuid']);
        $username=daddslashes(trim(strtolower($_POST['uname'])));
        $mailadres=daddslashes(trim($_POST['mail']));
        $pass1=daddslashes(trim($_POST['pass1']));
        $pass2=daddslashes(trim($_POST['pass2']));

        if ($this->site['closereg']==3) {
            $invitemsg=$this->invitecodeauth($invitecode);
            if ($invitemsg!='ok') {
                echo $invitemsg;
                exit;
            }
        }
        if (!preg_match("/^[\x{4e00}-\x{9fa5}a-zA-Z0-9]+$/u",$username)) {
            echo "用户账户不能包含除中文、英文、数字和下划线以外的字符";
            exit;
        }
        if (StrLenW2($username)>12 || StrLenW2($username)<3 || !$username) {
            echo "帐户名长度最多 6 个汉字或 12 个字符";
            exit;
        }
        if (in_array($username,$deniedname)) {
            echo '账户名不能使用';
            exit;
        }
        $user=$uModel->getUser("user_name='$username' OR nickname='$username' OR mailadres='$mailadres'");
        if ($user && ($user['user_name']==$username || $user['nickname']==$username)) {
            echo "账户名已存在，不能使用";
            exit;
        }
        if ($user && $user['mailadres']==$mailadres) {
            echo "此电子邮件已存在，不能使用";
            exit;
        }
        if(!$mailadres) {
            echo "请填写电子邮件地址";
            exit;
        }
        if(!strpos($mailadres,"@")) {
            echo "电子邮件格式不正确";
            exit;
        }
        if (StrLenW($pass1)<6 || StrLenW($pass1)>20) {
            echo "密码长度应该大于6个字符小于20个字符";
            exit;
        }
        if ($pass1!=$pass2) {
            echo "两次输入的密码不一致";
            exit;
        }
        if ($username && $mailadres && $pass1==$pass2) {
            //ucenter注册
            if (ET_UC==TRUE) {
                if(uc_get_user($username)) {
                    echo '该用户无需注册，请直接登陆激活';
                    exit;
                }
                $uid = uc_user_register($username, $pass2, $mailadres);
                if($uid <= 0) {
                    if($uid == -1) {
                        echo 'UC提示:用户名不合法';
                        exit;
                    } elseif($uid == -2) {
                        echo 'UC提示:包含不允许注册的词语';
                        exit;
                    } elseif($uid == -3) {
                        echo 'UC提示:用户名已经存在';
                        exit;
                    } elseif($uid == -4) {
                        echo 'UC提示:Email格式有误';
                        exit;
                    } elseif($uid == -5) {
                        echo 'UC提示:Email不允许注册';
                        exit;
                    } elseif($uid == -6) {
                        echo 'UC提示:该Email已经被注册';
                        exit;
                    } else {
                        echo 'UC提示:未定义错误';
                        exit;
                    }
                }
            }
            if ($uid>0) {
                $insert['user_head']=$uid;
            }
            //end
            $insert['user_name']=$username;
            $insert['nickname']=$username;
            $insert['password']=md5(md5($pass2));
            $insert['mailadres']=$mailadres;
            $insert['signupdate']=time();
            $regid = $uModel->add($insert);
            if($regid) {
                if ($uModel->getUser("user_id='$inviteuid'")) {
                    $uModel->where("user_id='$inviteuid'")->setField(array('followme_num','follow_num','newfollownum'),array(array('exp','followme_num+1'),array('exp','follow_num+1'),array('exp','newfollownum+1')));

                    $uModel->where("user_id='$regid'")->setField(array('followme_num','follow_num'),array(array('exp','followme_num+1'),array('exp','follow_num+1')));

                    $fModel=D('friend');
                    $data1['fid_jieshou']=$regid;
                    $data1['fid_fasong']=$inviteuid;
                    $data2['fid_jieshou']=$inviteuid;
                    $data2['fid_fasong']=$regid;
                    $fModel->add($data1);
                    $fModel->add($data2);
                }
                //发送欢迎私信
                if ($this->site['openwelpri']==1) {
                    D('Messages')->sendmsg($this->site['welcomemsg'],$username,0);
                }
                //网站统计
                $this->addtongji('register');
                Cookie::set('authcookie', authcode("$username\t$regid",'ENCODE'), 31536000);
                if ($this->site['closereg']==3) {
                    D('invitecode')->where("invitecode='$invitecode'")->setField(array('isused','user_name'),array('1',$username));
                }
                echo "check_ok";
            } else {
                echo "很抱歉，注册失败";
            }
        } else {
            echo "很抱歉，注册失败";
        }
    }

    public function logout() {
        setcookie('authcookie','',-1,'/');
        Cookie::delete('authcookie');
        if (ET_UC==TRUE) {
            $ucsynlogout = uc_user_synlogout();
            echo uc_html('<script type="text/javascript">setInterval(function(){window.location.href="'.ET_URL.'";}, 1000);</script><p>您已经成功退出，页面正在跳转中....</p><p><a href="'.SITE_URL.'">如果页面无法跳转，请点击这里</a>'.$ucsynlogout.'</p>');
        } else {
            header("location:".ET_URL);
        }
    }

    private function tohome() {
        //默认跳转地址
        if ($this->site['loginindex']=='home') {
            $rurl=$this->my['user_name'];
        } else {
            $rurl='Pub';
        }
        if ($this->my) {
            if (!arraynull($_REQUEST)) {
                header('location: '.SITE_URL.'/'.$rurl);
            } else {
                echo '<script type="text/javascript">window.location.href="'.SITE_URL.'/'.$rurl.'"</script>';
            }
        }
    }

    public function invitecodeauth($code) {
        $ivcode=D('invitecode');
        $data = $ivcode->where("invitecode='$code'")->find();
        if ($data['id'] && $data['timeline']>=time() && $data['isused']==0) {
            $msg="ok";
        } else if($data['id'] && $data['timeline']>=time() && $data['isused']==1) {
            $msg="邀请码已被使用！";
        } else {
            $msg="邀请码无效或者已经过期！";
        }
        return $msg;
    }
}
?>