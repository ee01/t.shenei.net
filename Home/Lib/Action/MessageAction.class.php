<?php
/***********************************************************
    [EasyTalk] (C)2009 - 2011 nextsns.com
    This is NOT a freeware, use is subject to license terms

    @Filename MessageAction.class.php $

    @Author hjoeson $

    @Date 2011-01-09 08:45:20 $
*************************************************************/

class MessageAction extends Action {

    public function _initialize() {
        $this->tologin();
    }

    public function index() {
        header('location:'.SITE_URL.'/Message/inbox');
    }

    public function inbox() {
        $mes=D('Messages');
        $ctent=D('Content');
        $uModel=D('Users');

        import("@.ORG.Page");
        C('PAGE_NUMBERS',10);
        $count = $mes->where("sendtouid='".$this->my['user_id']."'")->count();
        $p= new Page($count,20);
        $page = $p->show('Message/inbox/');

        $data = D('MessagesView')->where("sendtouid='".$this->my['user_id']."'")->order("message_id DESC")->limit($p->firstRow.','.$p->listRows)->select();

        if ($this->my['priread']>0) {
            $uModel->where("user_id='".$this->my['user_id']."'")->setField('priread',0);
            $mes->where("sendtouid='".$this->my['user_id']."'")->setField('isread',1);
        }

        $this->assign('userside',$uModel->userside($this->my,'userside'));
        $this->assign('ctent',$ctent);
        $this->assign('count',$count);
        $this->assign('page',$page);
        $this->assign('data',$data);
        $this->assign('type','message');
        $this->assign('subname','收件箱');
        $this->assign('usertemp',usertemp($this->my));
        $this->display();
    }

    public function sendbox() {
        $mes=D('Messages');
        $ctent=D('Content');
        $uModel=D('Users');

        import("@.ORG.Page");
        C('PAGE_NUMBERS',10);
        $count = $mes->where("senduid='".$this->my['user_id']."'")->count();
        $p= new Page($count,20);
        $page = $p->show('Message/inbox/');

        $data = D('MessagesSendView')->where("senduid='".$this->my['user_id']."'")->order("message_id DESC")->limit($p->firstRow.','.$p->listRows)->select();

        if ($this->my['priread']>0) {
            $uModel->where("user_id='".$this->my['user_id']."'")->setField('priread',0);
        }

        $this->assign('userside',$uModel->userside($this->my,'userside'));
        $this->assign('ctent',$ctent);
        $this->assign('count',$count);
        $this->assign('page',$page);
        $this->assign('data',$data);
        $this->assign('type','message');
        $this->assign('subname','发件箱');
        $this->assign('usertemp',usertemp($this->my));
        $this->display();
    }

    public function delmsg() {
        $mes=D('Messages');
        $messgeid=$_GET['mid'];
        echo $mes->delmsg($messgeid,$this->my['user_id']);
    }

    public function sendmsg() {
        $mes=D('Messages');
        echo $mes->sendmsg($_POST['content'] ,$_POST['funame'],$this->my['user_id']);
    }

    public function getMsgUser() {
        $uModel=D('Users');
        $q = strtolower($_GET["q"]);
        if ($q) {
            echo $uModel->getMsgUser($q,$this->my['user_id']);
        }
    }

    private function tologin() {
        if (!$this->my) {
            echo '<script type="text/javascript">window.location.href="'.SITE_URL.'/login"</script>';
            exit;
        }
    }
}
?>