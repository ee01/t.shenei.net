<?php
/***********************************************************
    [EasyTalk] (C)2009 - 2011 nextsns.com
    This is NOT a freeware, use is subject to license terms

    @Filename SpaceAction.class.php $

    @Author hjoeson $

    @Date 2011-01-09 08:45:20 $
*************************************************************/

class SpaceAction extends Action{
    private $user;
    private $ctent;
    private $uModel;

    //初始化
    public function _initialize() {
        $this->ctent=D('Content');
        $this->ctent->setmy($this->my);
        $this->assign('ctent',$this->ctent);
    }

    public function index(){
        $this->uModel=D('Users');
        import("@.ORG.Page");
        C('PAGE_NUMBERS',10);
        $cview=D('ContentView');
        $fview=D('FavoriteView');
        $t=$_GET['t']?$_GET['t']:'a';

        //查看条件
        if ($t=='p') {
            $condition=' AND filetype="photo"';
        } else if ($t=='m') {
            $condition=' AND filetype="media"';
        } else if ($t=='0') {
            $condition=' AND retid=0';
        } else if ($t=='r') {
            $condition=' AND retid!=0';
        } else {
            $condition='';
        }
        $type=$_GET['type']?$_GET['type']:'home';
        $user_name=$_GET['user_name'];
        if ($user_name==$this->my['user_name']) {
            $this->user=$this->my;
        } else {
            $data=$this->uModel->where('user_name="'.$user_name.'"')->select();
            $this->user=$data[0];
        }
        if (!$this->user) {
            $this->assign('type','nouser');
            $this->display('Error/index');
            exit;
        }
        if ($this->user['userlock']==1) {
            $this->assign('type','userlock');
            $this->display('Error/index');
            exit;
        }
        if ($this->user['user_id']!=$this->my['user_id'] && $type!='follower' && $type!='following') {
            $this->profile();
            exit;
        }
        if ($type=='home') {
            $cfview=D('FollowContentView');
            //总页数
            $count = $cfview->where("fid_fasong='".$this->my['user_id']."' AND replyid=0".$condition)->count();
            $countmy = $this->ctent->where("user_id='".$this->my['user_id']."' AND replyid=0".$condition)->count();//我的消息数
            $count+=$countmy;
            $count=min($count,200);
            $p= new Page($count,20);
		    $page = $p->show($this->my['user_name'].'/'.$type.'/'.$t.'/');
            //内容
            $content = $cfview->where("(fid_fasong='".$this->my['user_id']."' OR Users.user_id='".$this->my['user_id']."') AND replyid=0".$condition)->group('content_id')->order("posttime DESC")->limit($p->firstRow.','.$p->listRows)->select();
            $content=$this->ctent->loadretwitt($content);
            if ($p->firstRow==0) {
                $this->assign('sendtalk',1);
            }
        } else if ($type=='mine') {
            //总页数
            $count = $this->ctent->where("user_id='".$this->my['user_id']."' AND replyid=0".$condition)->count();
            $p= new Page($count,20);
		    $page = $p->show($this->my['user_name'].'/'.$type.'/'.$t.'/');
            //内容
            $content = $cview->where("Users.user_id='".$this->my['user_id']."' AND replyid=0".$condition)->order("posttime DESC")->limit($p->firstRow.','.$p->listRows)->select();
            $content=$this->ctent->loadretwitt($content);
            if ($p->firstRow==0) {
                $this->assign('sendtalk',1);
            }
        } else if ($type=='at') {
            $caview=D('ContentatView');
            //总页数
            $count = $caview->where("Content_mention.user_id='".$this->my['user_id']."' AND replyid=0".$condition)->count();
            $p= new Page($count,20);
		    $page = $p->show($this->my['user_name'].'/'.$type.'/'.$t.'/');
            //内容
            $content = $caview->where("Content_mention.user_id='".$this->my['user_id']."' AND replyid=0".$condition)->order("attime DESC")->limit($p->firstRow.','.$p->listRows)->select();
            $content=$this->ctent->loadretwitt($content);
            //清空提示
            if ($this->my['atnum']>0 && $this->user['user_id']==$this->my['user_id']) {
                $this->uModel->where("user_id='".$this->my['user_id']."'")->setField('atnum',0);
            }
        } else if ($type=='favor') {
            //总页数
            $count = $fview->where("sc_uid='".$this->my['user_id']."' AND replyid=0".$condition)->count();
            $p= new Page($count,20);
		    $page = $p->show($this->my['user_name'].'/'.$type.'/'.$t.'/');
            //内容
            $content = $fview->where("sc_uid='".$this->my['user_id']."' AND replyid=0".$condition)->order("fav_id DESC")->limit($p->firstRow.','.$p->listRows)->select();
            $content=$this->ctent->loadretwitt($content);
        } else if ($type=='profile') {
            $this->profile();
            exit;
        } else if ($type=='follower') {
            $this->follower();
            exit;
        } else if ($type=='following') {
            $this->following();
            exit;
        }

        $this->assign('subname',$this->user['nickname']);
        $this->assign('userside',$this->uModel->userside($this->user,'userside'));
        $this->assign('page',$page);
        $this->assign('type',$type);
        $this->assign('t',$t);
        $this->assign('content',$content);
        $this->assign('usertemp',usertemp($this->user));
        $this->assign('usertopic',D('Mytopic')->usertopic($this->user['user_id']));
        $this->assign('menu','home');
        $this->display();
    }

