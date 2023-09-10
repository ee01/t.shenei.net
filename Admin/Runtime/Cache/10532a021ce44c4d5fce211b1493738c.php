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
<div class="infomation"><b>说明：</b>该功能是检查您服务器中以下目录是否可写，如不可写，您需要进入服务器将以下目录权限设置为0777。</div><br/>
<h3>目录检查</h3>
<table style="margin:5px 0 20px 0">
<tr>
    <td width="70%"><b>目录名</b></td>
    <td><b>是否可写</b></td>
</tr>
<?php foreach($dirs as $val){ ?>
<tr>
    <td><?php echo ($val['dir']); ?></td>
    <td style="text-indent:30px"><img src="<?php echo __PUBLIC__;?>/admin/dirwrite<?php echo ($val['iswrite']); ?>.png"></td>
</tr>
<?php } ?>
</table>
</div>
</div>
</body>
</html>