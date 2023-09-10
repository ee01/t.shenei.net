<?php
/***********************************************************
    [EasyTalk] (C)2009 - 2011 nextsns.com
    This is NOT a freeware, use is subject to license terms

    @Filename ThemeAction.class.php $

    @Author hjoeson $

    @Date 2011-01-09 08:45:20 $
*************************************************************/

class ThemeAction extends Action {

    public function _initialize() {
        if (!$this->admin['user_id'] || $this->admin['isadmin']!=1) {
            $this->redirect('/Login/index');
        }
    }

    public function index() {
        $tModel=D('usertemplates');
        import("@.ORG.Page");
        C('PAGE_NUMBERS',10);

        $count=$tModel->count();
        $p= new Page($count,30);
        $page = $p->show("admin.php?s=/Theme/index/p/");
        $themes = $tModel->order('ut_id')->limit($p->firstRow.','.$p->listRows)->select();

        $this->assign('themes',$themes);
        $this->assign('page',$page);
        $this->assign('position','用户管理 -> 模版管理');
        $this->display();
    }

    public function option() {
        $tModel=D('usertemplates');
        $op=$_GET['op'];
        $id=$_GET['id'];

        if (!$id || !$op) {
            $this->assign('url',SITE_URL.'/admin.php?s=/Theme');
            $this->assign('title','很抱歉，操作有误');
            $this->assign('position','系统跳转');
            $this->display('Common/return');
            exit;
        }
        if ($op=='open') {
            $tModel->where("ut_id='$id'")->setField('isopen',1);
        } else if ($op=='close') {
            $tModel->where("ut_id='$id'")->setField('isopen',0);
        } else if ($op=='del') {
            $tModel->where("ut_id='$id'")->delete();
            $newdir=ET_ROOT.'./Public/attachments/usertemplates/'.$id;
            $this->deleteDir($newdir);
        } else if ($op=='edit') {
            $edit=$tModel->where("ut_id='$id'")->find();
            $this->assign('edit',$edit);
            $this->display('index');
            exit;
        }
        $this->assign('url',SITE_URL.'/admin.php?s=/Theme');
        $this->assign('title','恭喜您，操作成功');
        $this->assign('position','系统跳转');
        $this->display('Common/return');

    }

    public function edit() {
        $tModel=D('usertemplates');
        $edit=$_POST['edit'];
        $id=$_POST['id'];

        if (is_array($edit) && $id) {
            $keys=$vals=array();
            foreach($edit as $key=>$val){
                $keys[]=$key;
                $vals[]=$val;
            }
            $tModel->where("ut_id='$id'")->setField($keys,$vals);
            $this->assign('url',SITE_URL.'/admin.php?s=/Theme');
            $this->assign('title','恭喜您，编辑模版成功了');
            $this->assign('position','系统跳转');
            $this->display('Common/return');
        } else {
            $this->assign('url',SITE_URL.'/admin.php?s=/Theme');
            $this->assign('title','很抱歉，操作有误');
            $this->assign('position','系统跳转');
            $this->display('Common/return');
        }
    }

    public function upload() {
        $tModel=D('usertemplates');
        $zippack=$_FILES['upload'];
        $dir='./Public/attachments/usertemplates/themetemp/';
        if (is_uploaded_file($zippack['tmp_name']) && $zippack["error"]==0) {
            $zipfile=$dir.$zippack["name"];
            move_uploaded_file($zippack['tmp_name'],$zipfile);
            chmod($zipfile,0777);
        }
        import("@.ORG.zip");
        $unzip = new SimpleUnzip();
        $unzip->ReadFile(ET_ROOT.$zipfile);
        if($unzip->Count() == 0 || $unzip->Geterror(0) != 0) {
            $this->assign('url',SITE_URL.'/admin.php?s=/Theme');
            $this->assign('title','zip文件读取出错');
            $this->assign('position','系统跳转');
            $this->display('Common/return');
            exit;
        }
        $filecount = 0;
        foreach($unzip->Entries as $entry) {
            $fp = fopen('./Public/attachments/usertemplates/themetemp/'.$entry->Name, 'w');
            fwrite($fp, $entry->Data);
            fclose($fp);
            $filecount++;
        }
        if(!$filecount) {
            $this->assign('url',SITE_URL.'/admin.php?s=/Theme');
            $this->assign('title','zip文件解压出错');
            $this->assign('position','系统跳转');
            $this->display('Common/return');
            exit;
        }

        $fp=fopen($dir."theme.sql","rb");
        $sqlfile=fread($fp,filesize($dir."theme.sql"));
        fclose($fp);

        $tModel->query($sqlfile);
        $id=mysql_insert_id();
        if ($id) {
            $newdir='./Public/attachments/usertemplates/'.$id;
            mkdir($newdir,0777);
            $files=$this->list_file($dir);
            foreach ($files as $val) {
                if (ereg('theme_',strtolower($val))) {
                    $theme=$val;
                }
                if (ereg('thumb_',strtolower($val))) {
                    $thumb=$val;
                }
            }
            rename($theme,$newdir."/theme_themebg.jpg");
            rename($thumb,$newdir."/thumb_themebg.jpg");
            @unlink($dir.$zippack["name"]);
            @unlink($dir.'theme.sql');
        }
        $this->assign('url',SITE_URL.'/admin.php?s=/Theme');
        $this->assign('title','恭喜您，模板上传成功');
        $this->assign('position','系统跳转');
        $this->display('Common/return');
    }

    private function list_file($dir,$pattern="") {
        $arr=array();
        $dir_handle=opendir($dir);
        if($dir_handle) {
            while(($file=readdir($dir_handle))!==false){
                if($file==='.' || $file==='..') {
                    continue;
                }
                $tmp=realpath($dir.'/'.$file);
                if(is_dir($tmp)){
                    $retArr=list_file($tmp,$pattern);{
                        $arr[]=$retArr;
                    }
                } else {
                    if($pattern==="" || preg_match($pattern,$tmp)) {
                        $arr[]=$tmp;
                    }
                }
            }
            closedir($dir_handle);
        }
        return $arr;
    }

    private function deleteDir($dirName){
        if(!is_dir($dirName)){
            @unlink($dirName);
            return false;
        }
        $handle = @opendir($dirName);
        while(($file = @readdir($handle)) !== false){
            if($file != '.' && $file != '..'){
                $dir = $dirName . '/' . $file;
                is_dir($dir) ? $this->deleteDir($dir) : @unlink($dir);
            }
        }
        closedir($handle);
        return rmdir($dirName);
    }
}
?>