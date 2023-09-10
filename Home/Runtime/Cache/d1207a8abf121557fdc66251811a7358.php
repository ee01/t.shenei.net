<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=UTF-8'/>
<title><?php if($subname){echo($subname.'_');} ?><?php echo ($site['sitename']); ?> - <?php echo ($site['subtitle']); ?></title>
<link rel="shortcut icon" href="<?php echo __PUBLIC__;?>/images/favicon.ico" />
<link rel='stylesheet' href='<?php echo __PUBLIC__;?>/wap/style.css' type='text/css'/>
</head>
<body>
<h1><?php echo ($site[sitename]); ?></h1>
<div class="main">
<?php if($showmenu==1){ ?>
<div class="menu">
<a href='<?php echo SITE_URL;?>/Wap/home'>主页</a> |
<a href='<?php echo SITE_URL;?>/Wap/space'>空间</a> |
<a href='<?php echo SITE_URL;?>/Wap/at'>提到我</a> |
<a href='<?php echo SITE_URL;?>/Wap/mycomment'>评论</a> |
<a href='<?php echo SITE_URL;?>/Wap/myfavor'>收藏</a><br/>
<a href='<?php echo SITE_URL;?>/Wap/message'>私信</a> |
<a href='<?php echo SITE_URL;?>/Wap/follow'>关系</a> |
<a href='<?php echo SITE_URL;?>/Wap/sendphoto'>发照片</a> |
<a href='<?php echo SITE_URL;?>/Wap/logout'>退出</a>
</div>
<?php } ?>
<?php if($my['newfollownum']>0 && ACTION_NAME!='follow'){ ?><h6><a href="<?php echo SITE_URL;?>/Wap/follow/tab/2">您新增 <?php echo ($my['newfollownum']); ?> 个听众</a></h6><?php } ?>
<?php if($my['atnum']>0 && ACTION_NAME!='at'){ ?><h6><a href="<?php echo SITE_URL;?>/Wap/at">有 <?php echo ($my['atnum']); ?> 条提到您的广播</a></h6><?php } ?>
<?php if($my['priread']>0 && ACTION_NAME!='message'){ ?><h6><a href="<?php echo SITE_URL;?>/Wap/message">您有 <?php echo ($my['priread']); ?> 条未读私信</a></h6><?php } ?>
<?php if($my['comments']>0 && ACTION_NAME!='mycomment'){ ?><h6><a href="<?php echo SITE_URL;?>/Wap/mycomment">您有 <?php echo ($my['comments']); ?> 条未读评论</a></h6><?php } ?>

<form method='post' action='<?php echo SITE_URL;?>/Wap/dologin' >
<h3>微博帐号<?php if(ET_UC!=TRUE){ ?> / 邮箱地址<?php }else{ ?> / Ucenter帐号<?php } ?>：</h3><p><input type='text' name='loginname' /></p>
<h3>登录密码：</h3><p><input type='password' name='password' /></p>
<p><input type='checkbox' id="rememberMe" name='rememberMe' value='on' checked='checked' /><label for="rememberMe"> 下次自动登录</label></p>
<p><input type='submit' value='登录' /></p>
</form>
<p><?php echo ($site['sitename']); ?> 是一个微博客。</p><p>随时随地发消息</p><p>时时刻刻看朋友</p><p>手机、网页、客户端。</p>
</div>
<div id='ft'>
    <p>微博报时：<?php echo gmdate('m-d H:i',time()+8*3600);?></p>
    <p>Powered by EasyTalk</p>
</div>
</body>
</html>