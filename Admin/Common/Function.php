<?php
/***********************************************************
    [EasyTalk] (C)2009 - 2011 nextsns.com
    This is NOT a freeware, use is subject to license terms

    @Filename Function.php $

    @Author hjoeson $

    @Date 2011-01-09 08:45:20 $
*************************************************************/

function sizecount($filesize) {
	if($filesize >= 1073741824) {
		$filesize = round($filesize / 1073741824 * 100) / 100 . ' GB';
	} elseif($filesize >= 1048576) {
		$filesize = round($filesize / 1048576 * 100) / 100 . ' MB';
	} elseif($filesize >= 1024) {
		$filesize = round($filesize / 1024 * 100) / 100 . ' KB';
	} else {
		$filesize = $filesize . ' Bytes';
	}
	return $filesize;
}

function jbtype($id) {
    if ($id==1) {
        return '涉及黄色和暴力';
    } else if ($id==2) {
        return '政治反动';
    } else if ($id==3) {
        return '内容侵权';
    } else if ($id==4) {
        return '其他不良信息';
    }
}
function sidedef($name) {
    if ($name=='hottopic') {
        return '热门话题';
    } else if ($name=='hotuser') {
        return '人气用户推荐';
    } else if ($name=='bangnormal') {
        return '人气之星榜';
    } else if ($name=='bangvip') {
        return '认证名人榜';
    } else if ($name=='userfollower') {
        return 'TA的听众';
    } else if ($name=='userfollowing') {
        return 'TA收听的';
    } else {
        return '自定义';
    }
}
?>