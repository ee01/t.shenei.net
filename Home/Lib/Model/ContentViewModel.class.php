<?php
/***********************************************************
    [EasyTalk] (C)2009 - 2011 nextsns.com
    This is NOT a freeware, use is subject to license terms

    @Filename ContentViewModel.class.php $

    @Author hjoeson $

    @Date 2011-01-09 08:45:20 $
*************************************************************/

class ContentViewModel extends ViewModel {
    public $viewFields = array(
        'Content'=>array('content_id','content_body','media_body','posttime','type','filetype','retid','replyid','replytimes','zftimes','_type'=>'LEFT'),
        'Users'=>array('user_id','user_name','nickname','user_head','user_auth','_on'=>'Content.user_id=Users.user_id'),
    );
}
?>