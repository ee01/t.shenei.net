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
<div class="infomation"><b>说明：</b>如果您的服务器不支持邮件发送功能，可以开启本功能。</div><br/>
<h3>邮件配置</h3>
<form action='<?php echo SITE_URL;?>/admin.php?s=/Setting/webset' method="POST">
<table style="margin:5px 0 20px 0">
<tr>
    <td width="150px">通过SMTP发送邮件</td>
    <td width="330px">
    <input type="radio" name="site[mail_mode]" value="0" <?php if($site['mail_mode']['contents']==0){ ?>checked<?php } ?>> 否&nbsp;&nbsp;&nbsp;
    <input type="radio" name="site[mail_mode]" value="1" <?php if($site['mail_mode']['contents']==1){ ?>checked<?php } ?>> 是
    </td>
    <td class="info">● <?php echo ($site['mail_mode']['description']); ?></td>
</tr>
<tr>
    <td width="150px">邮件服务器</td>
    <td width="330px"><input type="text" name="site[smtp_host]" class="txt_input" value="<?php echo ($site['smtp_host']['contents']); ?>"></td>
    <td class="info">● <?php echo ($site['smtp_host']['description']); ?></td>
</tr>
<tr>
    <td>邮件服务器端口</td>
    <td><input type="text" name="site[smtp_port]" class="txt_input" value="<?php echo ($site['smtp_port']['contents']); ?>"></td>
    <td class="info">● <?php echo ($site['smtp_port']['description']); ?></td>
</tr>
<tr>
    <td>登录用户名</td>
    <td><input type="text" name="site[smtp_user]" class="txt_input" value="<?php echo ($site['smtp_user']['contents']); ?>"></td>
    <td class="info">● <?php echo ($site['smtp_user']['description']); ?></td>
</tr>
<tr>
    <td>登录密码</td>
    <td><input type="password" name="site[smtp_pass]" class="txt_input" value="<?php echo ($site['smtp_pass']['contents']); ?>"></td>
    <td class="info">● <?php echo ($site['smtp_pass']['description']); ?></td>
</tr>
</table>
<input type="hidden" name="reurl" value="Setting/mail">
<input type="submit" class="button1 submit" value="保存提交">
</form>
</div>
</div>
</body>
</html>