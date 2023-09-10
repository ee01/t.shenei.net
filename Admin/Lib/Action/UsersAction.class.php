<?php
/***********************************************************
    [EasyTalk] (C)2009 - 2011 nextsns.com
    This is NOT a freeware, use is subject to license terms

    @Filename UsersAction.class.php $

    @Author hjoeson $

    @Date 2011-01-09 08:45:20 $
*************************************************************/

class UsersAction extends Action {

    public function _initialize() {
        if (!$this->admin['user_id'] || $this->admin['isadmin']!=1) {
            $this->redirect('/Login/index');
        }
    }

    public function index() {
        $user_name=$_REQUEST['user_name'];
        if ($user_name) {
            $user=D('Users')->where("user_name='$user_name'")->find();
            if (!$user) {
                $this->assign('url',SITE_URL.'/admin.php?s=/Users');
                $this->assign('title','很抱歉，没有找到您要编辑的用户');
                $this->assign('position','系统跳转');
                $this->display('Common/return');
                exit;
            }
            //广场用户榜
            $pubtop=D('Pubtop')->where("user_id='$user[user_id]'")->find();
            $user['pubtop']=$pubtop?1:0;
        }
        $this->assign('position','用户管理 -> 用户编辑');
        $this->assign('user',$user);
        $this->display();
    }

    public function admin() {
        $user=D('Users')->where("isadmin>0")->select();
        $this->assign('position','用户管理 -> 管理员管理');
        $this->assign('user',$user);
        $this->display();
    }

    public function adminedit() {
        $user_name=$_POST['user_name'];
        $isadmin=$_POST['isadmin'];

        D('Users')->where("user_id!=1 AND user_name='$user_name'")->setField('isadmin',$isadmin);

        $this->assign('url',SITE_URL.'/admin.php?s=/Users/admin');
        $this->assign('title','管理员编辑成功');
        $this->assign('position','系统跳转');
        $this->display('Common/return');
    }

    public function edituser() {
        $pubtopm=D('Pubtop');
        $user_name=$_POST['user_name'];
        $userdata=$_POST['user'];
        $pubtop=$_POST['pubtop'];
        $delmsg=$_POST['delmsg'];

        $uModel=D('Users');
        if ($user_name) {
            $user=$uModel->where("user_name='$user_name'")->find();
            if ($user) {
                if ($userdata['nickname']!=$user['nickname']) {
                    $newdt=$uModel->where("nickname='$userdata[nickname]'")->find();
                    if ($newdt) {
                        $this->assign('url',SITE_URL.'/admin.php?s=/Users/index/user_name/'.$user_name);
                        $this->assign('title','很抱歉，您修改的新昵称，已经存在！');
                        $this->assign('position','系统跳转');
                        $this->display('Common/return');
                        exit;
                    }
                }
                $keys=$vals=array();
                foreach($userdata as $key=>$val) {
                    if ($key=='password')  {
                        if ($val) {
                            $keys[]='password';
                            $vals[]=md5(md5(trim($val)));
                        }
                    } else {
                        $keys[]=$key;
                        $vals[]=$val;
                    }
                }
                //广播数清零
                if ($delmsg==1) {
                    $keys[]='msg_num';
                    $vals[]=0;
                }
                $uModel->where("user_name='$user_name'")->setField($keys,$vals);
                //写入广场用户榜
                if ($pubtop==0) {
                    $pubtopm->where("user_id='$user[user_id]'")->delete();
                } else {
                    $pubtop=$pubtopm->where("user_id='$user[user_id]'")->find();
                    if (!$pubtop) {
                        $insertdata['user_id']=$user['user_id'];
                        $pubtopm->add($insertdata);
                    }
                }
                //删除用户数据
                if ($delmsg==1) {
                    $ct=D('Content');
                    $ctp=D('Content_topic');
                    $data=$ct->where("user_id='$user[user_id]'")->select();
                    if (is_array($data)) {
                        foreach ($data as $val1) {
                            //删除话题
                            $data2=$ctp->where("content_id='$val1[content_id]'")->select();
                            if (is_array($data2)) {
                                foreach ($data2 as $val) {
                                    D('Topic')->where("id='$val[topic_id]'")->setDec('topictimes');
                                }
                            }
                            $ctp->where("content_id='$val1[content_id]'")->delete();
                            $ct->where("content_id='$val1[content_id]'")->delete();
                            D('Content_mention')->where("cid='$val1[content_id]'")->delete();
                        }
                    }
                }
                $this->assign('url',SITE_URL.'/admin.php?s=/Users/index/user_name/'.$user_name);
                $this->assign('title','用户信息编辑成功');
                $this->assign('position','系统跳转');
                $this->display('Common/return');
            } else {
                $this->assign('url',SITE_URL.'/admin.php?s=/Users');
                $this->assign('title','很抱歉，没有找到您要编辑的用户');
                $this->assign('position','系统跳转');
                $this->display('Common/return');
            }
        }
    }
}
?>