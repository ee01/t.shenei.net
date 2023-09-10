<?php
/***********************************************************
    [EasyTalk] (C)2009 - 2011 nextsns.com
    This is NOT a freeware, use is subject to license terms

    @Filename WapAction.class.php $

    @Author hjoeson $

    @Date 2011-01-09 08:45:20 $
*************************************************************/

class WapAction extends Action {

    function _initialize() {
        if ($this->site['wapopen']==0) {
            $this->showmessage("<div class='showmag'><p>很抱歉，手机WAP功能未开启！</p></div>");
            exit;
        }
        $uModel=M('Users');
        $authcookie = Cookie::get('wapcookie');
        $exp=authcode($authcookie,'DECODE');
        list($user_name,$user_id) = explode("\t", authcode($authcookie,'DECODE'));
        if ($user_name && $user_id) {
            $this->my = $uModel->where("user_id='$user_id' AND user_name='$user_name'")->find();
        } else {
            $this->my='';
        }
        D('Content')->setmy($this->my);
        $this->assign('ctent',D('Content'));
    }
    function index() {
        $this->tohome();
        $this->display();
    }
    function space() {
        $this->tologin();
        $user_name=$_GET['user_name'];
        $user_name=$user_name?$user_name:$this->my['user_name'];
        if ($user_name!=$this->my['user_name']) {
            $user=D('Users')->where("user_name='$user_name'")->find();
        } else {
            $user=$this->my;
        }
        if (!$user) {
            $this->tologin();
            $this->showmessage("<div class='showmag'><p>很抱歉，该用户不存在！</p><p><a href='".SITE_URL."/Wap'>返回主页</a></p></div>");
            exit;
        }
        import("@.ORG.Page");
        C('PAGE_NUMBERS',10);
        $cview=D('ContentView');
        $ctent=D('Content');
        $count = $ctent->where("user_id='".$user['user_id']."' AND replyid=0")->count();
        $p= new Page($count,10);
        $page = $p->show('Wap/space/user_name/'.$user['user_name'].'/p/');
        $content = $cview->where("Users.user_id='".$user['user_id']."' AND replyid=0")->order("posttime DESC")->limit($p->firstRow.','.$p->listRows)->select();
        $content=$ctent->loadretwitt($content,1);

        $this->assign('page',$page);
        $this->assign('content',$content);
        $this->assign('isfriend',D('Friend')->followstatus($user['user_id'],$this->my['user_id']));
        $this->assign('user',$user);
        $this->assign('subname',$user['nickname']);
        $this->assign('showmenu',1);
        $this->display();
    }
    function home() {
        $this->tologin();

        import("@.ORG.Page");
        C('PAGE_NUMBERS',10);
        $cfview=D('FollowContentView');
        $ctent=D('Content');
        //总页数
        $count = $cfview->where("fid_fasong='".$this->my['user_id']."' AND replyid=0")->count();
        $countmy = $ctent->where("user_id='".$this->my['user_id']."' AND replyid=0")->count();//我的消息数
        $count+=$countmy;
        $count=min($count,100);
        $p= new Page($count,10);
        $page = $p->show('Wap/home/p/');
        //内容
        $content = $cfview->where("(fid_fasong='".$this->my['user_id']."' OR Users.user_id='".$this->my['user_id']."') AND replyid=0")->group('content_id')->order("posttime DESC")->limit($p->firstRow.','.$p->listRows)->select();
        $content=$ctent->loadretwitt($content,1);

        $this->assign('page',$page);
        $this->assign('content',$content);
        $this->assign('subname',$user['nickname']);
        $this->assign('showmenu',1);
        $this->display();
    }
    function follow() {
        $fModel=D('Friend');
        $uModel=D('Users');
        import("@.ORG.Page");
        C('PAGE_NUMBERS',10);
        $tab=$_GET['tab']?$_GET['tab']:1;
        $title=$tab==1?'我收听的':'我的听众';

        if ($tab==1) {
            $p= new Page($this->my['follow_num'],20);
            $page = $p->show('Wap/follow/tab/'.$tab.'/p/');
            $data=$uModel->friends($this->my['user_id'],$p->firstRow,$p->listRows);
            if (is_array($data)) {
                $fids=$isfollower=array();
                foreach ($data as $val) {
                    $fids[]=$val['user_id'];
                }
                $fids[]=$this->my['user_id'];
                $count=count($fids);
                if ($count>0) {
                    $fids=implode(",",$fids);
                    $isfollower= $fModel->followstatus($fids,$this->my['user_id']);
                }
            }
        } else {
            $p= new Page($this->my['followme_num'],20);
            $page = $p->show('Wap/follow/tab/'.$tab.'/p/');
            $data=$uModel->follows($this->my['user_id'],$p->firstRow,$p->listRows);
            if (is_array($data)) {
                $fids=$isfollower=array();
                foreach ($data as $val) {
                    $fids[]=$val['user_id'];
                }
                $fids[]=$this->my['user_id'];
                $count=count($fids);
                if ($count>0) {
                    $fids=implode(",",$fids);
                    $isfollower= $fModel->followstatus($fids,$this->my['user_id']);
                }
            }
        }

        if ($this->my['newfollownum']>0) {
            $uModel->where("user_id='".$this->my['user_id']."'")->setField('newfollownum',0);
        }

        $this->assign('isfriend',$isfollower);
        $this->assign('isfollower',$isfollower);
        $this->assign('data',$data);
        $this->assign('page',$page);
        $this->assign('tab',$tab);
        $this->assign('subname',$title);
        $this->assign('showmenu',1);
        $this->display();
    }
    function topic() {
        $this->tologin();
        $k=$_GET['k'];
        if (!$k) {
            header("location:".SITE_URL.'/Wap');
        }
        import("@.ORG.Page");
        C('PAGE_NUMBERS',10);
        $ctview=D('ContenttopicView');
        $ctent=D('Content');

        $topic=D('Topic')->where("topicname='$k'")->find();
        $count=intval($topic['topictimes']);
        $count=min($count,200);
        $p= new Page($count,10);
        $page = $p->show('Wap/topic/k/'.$k.'/p/');
        $content = $ctview->where("topic_id='$topic[id]' AND replyid=0")->order("posttime DESC")->limit($p->firstRow.','.$p->listRows)->select();
        $content=$ctent->loadretwitt($content,1);

        $this->assign('page',$page);
        $this->assign('topic',$k);
        $this->assign('content',$content);
        $this->assign('subname','话题#'.$k.'#');
        $this->assign('showmenu',1);
        $this->display();
    }
    function message() {
        $mes=D('Messages');
        $ctent=D('Content');
        $uModel=D('Users');

        import("@.ORG.Page");
        C('PAGE_NUMBERS',10);
        $count = $mes->where("sendtouid='".$this->my['user_id']."'")->count();
        $p= new Page($count,20);
        $page = $p->show('Wap/message/p/');
        $data = D('MessagesView')->where("sendtouid='".$this->my['user_id']."'")->order("message_id DESC")->limit($p->firstRow.','.$p->listRows)->select();

        if ($this->my['priread']>0) {
            $uModel->where("user_id='".$this->my['user_id']."'")->setField('priread',0);
        }

        $this->assign('count',$count);
        $this->assign('data',$data);
        $this->assign('page',$page);
        $this->assign('subname','我的私信');
        $this->assign('showmenu',1);
        $this->display();
    }
    function at() {
        $this->tologin();

        import("@.ORG.Page");
        C('PAGE_NUMBERS',10);
        $ctent=D('Content');
        $caview=D('ContentatView');

        //总页数
        $count = $caview->where("Content_mention.user_id='".$this->my['user_id']."' AND replyid=0")->count();
        $p= new Page($count,20);
        $page = $p->show('Wap/at/p/');
        //内容
        $content = $caview->where("Content_mention.user_id='".$this->my['user_id']."' AND replyid=0")->order("attime DESC")->limit($p->firstRow.','.$p->listRows)->select();
        $content=$ctent->loadretwitt($content,1);

        if ($this->my['atnum']>0) {
            D('Users')->where("user_id='".$this->my['user_id']."'")->setField('atnum',0);
        }

        $this->assign('page',$page);
        $this->assign('content',$content);
        $this->assign('subname','提到我的 - '.$this->my['nickname']);
        $this->assign('showmenu',1);
        $this->display();
    }
    function myfavor() {
        $this->tologin();

        import("@.ORG.Page");
        C('PAGE_NUMBERS',10);
        $ctent=D('Content');
        $fview=D('FavoriteView');

        //总页数
        $count = $fview->where("sc_uid='".$this->my['user_id']."' AND replyid=0")->count();
        $p= new Page($count,20);
        $page = $p->show('Wap/myfavor/p/');
        //内容
        $content = $fview->where("sc_uid='".$this->my['user_id']."' AND replyid=0")->order("fav_id DESC")->limit($p->firstRow.','.$p->listRows)->select();
        $content=$ctent->loadretwitt($content,1);

        $this->assign('page',$page);
        $this->assign('content',$content);
        $this->assign('subname','我的收藏 - '.$this->my['nickname']);
        $this->assign('showmenu',1);
        $this->display();
    }
    function mycomment() {
        $this->tologin();
        $tab=$_GET['tab']?$_GET['tab']:1;
        $title=$tab==1?'收到评论':'发出评论';

        import("@.ORG.Page");
        C('PAGE_NUMBERS',10);
        if ($tab==1) {
            $count = D('Comments')->where("user_id='".$this->my['user_id']."'")->count();
            $p= new Page($count,20);
            $page = $p->show('Wap/mycomment/tab/'.$tab.'/p/');
            $data = D('CommentsView')->where("Comments.user_id='".$this->my['user_id']."'")->order("dateline DESC")->limit($p->firstRow.','.$p->listRows)->select();
        } else {
            $count = D('Comments')->where("comment_uid='".$this->my['user_id']."'")->count();
            $p= new Page($count,20);
            $page = $p->show('Wap/mycomment/tab/'.$tab.'/p/');
            $data = D('CommentslistView')->where("Comments.comment_uid='".$this->my['user_id']."'")->order("dateline DESC")->limit($p->firstRow.','.$p->listRows)->select();
        }

        if ($this->my['comments']>0) {
            D('Users')->where("user_id='".$this->my['user_id']."'")->setField('comments',0);
        }

        $this->assign('count',$count);
        $this->assign('page',$page);
        $this->assign('data',$data);
        $this->assign('tab',$tab);
        $this->assign('subname',$title.' - '.$this->my['nickname']);
        $this->assign('showmenu',1);
        $this->display();
    }
    function view() {
        $this->tologin();
        $cid=$_GET['cid'];

        $cview=D('ContentView');
        $ctent=D('Content');
        $content = $cview->where("content_id='$cid' AND replyid=0")->findAll();
        $content=$ctent->loadretwitt($content,1);
        $content=$content[0];
        if (!$content) {
            $this->showmessage("<div class='showmag'><p>很抱歉，该广播不存在！</p><p><a href='".SITE_URL."/Wap/".base64_decode($_GET['from'])."'>返回上一页</a></p></div>");
            exit;
        }
        $this->assign('content',$content);
        $this->assign('showmenu',1);
        $this->display();
    }
    function sendprimsg() {
        $this->tologin();
        $user_name=$_GET['user_name'];
        $user=D('Users')->where("user_name='$user_name'")->find();
        if (!$user) {
            $this->showmessage("<div class='showmag'><p>很抱歉，该用户不存在！</p><p><a href='".SITE_URL."/Wap/".base64_decode($_GET['from'])."'>返回上一页</a></p></div>");
            exit;
        }

        $this->assign('from',base64_decode($_GET['from']));
        $this->assign('user',$user);
        $this->assign('submenu','发送私信');
        $this->assign('showmenu',1);
        $this->display();
    }
    function dosendprimsg() {
        $this->tologin();
        $msg=D('Messages')->sendmsg($_POST['content'] ,$_POST['user_name'],$this->my['user_id']);
        $msg=$msg=='success'?'私信发送成功！':$msg;
        $this->showmessage("<div class='showmag'>$msg<p></p><p><a href='".SITE_URL."/Wap/".base64_decode($_POST['from'])."'>返回上一页</a></p></div>");
    }
    function delprimsg() {
        $this->tologin();
        $mid=$_GET['mid'];
        $this->showmessage("<div class='showmag'><p>您确定要删除该私信吗？</p><p><a href='".SITE_URL."/Wap/dodelprimsg/mid/$mid'>确定</a>&nbsp;&nbsp;&nbsp;<a href='".SITE_URL."/Wap/message'>取消</a></p></div>");
    }
    function dodelprimsg() {
        $this->tologin();
        D('Messages')->delmsg($_GET['mid'],$this->my['user_id']);
        $this->showmessage("<div class='showmag'><p>删除私信成功了！</p><p><a href='".SITE_URL."/Wap/message'>返回上一页</a></p></div>");
    }
    function delfollow() {
        $this->tologin();
        $user_name=$_GET['user_name'];
        $from=base64_decode($_GET['from']);
        $this->showmessage("<div class='showmag'><p>您确定要解除收听好友吗？</p><p><a href='".SITE_URL."/Wap/dodelfollow/user_name/$user_name/from/".base64_encode($from)."'>确定</a>&nbsp;&nbsp;&nbsp;<a href='".SITE_URL."/Wap/$from'>取消</a></p></div>");
    }
    function dodelfollow() {
        $this->tologin();
        $from=base64_decode($_GET['from']);
        D('Friend')->delfollow($_GET['user_name'],$this->my['user_id']);
        $this->showmessage("<div class='showmag'><p>解除收听成功了！</p><p><a href='".SITE_URL."/Wap/$from'>返回上一页</a></p></div>");
    }
    function addfollow() {
        $this->tologin();
        $from=base64_decode($_GET['from']);
        D('Friend')->addfollow($_GET['user_name'],$this->my['user_id']);
        $this->showmessage("<div class='showmag'><p>收听用户成功了！</p><p><a href='".SITE_URL."/Wap/$from'>返回上一页</a></p></div>");
    }
    function delcm() {
        $this->tologin();
        $cid=$_GET['cid'];
        $from=base64_decode($_GET['from']);
        $this->showmessage("<div class='showmag'><p>您确定要删除该评论吗？</p><p><a href='".SITE_URL."/Wap/dodelcm/cid/$cid/from/".base64_encode($from)."'>确定</a>&nbsp;&nbsp;&nbsp;<a href='".SITE_URL."/Wap/mycomment'>取消</a></p></div>");
    }
    function dodelcm() {
        $this->tologin();
        D('Comments')->where("comment_id='".$_GET['cid']."' AND (user_id='".$this->my['user_id']."' OR comment_uid='".$this->my['user_id']."')")->delete();
        $this->showmessage("<div class='showmag'><p>恭喜您，删除评论成功了！</p><p><a href='".SITE_URL."/Wap/mycomment'>返回上一页</a></p></div>");
    }
    function delfavor() {
        $this->tologin();
        $cid=$_GET['cid'];
        $from=base64_decode($_GET['from']);
        $this->showmessage("<div class='showmag'><p>您确定要删除该收藏吗？</p><p><a href='".SITE_URL."/Wap/dodelfavor/cid/$cid/from/".base64_encode($from)."'>确定</a>&nbsp;&nbsp;&nbsp;<a href='".SITE_URL."/Wap/$from'>取消</a></p></div>");
    }
    function dodelfavor() {
        $this->tologin();
        D('Favorite')->delfavor($_GET['cid'],$this->my['user_id']);
        $this->showmessage("<div class='showmag'><p>恭喜您，删除收藏成功了！</p><p><a href='".SITE_URL."/Wap/".base64_decode($_GET['from'])."'>返回上一页</a></p></div>");
    }
    function sendphoto() {
        $this->tologin();
        $this->assign('subname','照片广播');
        $this->assign('showmenu',1);
        $this->display();
    }
    function dosendphoto() {
        $this->tologin();
        $ctent=D('Content');
        $content=$_POST['content']?$_POST['content']:'我分享了照片';
        $ret=json_decode($ctent->uploadpic(),true);
        if ($ret['ret']!='success') {
            $this->showmessage("<div class='showmag'><p>发布失败，可能是格式不正确或者太大！</p><p><a href='".SITE_URL."/Wap/sendphoto'>返回上一页</a></p></div>");
        } else {
            $ret=json_decode($ctent->sendmsg($content,$ret['content'],'手机'),true);
            if ($ret['ret']=='success') {
                $this->showmessage("<div class='showmag'><p>恭喜您，图片广播发布成功！</p><p><a href='".SITE_URL."/Wap/sendphoto'>返回上一页</a></p></div>");
            } else {
                $this->showmessage("<div class='showmag'><p>很抱歉，图片广播发布失败！</p><p><a href='".SITE_URL."/Wap/sendphoto'>返回上一页</a></p></div>");
            }
        }
    }
    function sendmsg() {
        $this->tologin();
        $cview=D('ContentView');
        $ret=json_decode(D('Content')->sendmsg($_POST["content"],'','手机'),true);
        if ($ret['ret']=='success') {
            $this->showmessage("<div class='showmag'><p>恭喜您，广播发布成功！</p><p><a href='".SITE_URL."/Wap'>返回上一页</a></p></div>");
        } else {
            $this->showmessage("<div class='showmag'><p>".$ret['ret']."</p><p><a href='".SITE_URL."/Wap'>返回上一页</a></p></div>");
        }
    }
    function ret() {
        $this->tologin();
        $cid=$_GET['cid'];

        import("@.ORG.Page");
        C('PAGE_NUMBERS',10);

        $cview=D('ContentView');
        $ctent=D('Content');
        $content = $cview->where("content_id='$cid' AND replyid=0")->findAll();
        $content=$ctent->loadretwitt($content,1);
        $content=$content[0];
        if (!$content) {
            $this->showmessage("<div class='showmag'><p>很抱歉，该广播不存在！</p><p><a href='".SITE_URL."/Wap/".base64_decode($_GET['from'])."'>返回上一页</a></p></div>");
            exit;
        }
        //ret
        $p= new Page($content['zftimes'],20);
        $page = $p->show("Wap/ret/cid/$cid/from/$_GET[from]/p/");
        $ret = $cview->where("retid='$cid'")->order("posttime DESC")->limit($p->firstRow.','.$p->listRows)->select();

        $this->assign('cont',$content['zftimes']);
        $this->assign('ret',$ret);
        $this->assign('page',$page);
        $this->assign('content',$content);
        $this->assign('showmenu',1);
        $this->display();
    }
    function doret() {
        $this->tologin();
        $ctent=D('Content');
        $ret=json_decode($ctent->retwit($_POST['cid'],$_POST["scont"],'手机'),true);
        if ($ret['ret']=='success') {
            $this->showmessage("<div class='showmag'><p>恭喜您，转播成功了！</p><p><a href='".SITE_URL."/Wap/".base64_decode($_GET['from'])."'>返回上一页</a></p></div>");
        } else {
            $this->showmessage("<div class='showmag'><p>".$ret['ret']."</p><p><a href='".SITE_URL."/Wap/".base64_decode($_GET['from'])."'>返回上一页</a></p></div>");
        }
    }
    function comment() {
        $this->tologin();
        $cid=$_GET['cid'];

        import("@.ORG.Page");
        C('PAGE_NUMBERS',10);

        $cview=D('ContentView');
        $ctent=D('Content');
        $content = $cview->where("content_id='$cid' AND replyid=0")->findAll();
        $content=$ctent->loadretwitt($content,1);
        $content=$content[0];
        if (!$content) {
            $this->showmessage("<div class='showmag'><p>很抱歉，该广播不存在！</p><p><a href='".SITE_URL."/Wap/".base64_decode($_GET['from'])."'>返回上一页</a></p></div>");
            exit;
        }
        //reply
        $p= new Page($content['replytimes'],20);
        $page = $p->show("Wap/comment/cid/$cid/from/$_GET[from]/p/");
        $reply = $cview->where("replyid='$cid'")->order("posttime DESC")->limit($p->firstRow.','.$p->listRows)->select();
        $reply=$ctent->loadretwitt($reply,1);

        $this->assign('cont',$content['replytimes']);
        $this->assign('reply',$reply);
        $this->assign('page',$page);
        $this->assign('content',$content);
        $this->assign('showmenu',1);
        $this->display();
    }
    function docomment() {
        $this->tologin();
        $isret=$_POST['ret']=="on"?1:0;
        $cview=D('ContentView');
        $ret=json_decode(D('Content')->doreply($_POST['scont'],$_POST['cid'],$isret,'手机'),true);
        if ($ret['ret']=='success') {
            $this->showmessage("<div class='showmag'><p>恭喜您，评论成功了！</p><p><a href='".SITE_URL."/Wap/".base64_decode($_GET['from'])."'>返回上一页</a></p></div>");
        } else {
            $this->showmessage("<div class='showmag'><p>".$ret['ret']."</p><p><a href='".SITE_URL."/Wap/".base64_decode($_GET['from'])."'>返回上一页</a></p></div>");
        }
    }
    function favor() {
        $this->tologin();
        $msg=D('Favorite')->dofavor($_GET['cid'],$this->my['user_id']);
        $msg=$msg=='success'?"收藏广播成功了！":$msg;
        $this->showmessage("<div class='showmag'><p>$msg</p><p><a href='".SITE_URL."/Wap/".base64_decode($_GET['from'])."'>返回上一页</a></p></div>");
    }
    function delmsg() {
        $this->tologin();
        $cid=$_GET['cid'];
        $from=base64_decode($_GET['from']);
        $this->showmessage("<div class='showmag'><p>您确定要删除该广播吗？</p><p><a href='".SITE_URL."/Wap/dodelmsg/cid/$cid/from/".base64_encode($from)."'>确定</a>&nbsp;&nbsp;&nbsp;<a href='".SITE_URL."/Wap/$from'>取消</a></p></div>");
    }
    function dodelmsg() {
        $this->tologin();
        $msg=D('Content')->delmsg($_GET['cid']);
        $msg=$msg=='success'?"删除广播成功了！":$msg;
        $this->showmessage("<div class='showmag'><p>$msg</p><p><a href='".SITE_URL."/Wap/".base64_decode($_GET['from'])."'>返回上一页</a></p></div>");
    }
    function showmessage($message) {
        $this->display('header');
        echo $message;
        $this->display('footer');
    }
    function logout() {
        setcookie('wapcookie','',-1,'/');
        Cookie::delete('wapcookie');
        header('location:'.SITE_URL.'/Wap/index');
    }
    function dologin() {
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
                        $this->showmessage("<div class='showmag'><p>很抱歉，该帐号不能使用</p><p><a href='".SITE_URL."/Wap'>返回主页</a></p></div>");
                        exit;
                    }
                    $auth = rawurlencode(authcode("$username\t".time(), 'ENCODE'));
			        $this->showmessage("<div class='showmag'><p>您需要激活该帐号，才能进入微博！</p><p><a href='".SITE_URL."/Wap'>返回主页</a></p></div>");
                    exit;
                } else {
                    if (md5(md5($password))!=$user['password']) {//密码错误
                        $this->showmessage("<div class='showmag'><p>用户名或者密码错误，请重新登录！</p><p><a href='".SITE_URL."/Wap'>返回主页</a></p></div>");
                        exit;
                    }
                    if ($remember=="on") {
                        Cookie::set('wapcookie', authcode("$user[user_name]\t$user[user_id]",'ENCODE'), 31536000);
                    } else {
                        Cookie::set('wapcookie', authcode("$user[user_name]\t$user[user_id]",'ENCODE'));
                    }
                    header('location:'.SITE_URL.'/Wap/home');
                }
            } else {
                $this->showmessage("<div class='showmag'><p>用户名或者密码错误，请重新登录！</p><p><a href='".SITE_URL."/Wap'>返回主页</a></p></div>");
                exit;
            }
        //end
        } else {
            $user = D("Users")->where("(user_name='$username' OR mailadres='$username') AND password='$userpass'")->field('user_id,user_name,userlock')->find();
            if($user) {
                if ($user["userlock"]==1) {
                    $this->showmessage("<div class='showmag'><p>您好，您的帐号被管理员屏蔽，不能登录！</p><p><a href='".SITE_URL."/Wap'>返回主页</a></p></div>");
                    exit;
                } else {
                    if ($remember=="on") {
                        Cookie::set('wapcookie', authcode("$user[user_name]\t$user[user_id]",'ENCODE'), 31536000);
                    } else {
                        Cookie::set('wapcookie', authcode("$user[user_name]\t$user[user_id]",'ENCODE'));
                    }
                    header('location:'.SITE_URL.'/Wap/home');
                }
            } else {
                $this->showmessage("<div class='showmag'><p>用户名或者密码错误，请重新登录！</p><p><a href='".SITE_URL."/Wap'>返回主页</a></p></div>");
                exit;
            }
        }
    }
    private function tohome() {
        if ($this->my) {
            header("location: ".SITE_URL."/Wap/home");
            exit;
        }
    }
    private function tologin() {
        if (!$this->my) {
            header("location: ".SITE_URL."/Wap");
            exit;
        }
    }
}
?>