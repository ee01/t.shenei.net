<?php
/***********************************************************
    [EasyTalk] (C)2009 - 2011 nextsns.com
    This is NOT a freeware, use is subject to license terms

    @Filename FriendModel.class.php $

    @Author hjoeson $

    @Date 2011-01-09 08:45:20 $
*************************************************************/

class FriendModel extends BaseModel {

    //添加收听
    public function addfollow($user_name,$mid) {
        $uModel=D('Users');

        $user=$uModel->getUser("user_name='$user_name'");
        if($user['user_id']) {
            if ($user['user_id']!=$mid) {
                $isfriend=$this->followstatus($user['user_id'],$mid);
                if($isfriend[$user['user_id']]==1) {
                    return '您已经收听过此用户！';
                } else {
                    $uModel->where("user_id='$user[user_id]'")->setField(array('followme_num','newfollownum'),array(array('exp','followme_num+1'),array('exp','newfollownum+1')));
                    $uModel->where("user_id='$mid'")->setField('follow_num',array('exp','follow_num+1'));
                    $insert['fid_jieshou']=$user['user_id'];
                    $insert['fid_fasong']=$mid;
                    $this->add($insert);
                    return 'success';
                }
            } else {
                return '您不能收听自己！';
            }
        } else {
            return '该用户不存在或者已经被管理员删除！';
        }
    }

    //解除收听
    public function delfollow($user_name,$mid) {
        $uModel=D('Users');

        $user=$uModel->getUser("user_name='$user_name'");
        if($user['user_id']) {
            $isfriend=$this->followstatus($user['user_id'],$mid);
            if($isfriend[$user['user_id']]==0) {
                return '您没有收听此用户！';
            } else {
                $this->where("fid_fasong='$mid' AND fid_jieshou='$user[user_id]'")->delete();
                $uModel->where("user_id='$mid'")->setDec('follow_num');
                $uModel->where("user_id='$user[user_id]'")->setDec('followme_num');
                return 'success';
            }
        } else {
            return '该用户不存在或者已经被管理员删除！';
        }
    }

    //判断两人的关系 1表示uid1收听uid2，2表示uid2收听uid1，3表示互相收听
    public function followstatus($uids,$mid) {
        $data= $this->field('fid_jieshou,fid_fasong')->where("(fid_jieshou in ($uids) AND fid_fasong='$mid') OR (fid_fasong in ($uids) AND fid_jieshou='$mid')")->select();
        foreach($data as $val) {
            if ($val['fid_fasong']==$mid) {
                if (!$isfollower[$val['fid_jieshou']]) {
                    $isfollower[$val['fid_jieshou']]=1;
                } else {
                    $isfollower[$val['fid_jieshou']]=3;
                }
            } else if ($val['fid_jieshou']==$mid) {
                if (!$isfollower[$val['fid_fasong']]) {
                    $isfollower[$val['fid_fasong']]=2;
                } else {
                    $isfollower[$val['fid_fasong']]=3;
                }
            }
        }
        return $isfollower;
    }
}
?>