    public function profile() {
        $cview=D('ContentView');
        $t=$_GET['t']?$_GET['t']:'a';
        //查看条件
        if ($t=='p') {
            $condition=' AND filetype="photo"';
        } else if ($t=='m') {
            $condition=' AND filetype="media"';
        } else if ($t=='0') {
            $condition=' AND retid=0';
        } else if ($t=='r') {
            $condition=' AND retid!=0';
        } else {
            $condition='';
        }
        //总页数
        $count = $this->ctent->where("user_id='".$this->user['user_id']."' AND replyid=0".$condition)->count();
        $p= new Page($count,20);
        if ($this->user['user_id']==$this->my['user_id']) {
            $this->assign('menu','profile');
        }
        $page = $p->show($this->user['user_name'].'/profile/'.$t.'/');
        //内容
        $content = $cview->where("Users.user_id='".$this->user['user_id']."' AND replyid=0".$condition)->order("posttime DESC")->limit($p->firstRow.','.$p->listRows)->select();
        $content=$this->ctent->loadretwitt($content);

        $this->assign('keyword',$this->user['nickname'].'的微博,');
        $this->assign('page',$page);
        $this->assign('type','profile');
        $this->assign('userside',$this->uModel->userside($this->user,'proside'));
        $this->assign('content',$content);
        $this->assign('user',$this->user);
        $this->assign('isfriend',D('Friend')->followstatus($this->user['user_id'],$this->my['user_id']));
        $this->assign('usertemp',usertemp($this->user));
        $this->assign('usertopic',D('Mytopic')->usertopic($this->user['user_id']));
        $this->assign('t',$t);
        $this->display('profile');
    }

    public function follower() {
        $fModel=D('Friend');
        //分页
        $p= new Page($this->user['followme_num'],20);
        $page = $p->show($this->user['user_name'].'/follower/p/');
        $follower=$this->uModel->follows($this->user['user_id'],$p->firstRow,$p->listRows);

        if (is_array($follower)) {
            $fids=$isfollower=array();
            foreach ($follower as $val) {
                $fids[]=$val['user_id'];
            }
            $fids[]=$this->user['user_id'];
            $count=count($fids);
            if ($count>0) {
                $fids=implode(",",$fids);
                $isfollower= $fModel->followstatus($fids,$this->my['user_id']);
            }
            if ($this->my['newfollownum']>0 && $this->user['user_id']==$this->my['user_id']) {
                $this->uModel->where("user_id='".$this->my['user_id']."'")->setField('newfollownum',0);
            }
        }

        if ($this->user['user_id']==$this->my['user_id']) {
            $this->assign('userside',$this->uModel->userside($this->my,'userside'));
        } else {
            $this->assign('userside',$this->uModel->userside($this->user,'userside'));
        }
        $this->assign('isfriend',$fModel->followstatus($this->user['user_id'],$this->my['user_id']));
        $this->assign('isfollower',$isfollower);
        $this->assign('follower',$follower);
        $this->assign('page',$page);
        $this->assign('subname',$this->user['nickname'].'的听众');
        $this->assign('user',$this->user);
        $this->assign('usertemp',usertemp($this->user));
        $this->assign('usertopic',D('Mytopic')->usertopic($this->user['user_id']));
        $this->assign('menu','follow');
        $this->display('follower');
    }

    public function following() {
        $fModel=D('Friend');
        $p= new Page($this->user['follow_num'],20);
        $page = $p->show($this->user['user_name'].'/following/p/');
        $following=$this->uModel->friends($this->user['user_id'],$p->firstRow,$p->listRows);
        if (is_array($following)) {
            $fids=$isfollower=array();
            foreach ($following as $val) {
                $fids[]=$val['user_id'];
            }
            $fids[]=$this->user['user_id'];
            $count=count($fids);
            if ($count>0) {
                $fids=implode(",",$fids);
                $isfollower= $fModel->followstatus($fids,$this->my['user_id']);
            }
        }
        if ($this->user['user_id']==$this->my['user_id']) {
            $this->assign('userside',$this->uModel->userside($this->my,'userside'));
        } else {
            $this->assign('userside',$this->uModel->userside($this->user,'userside'));
        }
        $this->assign('isfriend',$fModel->followstatus($this->user['user_id'],$this->my['user_id']));
        $this->assign('isfollower',$isfollower);
        $this->assign('following',$following);
        $this->assign('page',$page);
        $this->assign('subname',$this->user['nickname'].'收听的人');
        $this->assign('user',$this->user);
        $this->assign('userside',$this->uModel->userside($this->user,'userside'));
        $this->assign('usertemp',usertemp($this->user));
        $this->assign('usertopic',D('Mytopic')->usertopic($this->user['user_id']));
        $this->assign('menu','follow');
        $this->display('following');
    }

