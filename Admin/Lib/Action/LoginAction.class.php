<?php
/***********************************************************
    [EasyTalk] (C)2009 - 2011 nextsns.com
    This is NOT a freeware, use is subject to license terms

    @Filename LoginAction.class.php $

    @Author hjoeson $

    @Date 2011-01-09 08:45:20 $
*************************************************************/

class LoginAction extends Action{

    public function index() {
        $this->toadmin();
        $this->display();
    }

    public function dologin() {
        $this->toadmin();
        $user_name=$this->loginname;
        $password=md5(md5($_POST['password']));

        if (!$user_name || !$password) {
            $this->redirect('/Login/index');
        } else {
            $user = D("Users")->where("user_name='$user_name' AND password='$password' AND isadmin=1")->find();
            if($user) {
                Cookie::set('adminauth', authcode("$user_name\t$user[user_id]",'ENCODE'));
                echo '<script>parent.location.href="'.SITE_URL.'/admin.php?s=/Index"</script>';
            } else {
                $this->redirect('/Login/index');
            }
        }
    }

    public function logout() {
        setcookie('adminauth','',-1,'/');
        Cookie::delete('adminauth');
        $this->redirect('/Login/index');
    }

    private function toadmin() {
        if ($this->admin['user_id'] && $this->admin['isadmin']==1) {
            echo '<script>parent.location.href="'.SITE_URL.'/admin.php?s=/Index"</script>';
        }
    }
}
?>