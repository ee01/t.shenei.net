<?php
/***********************************************************
    [EasyTalk] (C)2009 - 2011 nextsns.com
    This is NOT a freeware, use is subject to license terms

    @Filename MytopicModel.class.php $

    @Author hjoeson $

    @Date 2011-01-09 08:45:20 $
*************************************************************/

class MytopicModel extends Model {

    //话题是否关注
    public function isfollow($topic,$uid) {
        $data=$this->where("topic='$topic' AND user_id='$uid'")->find();
        return $data?1:0;
    }

    //用户关注的话题
    public function usertopic($uid) {
        $data=$this->where("user_id='$uid'")->select();
        return $data;
    }
}
?>