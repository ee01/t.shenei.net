<?php
/***********************************************************
    [EasyTalk] (C)2009 - 2011 nextsns.com
    This is NOT a freeware, use is subject to license terms

    @Filename PubAction.class.php $

    @Author hjoeson $

    @Date 2011-01-09 08:45:20 $
*************************************************************/

class PubAction extends Action{

    private $ctent;

    //初始化
    public function _initialize() {
        $this->tologin();
        $this->ctent=D('Content');
        $this->ctent->setmy($this->my);
        $this->assign('ctent',$this->ctent);
    }

    public function index(){
        import("@.ORG.Page");
        C('PAGE_NUMBERS',10);
        $cview=D('ContentView');
        $t=$_GET['t']?$_GET['t']:'index';
        $c=$_GET['c'];
        $q=$_GET['q'];//搜索
        $field='content_id,content_body,media_body,posttime,type,retid,replyid,replytimes,zftimes,user_name,nickname,user_head,user_auth,Users.live_city AS live_city';
        //我的城市
        if ($this->my['live_city']) {
            $_myc=explode(' ',$this->my['live_city']);
            $myc=$_myc[1];
        }

        //信息筛选
        if ($this->site['pubusersx']==1) {
            $condition=" AND user_head!='' AND live_city!='' AND user_gender!='' AND user_info!='' AND auth_email='1'";
        }

        //pubtop
        $pubtop=D('PubtopView')->order('RAND()')->limit(5)->select();

        if ($t=='index' || $t=='s') {
            if ($t!='s') {
                $count=$cview->field($field)->where('replyid=0'.$condition)->count();
                $count=min($count,200);
                $p= new Page($count,20);
                $page = $p->show("Pub?p=");
                $content = $cview->field($field)->where("replyid=0".$condition)->order("posttime DESC")->limit($p->firstRow.','.$p->listRows)->select();
            } else {
                $count=$this->ctent->where("replyid=0 AND content_body LIKE '%$q%'")->count();
                $count=min($count,200);
                $p= new Page($count,20);
                $page = $p->show("Pub?t=s&q={$q}&p=");
                $content = $cview->field($field)->where("replyid=0 AND content_body LIKE '%$q%'")->order("posttime DESC")->limit($p->firstRow.','.$p->listRows)->select();
            }
            $this->assign('subname','大家在说');
        } else if ($t=='hot') {
            $count=$this->ctent->where('replyid=0')->count();
            $count=min($count,200);
            $p= new Page($count,20);
            $page = $p->show("Pub?t=hot&p=");
            $content = $cview->field($field)->where("replyid=0".$condition)->order("replytimes+zftimes DESC")->limit($p->firstRow.','.$p->listRows)->select();
            $this->assign('subname','热门广播');
        } else if ($t=='city') {
            if (!$c) {
                $w='';
            } else {
                $w=" AND live_city LIKE '%$c%'";
            }
            $count=$cview->where("replyid=0".$w)->count();
            $count=min($count,200);
            $p= new Page($count,20);
            $page = $p->show("Pub?t=city&c={$c}&p=");
            $content = $cview->field($field)->where("replyid=0".$w.$condition)->order("posttime DESC")->limit($p->firstRow.','.$p->listRows)->select();
            $this->assign('subname','同城广播');
        }
        $content=$this->ctent->loadretwitt($content);

        $this->assign('pubtop',$pubtop);
        $this->assign('t',$t);
        $this->assign('c',$c);
        $this->assign('myc',$myc);
        $this->assign('page',$page);
        $this->assign('content',$content);
        $this->assign('menu','pub');
        $this->assign('pubside',D('Users')->pubside());
        $this->display();
    }

    public function view() {
        $cid=$_GET['cid'];
        $type=$_GET['type']?$_GET['type']:'a';
        $cview=D('ContentView');
        $uModel=D('Users');

        $content = $cview->where("content_id='$cid' AND replyid=0")->findAll();
        $content=$this->ctent->loadretwitt($content);
        $content=$content[0];
        if (!$content) {
            $this->assign('type','nocontent');
            $this->display('Error/index');
            exit;
        }

        $user=$uModel->where("user_name='$content[user_name]'")->find();

        import("@.ORG.Page");
        C('PAGE_NUMBERS',10);
        if ($content['retid']) {
            $type='r';
        }
        if ($type=='a') {
            $p= new Page($content['replytimes']+$content['zftimes'],20);
            $page = $p->show("v/{$cid}/a/");
            $reply = $cview->where("retid='$cid' OR replyid='$cid'")->order("posttime DESC")->limit($p->firstRow.','.$p->listRows)->select();
            $reply=$this->ctent->loadretwitt($reply);
        } else if ($type=='r') {
            $p= new Page($content['replytimes'],20);
            $page = $p->show("v/{$cid}/r/");
            $reply = $cview->where("replyid='$cid'")->order("posttime DESC")->limit($p->firstRow.','.$p->listRows)->select();
            $reply=$this->ctent->loadretwitt($reply);
        } else {
            $p= new Page($content['zftimes'],20);
            $page = $p->show("v/{$cid}/t/");
            $reply = $cview->where("retid='$cid'")->order("posttime DESC")->limit($p->firstRow.','.$p->listRows)->select();
            $reply=$this->ctent->loadretwitt($reply);
        }
        $this->assign('subname',$user['nickname'].':'.getsubstr(clean_html(ubbreplace($content['content_body'])),0,50));
        $this->assign('description',$user['nickname'].':'.clean_html(ubbreplace($content['content_body'])));
        $this->assign('keyword',$user['nickname'].'发表的微博,');
        $this->assign('user',$user);
        $this->assign('content',$content);
        $this->assign('page',$page);
        $this->assign('type',$type);
        $this->assign('reply',$reply);
        $this->assign('userside',$uModel->userside($user,'proside'));
        $this->assign('usertemp',usertemp($user));
        $this->display();
    }

    private function tologin() {
        if (!$this->my) {
            echo '<script type="text/javascript">window.location.href="'.SITE_URL.'/login"</script>';
            exit;
        }
    }
}
?>