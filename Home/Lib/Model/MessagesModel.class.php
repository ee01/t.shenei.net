<?php
/***********************************************************
    [EasyTalk] (C)2009 - 2011 nextsns.com
    This is NOT a freeware, use is subject to license terms

    @Filename MessagesModel.class.php $

    @Author hjoeson $

    @Date 2011-01-09 08:45:20 $
*************************************************************/

class MessagesModel extends BaseModel {

    //删除信件
    public function delmsg($messgeid,$uid) {
        if ($messgeid) {
            $data = $this->where("(senduid ='$uid' OR sendtouid ='$uid') AND message_id='$messgeid'")->find();
            if ($data) {
                $this->where("(senduid ='$uid' OR sendtouid ='$uid') AND message_id='$messgeid'")->delete();
                return 'success';
            } else {
                return '删除失败，可能此广播不存在！';
            }
        } else {
            return '';
        }
    }

    //发送信件
    public function sendmsg($message,$user_name,$mid) {
        $uModel=D('Users');
        $message=getsubstr(trim($message),0,140,false);
        $message=daddslashes($message);
        $user=$uModel->getUser("user_name='$user_name'");
        if (!$message) {
            return '还没有填写发送的信息';
        }
        //short url
        if (strpos($message,'://')!==false) {
            if (preg_match_all('~(?:https?\:\/\/)(?:[A-Za-z0-9\_\-]+\.)+[A-Za-z0-9]{2,4}(?:\/[\w\d\/=\?%\-\&_\~\`\@\[\]\:\+\#\.]*(?:[^\<\>\'\"\n\r\t\s\x7f-\xff])*)?~',$message,$match)) {
                foreach ($match[0] as $v) {
                    $v = trim($v);
                    if(($vl=strlen($v)) < 8 || $vl > 200) {
                        continue ;
                    }
                    $key=$this->IntToABC(time());
                    $url['key']=$key;
                    $url['url']=$v;
                    D('Url')->add($url);
                    $cont_sch[] = "{$v}";
                    $cont_rpl[] = "[U {$key}]{$v}[/U]";
                }
            }
        }
        //topic
        if (strpos($message,'#')!==false) {
            if (preg_match_all('~\#([^\#]+?)\#~',$message,$match)) {
                $tm=D('Topic');
                foreach ($match[1] as $v) {
                    $v = trim($v);
                    $vl = StrLenW($v);
                    if($vl>=1 && $vl<15) {
                        $tags[$v] = $v;
                        $cont_sch[] = "#{$v}#";
                        $cont_rpl[] = "[T]{$v}[/T]";
                        $topics[]=$v;
                    }
                }
            }
        }
        if ($cont_sch && $cont_rpl) {
            $message = str_replace($cont_sch,$cont_rpl,$message);
        }
        if (!$user['user_id']) {
            return '发送的用户不存在';
        } else {
            $isfollow=D('Friend')->followstatus($user['user_id'],$mid);
            if ($isfollow[$user['user_id']]==2 || $isfollow[$user['user_id']]==3 || $mid==0 || $mid==1) {
                $uModel->setInc('priread',"user_id='$user[user_id]'"); //提示
                $insert['senduid']=$mid;
                $insert['sendtouid']=$user['user_id'];
                $insert['messagebody']=$message;
                $insert['sendtime']=time();
                $this->add($insert);

                return 'success';
            } else {
                return 'TA还不是您的听众哦';
            }
        }
    }

    private function transfer($int, &$a) {
        if($int>26){
            $a[] = $int%26;
            if(floor($int/26)>26){
                return $this->transfer(floor($int/26),$a);
            } else {
                return $a[] = floor($int/26);
            }
        }
        return $a[]=$int;
    }

    private function IntToABC($int) {
        $this->transfer($int, $w);
        $abc=array();
        $s = 1;
        for($i=97; $i<=122; $i++) {
            $abc[$s] = chr($i);
            $s++;
        }
        $result = '';
        for($i=0;$i<count($w); $i++) {
            $w[$i] = $w[$i]==0 ? 1 : $w[$i];
            $result = $abc[$w[$i]].$result;
        }
        return $result;
    }
}
?>