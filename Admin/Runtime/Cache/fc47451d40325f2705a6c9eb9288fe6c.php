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
<script type="text/javascript">setInterval(function(){window.location.href='<?php echo ($url); ?>';}, 1000);</script>
<div class="return">
    <div class="tt"><?php echo ($title); ?></div>
    <a href="<?php echo ($url); ?>">如果您的浏览器没有自动跳转，请点击这里</a>
</div>
</div>
</div>
</body>
</html>