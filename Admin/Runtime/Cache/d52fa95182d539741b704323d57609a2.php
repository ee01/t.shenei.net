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
<h3>举报信息列表</h3>
<form action='<?php echo SITE_URL;?>/admin.php?s=/Report/delreport' method="POST">
<table style="margin:5px 0 20px 0">
<tr>
    <td width="80px">&nbsp;</td>
    <td width="150px">用户帐号</td>
    <td width="400px" style="text-indent:0px">举报内容</td>
    <td width="150px">举报分类</td>
    <td width="150px">举报时间</td>
</tr>
<?php foreach($content as $val){ ?>
    <tr>
        <td valign="top"><input type="checkbox" name="deljb[]" class="checkbox" value="<?php echo ($val[id]); ?>"></td>
        <td valign="top"><a href="<?php echo SITE_URL;?>/<?php echo ($val[user_name]); ?>" target="_blank"><?php echo ($val[user_name]); ?></a></td>
        <td style="text-indent:0px"><?php echo ($val[reportbody]); ?></td>
        <td valign="top"><?php echo jbtype($val[reporttype]);?></td>
        <td valign="top"><?php echo date('Y-m-d H:i',$val[dateline]);?></td>
    </tr>
<?php } ?>
<tr>
    <td><input type="checkbox" onclick="CheckAll('deljb', 'chkall')" id="chkall" name="chkall" class="checkbox"> 删除?</td>
    <td colspan="4"><input type="submit" class="button1" value="提交删除"></td>
</tr>
</table>
</form>
<div class="page"><?php echo ($page); ?></div>
</div>
</div>
</body>
</html>