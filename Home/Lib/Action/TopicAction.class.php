<?php
/***********************************************************
    [EasyTalk] (C)2009 - 2011 nextsns.com
    This is NOT a freeware, use is subject to license terms

    @Filename TopicAction.class.php $

    @Author hjoeson $

    @Date 2011-01-09 08:45:20 $
*************************************************************/

class TopicAction extends Action {

    function _initialize() {
        $this->tologin();
    }

    public function index() {
        $keyword=$_GET['keyword'];
        $tModel=D('Topic');
        $ctent=D('Content');
        $ctview=D('ContenttopicView');
        $ctent->setmy($this->my);

        if (!$keyword) {
            $topic1 = $tModel->where("topictimes>0")->order("topictimes DESC")->limit(30)->select();
            $topic2 = $tModel->where("topictimes>0 AND tuijian=1")->order("topictimes DESC")->limit(30)->select();
            $topic3 = $tModel->where("topictimes>0 AND follownum>0")->order("follownum DESC")->limit(30)->select();
        } else {
            import("@.ORG.Page");
            C('PAGE_NUMBERS',10);
            $topic=D('Topic')->where("topicname='$keyword'")->find();
            $count=intval($topic['topictimes']);
            $count=min($count,200);
            $p= new Page($count,20);
            $page = $p->show("k/$keyword/");
            $content = $ctview->where("topic_id='$topic[id]' AND replyid=0")->order("posttime DESC")->limit($p->firstRow.','.$p->listRows)->select();
            $content=$ctent->loadretwitt($content);
            $isfollow=D('Mytopic')->isfollow($keyword,$this->my['user_id']);
            if ($p->firstRow==0) {
                $this->assign('sendtalk',1);
            }
        }

        $this->assign('ctent',$ctent);
        $this->assign('hottopic',$tModel->hottopic(0));
        $this->assign('keyword',$keyword);
        $this->assign('topic1',$topic1);
        $this->assign('topic2',$topic2);
        $this->assign('topic3',$topic3);
        $this->assign('page',$page);
        $this->assign('content',$content);
        $this->assign('count',$count);
        $this->assign('isfollow',$isfollow);
        if (!$keyword) {
            $this->assign('subname','热门话题');
        } else {
            $this->assign('subname','#'.$keyword.'#');
        }
        $this->display();
    }

    public function follow() {
        $keyword=$_GET['keyword'];
        $op=$_GET['op'];
        $mt=D('Mytopic');
        $tp=D('Topic');

        $tpdata=$tp->where("topicname='$keyword'")->find();
        if ($tpdata) {
            $data=$mt->where("topic='$keyword' AND user_id='".$this->my['user_id']."'")->find();
            if ($op=='fl') {
                if (!$data) {
                    $insert['topic']=$keyword;
                    $insert['user_id']=$this->my['user_id'];
                    $mt->add($insert);
                    $tp->where("id='$tpdata[id]'")->setInc('follownum');
                }
            } else if ($op=='jc') {
                if ($data) {
                    $mt->where("topic='$keyword' AND user_id='".$this->my['user_id']."'")->delete();
                    $tp->where("id='$tpdata[id]'")->setDec('follownum');
                }
            }
            echo 'success';
        } else {
            echo '很抱歉，该话题不存在';
        }
    }

    public function mytopic() {
        $data = D('Mytopic')->usertopic($this->my['user_id']);
        foreach ($data as $key=>$val) {
            $lis.='<li><a href="javascript:void(0)" onclick="Sharetopic(\''.$val['topic'].'\');">'.$val['topic'].'</a></li>';
        }
        echo $lis==''?'您还没有关注的话题':$lis;
    }

    public function tjtopic() {
        $data = D('Topic')->where('tuijian=1')->order('topictimes DESC')->limit(10)->select();
        foreach ($data as $key=>$val) {
            $lis.='<li><a href="javascript:void(0)" onclick="Sharetopic(\''.$val['topicname'].'\');">'.$val['topicname'].'</a><em>('.$val['topictimes'].')</em></li>';
        }
        echo $lis==''?'暂时还没有推荐话题':$lis;
    }

    private function tologin() {
        if (!$this->my) {
            echo '<script type="text/javascript">window.location.href="'.SITE_URL.'/login"</script>';
            exit;
        }
    }
}
?>