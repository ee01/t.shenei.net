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
<h3>网站设置</h3>
<form action='<?php echo SITE_URL;?>/admin.php?s=/Setting/webset' method="POST">
<table style="margin:5px 0 20px 0;line-height:250%">
<tr>
    <td width="150px">网站名称</td>
    <td width="330px"><input type="text" name="site[sitename]" class="txt_input" value="<?php echo ($site['sitename']['contents']); ?>"></td>
    <td class="info">● <?php echo ($site['sitename']['description']); ?></td>
</tr>
<tr>
    <td>网站副标题</td>
    <td><input type="text" name="site[subtitle]" class="txt_input" value="<?php echo ($site['subtitle']['contents']); ?>"></td>
    <td class="info">● <?php echo ($site['subtitle']['description']); ?></td>
</tr>
<tr>
    <td>网站备案号</td>
    <td><input type="text" name="site[miibeian]" class="txt_input" value="<?php echo ($site['miibeian']['contents']); ?>"></td>
    <td class="info">● <?php echo ($site['miibeian']['description']); ?></td>
</tr>
<tr>
    <td>网站关键词</td>
    <td><input type="text" name="site[seokey]" class="txt_input" value="<?php echo ($site['seokey']['contents']); ?>"></td>
    <td class="info">● <?php echo ($site['seokey']['description']); ?></td>
</tr>
<tr>
    <td>网站描述</td>
    <td><input type="text" name="site[seodescription]" class="txt_input" value="<?php echo ($site['seodescription']['contents']); ?>"></td>
    <td class="info">● <?php echo ($site['seodescription']['description']); ?></td>
</tr>
<tr>
    <td>客服邮箱</td>
    <td><input type="text" name="site[servicemail]" class="txt_input" value="<?php echo ($site['servicemail']['contents']); ?>"></td>
    <td class="info">● <?php echo ($site['servicemail']['description']); ?></td>
</tr>
<tr>
    <td>邀请用户说明</td>
    <td><input type="text" name="site[inviteword]" class="txt_input" value="<?php echo ($site['inviteword']['contents']); ?>"></td>
    <td class="info">● <?php echo ($site['inviteword']['description']); ?></td>
</tr>
<tr>
    <td>注册欢迎私信</td>
    <td><input type="text" name="site[welcomemsg]" class="txt_input" value="<?php echo ($site['welcomemsg']['contents']); ?>" maxlength="140"></td>
    <td class="info">● <?php echo ($site['welcomemsg']['description']); ?></span></td>
</tr>
<tr>
    <td>添加统计代码</td>
    <td><textarea name="site[foottongji]" class="txt_input" style="height:60px;font-size:12px"><?php echo stripslashes($site['foottongji']['contents']);?></textarea></td>
    <td class="info">● <?php echo ($site['foottongji']['description']); ?></td>
</tr>
</table>

<input type="hidden" name="reurl" value="Setting/index">
<input type="submit" class="button1 submit" value="保存提交">
</form>
</div>
</div>
</body>
</html>