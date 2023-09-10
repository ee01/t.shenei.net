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
<h3>缓存时间设置</h3>
<form action='<?php echo SITE_URL;?>/admin.php?s=/Setting/webset' method="POST">
<table style="margin:5px 0 20px 0">
<tr>
    <td width="150px">热门话题缓存时间</td>
    <td width="330px"><input type="text" name="site[hottopic_cache_time]" class="txt_input" value="<?php echo ($site['hottopic_cache_time']['contents']); ?>"></td>
    <td class="info">● <?php echo ($site['hottopic_cache_time']['description']); ?></td>
</tr>
<tr>
    <td>推荐用户缓存时间</td>
    <td><input type="text" name="site[hotuser_cache_time]" class="txt_input" value="<?php echo ($site['hotuser_cache_time']['contents']); ?>"></td>
    <td class="info">● <?php echo ($site['hotuser_cache_time']['description']); ?></td>
</tr>
<tr>
    <td>用户听众缓存时间</td>
    <td><input type="text" name="site[userfollow_cache_time]" class="txt_input" value="<?php echo ($site['userfollow_cache_time']['contents']); ?>"></td>
    <td class="info">● <?php echo ($site['userfollow_cache_time']['description']); ?></td>
</tr>
</table>
<h3>缓存方式设置</h3>
<table style="margin:5px 0 20px 0">
<tr>
    <td width="150px">请选择缓存方式</td>
    <td width="330px"><input type="radio" name="site[cachetype]" value="file" <?php if($site['cachetype']['contents']=='file'){ ?>checked<?php } ?>> 文件方式&nbsp;&nbsp;&nbsp;
    <input type="radio" name="site[cachetype]" value="memcache" <?php if($site['cachetype']['contents']=='memcache'){ ?>checked<?php } ?>> Memcache</td>
    <td class="info">● <?php echo ($site['cachetype']['description']); ?></td>
</tr>
<tr>
    <td>Memcache服务器IP</td>
    <td><input type="text" name="site[memhost]" class="txt_input" value="<?php echo ($site['memhost']['contents']); ?>"></td>
    <td class="info">● <?php echo ($site['memhost']['description']); ?></td>
</tr>
</table>
<input type="hidden" name="reurl" value="Cache">
<input type="submit" class="button1 submit" value="保存提交">
</form>
<h3>缓存项目管理</h3>
<form action='<?php echo SITE_URL;?>/admin.php?s=/Cache/clearcache' method="POST">
<table style="margin:5px 0 20px 0">
<tr>
    <td width="60px">&nbsp;</td>
    <td width="200px">缓存类型</td>
    <td>说明</td>
</tr>
<tr>
    <td><input type="checkbox" name="clearcache[]" value="setting" class="checkbox" checked="checked"></td>
    <td>网站设置缓存</td>
    <td class="info">● 该缓存保存的是网站的配置信息</td>
</tr>
<tr>
    <td><input type="checkbox" name="clearcache[]" value="dltheme" class="checkbox" checked="checked"></td>
    <td>用户模版临时文件</td>
    <td class="info">● 该目录下的文件为用户下载模板的临时文件夹，建议时常清理</td>
</tr>
<tr>
    <td><input type="checkbox" name="clearcache[]" value="webcache" class="checkbox"></td>
    <td>网站数据缓存</td>
    <td class="info">● 该目录下的文件为网站运行是生成的缓存文件，不需要定时清理</td>
</tr>
<tr>
    <td><input type="checkbox" name="clearcache[]" value="tpcache" class="checkbox"></td>
    <td>网站模版缓存</td>
    <td class="info">● 如果发现网站显示不正常或者报错，请清理该缓存</td>
</tr>
</table>
<input type="submit" class="button1 submit" value="提交清除">
</form>
</div>
</div>
</body>
</html>