    public function addfollow() {
        $this->tologin();
        $fModel=D('Friend');
        echo $fModel->addfollow($_GET['user_name'],$this->my['user_id']);
    }

    public function delfollow() {
        $this->tologin();
        $fModel=D('Friend');
        echo $fModel->delfollow($_GET['user_name'],$this->my['user_id']);
    }

    public function reply() {
        $cview=D('ContentView');
        $contentid=$_GET['cid'];
        $replynum=0;
        if ($contentid) {
            $content = $cview->where("replyid='$contentid'")->order("posttime DESC")->select();
            foreach ($content as $val) {
                $replynum++;
                if ($replynum<=10) {
                    $replys.=$this->ctent->loadonereply($val);
                } else {
                    break;
                }
            }
        }
        if ($replynum>10) {
            $replys.='<li class="lire fright"><a href="'.SITE_URL.'/v/'.$contentid.'">点击查看剩余的 '.($replynum-10).' 条评论</a></li>';
        }
        $this->assign('contentid',$contentid);
        $this->assign('replys',$replys);
        $this->display();
    }

    public function sendmsg() {
        $this->tologin();
        $cview=D('ContentView');
        $ret=json_decode($this->ctent->sendmsg($_POST["content"],$_POST["morecontent"],'网页'),true);
        if ($ret['ret']=='success') {
            $data = $cview->where("content_id='$ret[insertid]'")->find();
            echo json_encode(array("ret"=>"success","data"=>$this->ctent->loadoneli($data)));
        } else {
            echo json_encode(array("ret"=>"error","data"=>$ret['ret']));
        }
        exit;
    }

    public function checkvideourl() {
        $url=$_POST['videourl'];
        $ret=videourl($url);
        echo json_encode($ret);
    }

    public function delmsg() {
        $this->tologin();
        echo D('Content')->delmsg($_GET['cid']);
    }

    public function uploadpic() {
        $this->tologin();
        echo D('Content')->uploadpic();
    }

    public function dofavor() {
        $this->tologin();
        echo D('Favorite')->dofavor($_GET['cid'],$this->my['user_id']);
    }

    public function delfavor() {
        $this->tologin();
        echo D('Favorite')->delfavor($_GET['cid'],$this->my['user_id']);
    }

    public function doreply() {
        $this->tologin();
        $isret=$_POST['rck']=="true"?1:0;
        $closebox=intval($_POST['closebox']);
        $cview=D('ContentView');
        $ret=json_decode($this->ctent->doreply($_POST['scont'],$_POST['sid'],$isret,'网页'),true);
        if ($ret['ret']=='success') {
            $data = $cview->where("content_id='$ret[insertid]'")->find();
            if ($closebox==1) {
                $dt=$this->ctent->loadonereply($data,1);
            } else {
                $dt=$this->ctent->loadonereply($data);
            }
            echo json_encode(array("ret"=>"success","data"=>$dt));
        } else {
            echo json_encode(array("ret"=>"error","data"=>$ret['ret']));
        }
    }

    public function retwit() {
        $this->tologin();
        $ret=json_decode($this->ctent->retwit($_POST['cid'],$_POST["retcont"],'网页'),true);
        if ($ret['ret']=='success') {
            $cview=D('ContentView');
            $row = $cview->where("content_id='$ret[insertid]' OR content_id='$ret[retid]'")->select();
            foreach($row as $val) {
                if ($val['content_id']==$ret['retid']) {
                    $retdata = $val;
                } else {
                    $data = $val;
                }
            }
            $data['retbody'] = $this->ctent->loadretbody($retdata,$ret['insertid']);
            echo json_encode(array("ret"=>"success","data"=>$this->ctent->loadoneli($data)));
        } else {
            echo json_encode(array("ret"=>"error","data"=>$ret['ret']));
        }
    }

    public function report() {
        $this->tologin();
        $reporttp=$_POST['reporttp'];
        $reportbd=daddslashes(trim($_POST['describe']));

        if ($reporttp && $reportbd) {
            $insert['user_name']=$this->my['user_name'];
            $insert['reporttype']=$reporttp;
            $insert['reportbody']=$reportbd;
            $insert['dateline']=time();

            D('Report')->add($insert);
            echo 'success';
        } else {
            echo '很抱歉，您提交的信息不完整！';
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