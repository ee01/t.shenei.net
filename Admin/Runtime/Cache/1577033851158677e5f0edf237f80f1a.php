<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<title>EasyTalk Administrator's Control Panel</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta content="H.Joeson" name="Copyright" />
<link rel="stylesheet" href="<?php echo __PUBLIC__;?>/admin/style.css" type="text/css" media="all" />
<script src="<?php echo __PUBLIC__;?>/js/jquery.js" type="text/javascript"></script>
<script src="<?php echo __PUBLIC__;?>/admin/admin.js" type="text/javascript"></script>
</head>

<body>
<div id="bodymain">
<div class="title"><?php echo ($position); ?></div>
<div class="content">
<h3>搜索已有话题</h3>
<form action='<?php echo SITE_URL;?>/admin.php?s=/Topic/index' method="POST">
<table style="margin:5px 0 20px 0">
<tr>
<td>输入话题名称：</td>
<td>
    <input type="text" name="topicname" value="<?php echo ($topicname); ?>" class="txt_input">
</td>
<tr>
    <td>&nbsp;</td>
    <td><input type="submit" class="button1" value="提交搜索"></td>
</tr>
</table>
</form>
<h3>话题列表<?php if($topicname){ ?>&nbsp;&nbsp;(<a href="<?php echo SITE_URL;?>/admin.php?s=/Topic">显示全部</a>)<?php } ?></h3>
<form action='<?php echo SITE_URL;?>/admin.php?s=/Topic/deltopic' method="POST">
<table style="margin:5px 0 20px 0">
<tr>
    <td width="90px">&nbsp;</td>
    <td width="250px">话题名称</td>
    <td width="100px">
    <?php if($order!=1){ ?><a href="<?php echo SITE_URL;?>/admin.php?s=/Topic&order=1">话题数目↓</a><?php }else{ ?>
    <a href="<?php echo SITE_URL;?>/admin.php?s=/Topic&order=2">话题数目↑</a><?php } ?>
    </td>
    <td width="100px">
    <?php if($order!=3){ ?><a href="<?php echo SITE_URL;?>/admin.php?s=/Topic&order=3">关注人数↓</a><?php }else{ ?>
    <a href="<?php echo SITE_URL;?>/admin.php?s=/Topic&order=4">关注人数↑</a><?php } ?>
    </td>
    <td width="100px">
    <?php if($order!=5){ ?><a href="<?php echo SITE_URL;?>/admin.php?s=/Topic&order=5">推荐↓</a><?php }else{ ?>
    <a href="<?php echo SITE_URL;?>/admin.php?s=/Topic&order=6">推荐↑</a><?php } ?>
    </td>
    <td width="250px">
    <?php if($order!=7){ ?><a href="<?php echo SITE_URL;?>/admin.php?s=/Topic&order=7">话题描述↓</a><?php }else{ ?>
    <a href="<?php echo SITE_URL;?>/admin.php?s=/Topic&order=8">话题描述↑</a><?php } ?>
    </td>
    <td width="200px">← 点击标题排序查看</td>
</tr>
<?php foreach($content as $val){ ?>
    <tr>
        <td valign="top"><input type="checkbox" name="deltp[]" class="checkbox" value="<?php echo ($val[id]); ?>"></td>
        <td valign="top"><?php echo ($val[topicname]); ?></td>
        <td valign="top"><?php echo ($val[topictimes]); ?></td>
        <td valign="top"><?php echo ($val[follownum]); ?></td>
        <td valign="top"><?php echo ($val[tuijian]==1?'<font color="red">是</font>':'否');?></td>
        <td valign="top"><input type="text" style="width:150px" id="info_<?php echo ($val[id]); ?>" value="<?php echo ($val[info]=='0' || !$val[info])?'':$val[info];?>"><input type="button" onclick="topicinfo(<?php echo ($val[id]); ?>)" value="提交"></td>
        <td valign="top"><a href="<?php echo SITE_URL;?>/index.php?s=/k/<?php echo ($val[topicname]); ?>" target="_blank">查看话题</a>&nbsp;&nbsp;
        <?php if($val[tuijian]==0){ ?>
        <a href="<?php echo SITE_URL;?>/admin.php?s=/Topic/tuijian&id=<?php echo ($val[id]); ?>">推荐话题</a>
        <?php }else{ ?>
        <a href="<?php echo SITE_URL;?>/admin.php?s=/Topic/deltuijian&id=<?php echo ($val[id]); ?>">取消推荐</a>
        <?php } ?>
        </td>
    </tr>
<?php } ?>
<tr>
    <td><input type="checkbox" onclick="CheckAll('deltp', 'chkall')" id="chkall" name="chkall" class="checkbox"> 删除?</td>
    <td colspan="5"><input type="submit" class="button1" value="提交删除"></td>
</tr>
</table>
</form>
<div class="page"><?php echo ($page); ?></div>
</div>
</div>
</body>
</html>