<?php
/***********************************************************
    [EasyTalk] (C)2009 - 2011 nextsns.com
    This is NOT a freeware, use is subject to license terms

    @Filename PluginsAction.class.php $

    @Author hjoeson $

    @Date 2011-01-09 08:45:20 $
*************************************************************/

class PluginsAction extends Action {

    public function index() {
        if ($this->site['widgetopen']==0) {
            echo '<script>alert("很抱歉，博客挂件插件未开启！");window.location.href="'.SITE_URL.'"</script>';
            exit;
        }
        $this->display();
    }

    public function map() {
        if ($this->site['googlemapopen']==0) {
            echo '<script>alert("很抱歉，谷歌地图插件未开启！");window.location.href="'.SITE_URL.'"</script>';
            exit;
        }
        $umodel=D('Users');
        if ($this->site['pubusersx']==1) {
            $condition=" AND user_head!='' AND user_gender!='' AND user_info!='' AND auth_email='1'";
        }
        $content = $umodel->where("lastcontent!='' AND lastcontent!='0' AND live_city!='' AND live_city!='国外 海外'".$condition)->order("lastconttime DESC")->limit('30')->select();
        $this->assign('num',count($content));
        $this->assign('ctent',D('Content'));
        $this->assign('content',$content);
        $this->assign('menu','map');
        $this->display();
    }
}
?>