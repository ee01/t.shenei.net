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
<table border="0" width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<td valign="top" width="70%" style="padding-right:20px">
            <h3>系统信息</h3>
            <table border="0" width="100%">
            <tr>
                <td width="150px">EasyTalk版本</td>
                <td>EasyTalk <?php echo ET_VESION;?> Release <?php echo ET_RELEASE;?>&nbsp;&nbsp;<a href="http://www.nextsns.com" target="_blank">[查看最新版本]</a></td>
            </tr>
            <tr>
                <td>操作系统及PHP</td>
                <td><?php echo ($serverinfo); ?></td>
            </tr>
            <tr>
                <td>Mysql版本</td>
                <td><?php echo ($dbversion); ?></td>
            </tr>
            <tr>
                <td>数据库尺寸</td>
                <td><?php echo ($dbsize); ?></td>
            </tr>
            </table>
            <br/>
            <h3>全站统计</h3>
            <table border="0" width="100%">
            <tr>
                <td width="150px">总注册人数</td>
                <td><?php echo intval($tjdata['ppcount']);?> 人</td>
            </tr>
            <tr>
                <td>注册人数</td>
                <td>今日注册：<?php echo intval($tjdata['tdreg']);?> 人&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;昨日注册：<?php echo intval($tjdata['ytdreg']);?> 人</td>
            </tr>
            <tr>
                <td width="150px">活跃人数</td>
                <td>今日活跃：<?php echo intval($tjdata['tdlogin']);?> 人&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;昨日活跃：<?php echo intval($tjdata['ytdlogin']);?> 人</td>
            </tr>
            </table>
            <br/>
            <h3>相关信息</h3>
            <iframe src="http://www.nextsns.com/et/etadmin.htm" width="100%" height="300px" frameborder="0" scrolling="no"></iframe>
        </td>
		<td valign="top">
            <h3>作者微博</h3>
            <iframe src="http://www.nextsns.com/et/Widget?name=hjoeson&type=1&width=100%&height=470px" width="100%" height="470px" frameborder="0" scrolling="no"></iframe>
        </td>
	</tr>
</table>
</div>
</div>
</body>
</html>