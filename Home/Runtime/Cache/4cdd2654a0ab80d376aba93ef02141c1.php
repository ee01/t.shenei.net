<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="keywords" content="<?php echo ($keyword); ?><?php echo ($site['seokey']); ?>" />
<meta name="description" content="<?php if($description){ ?><?php echo ($description); ?><?php }else{ ?><?php echo ($site['seodescription']); ?><?php } ?>" />
<title><?php if($subname){echo($subname.'_');} ?><?php echo ($site['sitename']); ?> - <?php echo ($site['subtitle']); ?></title>
<link rel="shortcut icon" href="<?php echo __PUBLIC__;?>/images/favicon.ico" />
<script type="text/javascript">var etuser='{"siteurl":"<?php echo SITE_URL;?>","pubdir":"<?php echo __PUBLIC__;?>","setok":"<?php echo ($setok); ?>","my_uid":"<?php echo ($my[user_id]); ?>","user_name":"<?php echo $user[user_name]?$user[user_name]:$my[user_name];?>","nickname":"<?php echo $user[nickname]?$user[nickname]:$my[nickname];?>","space":"<?php echo ($type); ?>"}';var stalk='<?php echo ($sendtalk); ?>';var shorturl='<?php if($site[shortserver]<=1){ ?><?php echo shortserver($site[shortserver]);?><?php }else{ ?><?php echo ($site[shorturl]); ?><?php } ?>';</script>
<script type="text/javascript" src="<?php echo __PUBLIC__;?>/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo __PUBLIC__;?>/js/common.js"></script>
<script type="text/javascript" src="<?php echo __PUBLIC__;?>/js/extends.js"></script>
<script type="text/javascript" src="<?php echo __PUBLIC__;?>/js/ye_dialog.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo __PUBLIC__;?>/js/highslide/highslide.css" />
<link rel="stylesheet" type="text/css" href="<?php echo __PUBLIC__;?>/images/style.css" />
<!--[if lte IE 6]>
<style type="text/css">
#header .left{filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled='true',sizingMethod='image',src='<?php echo __PUBLIC__;?>/images/logo.png');background:none;cursor:pointer}
#header .topmenubg{filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled='true',sizingMethod='image',src='<?php echo __PUBLIC__;?>/images/topmenu.png');background:none;}
#navbg {filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled='true', sizingMethod='scale',src='<?php echo __PUBLIC__;?>/images/headbg.png');background:none;}
#sidebar .homestabs .menu li .arrHover{filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled=true,sizingMethod=image,src='<?php echo __PUBLIC__;?>/images/sidemenuArr_over.png');background:none;}
#sidebar .homestabs .menu li .arrCurt{filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled=true,sizingMethod=image,src='<?php echo __PUBLIC__;?>/images/sidemenuArr.png');background:none}
#sidebar .sect {filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled=true,sizingMethod=scale, src='<?php echo __PUBLIC__;?>/images/dot.png');background:none;}
.newst {filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled=true,sizingMethod=image,src='<?php echo __PUBLIC__;?>/images/newst.png');background:none;}
</style>
<![endif]-->
<style type="text/css"><?php echo ($usertemp); ?></style>
</head>

<body>
<?php if($my['user_id']){ ?>
<div id="navbg"></div>
<div id="container" class="newlook">
<div id="header">
    <div id="navigation">
        <ul>
            <li <?php if($menu=='pub'){ ?>class="selected"<?php } ?>><a href="<?php echo SITE_URL;?>/Pub">广播大厅</a></li>
            <li <?php if($menu=='hot'){ ?>class="selected"<?php } ?>><a href="<?php echo SITE_URL;?>/Hot">排行榜</a></li>
            <li <?php if($menu=='finder'){ ?>class="selected"<?php } ?>><a href="<?php echo SITE_URL;?>/Find">找朋友</a></li>
            <li <?php if($menu=='invite'){ ?>class="selected"<?php } ?>><a href="<?php echo SITE_URL;?>/Find/invite">邀请</a></li>
            <?php if ($site[googlemapopen]==1 || $site[widgetopen]==1 || $site[wapopen]==1){ ?>
            <li id="plugins"><a class="nohover" href="javascript:void(0);">工具<span class="arr_d"><em class="b1">&nbsp;</em><em class="b2">&nbsp;</em><em class="b3">&nbsp;</em></span></a>
            <div class="subNav" style="display:none;">
            <?php if ($site[googlemapopen]==1){ ?><p><a href="<?php echo SITE_URL;?>/Plugins/map">地图微博</a></p><?php } ?>
            <?php if ($site[widgetopen]==1){ ?><p><a href="<?php echo SITE_URL;?>/Plugins">博客挂件</a></p><?php } ?>
            <?php if ($site[wapopen]==1){ ?><p><a href="<?php echo ET_URL;?>/m">手机WAP</a></p><?php } ?>
            </div>
            </li>
            <?php } ?>
            <li class="fright"><a href="<?php echo SITE_URL;?>/logout">退出</a></li>
            <?php if($my['isadmin']==1){ ?><li class="fright"><a href="<?php echo ET_URL;?>/admin.php">后台管理</a></li><?php } ?>
            <li class="fright <?php if($type=='message'){ ?>selected<?php } ?>"><a href="<?php echo SITE_URL;?>/Message/inbox">私信</a> | </li>
            <li class="fright <?php if($menu=='theme'){ ?>selected<?php } ?>"><a href="<?php echo SITE_URL;?>/Setting/theme">模板</a></li>
            <li class="fright <?php if($menu=='setting'){ ?>selected<?php } ?>"><a href="<?php echo SITE_URL;?>/Setting">设置</a></li>
            <li class="fright <?php if($menu=='profile'){ ?>selected<?php } ?>"><a href="<?php echo SITE_URL;?>/<?php echo ($my[user_name]); ?>/profile"><?php echo ($my[nickname]); ?><?php if($my['userlock']==2){ ?><b>[禁言]</b><?php } ?></a></li>
        </ul>
    </div>
    <?php if($site['loginindex']=='home'){ ?><a href="<?php echo SITE_URL;?>/<?php echo ($my['user_name']); ?>">
    <?php }else{ ?><a href="<?php echo SITE_URL;?>/Pub">
    <?php } ?><div class="left"></div></a>
    <?php if($my[priread]>0 || $my[comments]>0 || $my[newfollownum]>0 || $my[atnum]>0){ ?>
        <div class="tipmsg">
        <div class="tips">
        <?php if($my[priread]>0){ ?><p id="t_msg">您有<?php echo ($my[priread]); ?>条未读私信，<a href="<?php echo SITE_URL;?>/Message/inbox">查看私信</a></p><?php } ?>
        <?php if($my[comments]>0){ ?><p id="t_comment">您有<?php echo ($my[comments]); ?>条未读评论，<a href="<?php echo SITE_URL;?>/Comments">查看评论</a></p><?php } ?>
        <?php if($my[newfollownum]>0){ ?><p id="t_follow">有<?php echo ($my[newfollownum]); ?>个用户收听了您，<a href="<?php echo SITE_URL;?>/<?php echo ($my[user_name]); ?>/follower">查看听众</a></p><?php } ?>
        <?php if($my[atnum]>0){ ?><p id="t_at">有<?php echo ($my[atnum]); ?>条提到您的广播，<a href="<?php echo SITE_URL;?>/<?php echo ($my[user_name]); ?>/at">查看广播</a></p><?php } ?>
        </div>
        <div class="close"><a href="javascript:void(0)" onclick="$('.tipmsg').remove();">x</a></div>
        </div>
    <?php } ?>
    <div class="topmenubg"></div>
    <div class="topmenu">
        <ul>
            <li <?php if($menu=='home'){ ?>class="selected"<?php } ?>><a href="<?php echo SITE_URL;?>/<?php echo ($my['user_name']); ?>">我的首页</a> | </li>
            <li <?php if($menu=='profile'){ ?>class="selected"<?php } ?>><a href="<?php echo SITE_URL;?>/<?php echo ($my[user_name]); ?>/profile">我的微博</a> | </li>
            <li <?php if($menu=='follow'){ ?>class="selected"<?php } ?>><a href="<?php echo SITE_URL;?>/<?php echo ($my[user_name]); ?>/following">关系</a></li>
            <li>
                <div id="searchr">
                    <select id="commonsearch" class="select"><option value="talk">广播</option><option value="user">用户</option></select>
                    <input type="text" id="searchr-input" name="q" value="<?php if(!$_GET['q']){ ?>请输入关键字<?php }else{ ?><?php echo ($_GET['q']); ?><?php } ?>" onfocus="this.value=''" onkeydown= "if(event.keyCode==13){dosearch()}"/>
                    <input type="button" id="searchr-submit" value="搜 索" onclick="dosearch();" />
                </div>
            </li>
        </ul>
    </div>
</div>
<div class="ad1"><?php echo stripslashes($site['ad1']);?></div>
<?php }else{ ?>
<div id="container" class="newlook">
<div id="header2">
    <?php if($site['loginindex']=='home'){ ?><a href="<?php echo SITE_URL;?>/<?php echo ($my['user_name']); ?>"><?php }else{ ?><a href="<?php echo SITE_URL;?>/Pub"><?php } ?><div class="left"></div></a>
</div>
<?php } ?>
<div class="clearline"></div>
<div id="register">
    <div class="indexh" style="margin-bottom:20px">
        <div class="tabon">快速注册</div>
        <div class="taboff"><a href="<?php echo SITE_URL;?>/login">登陆微博</a></div>
        <div class="taboff"><a href="<?php echo SITE_URL;?>/reset">忘记密码</a></div>
    </div>
    <table border="0" style="width:90%;margin-left:40px">
    <tr><td valign="top">
    <h3 class="tt">欢迎您加入<?php echo ($site[sitename]); ?>，请完整填写以下信息进行注册。</h3>
    <?php if($user[user_id]){ ?>
        <div class="invite">
            <div class="fleft"><img src="<?php echo sethead($user[user_head]);?>"></div>
            <div class="fleft" style="margin-left:10px"><p><b><?php echo ($user[nickname]); ?></b><small>(@<?php echo ($user[user_name]); ?>)</small></p><p> 邀请您加入<?php echo ($site[sitename]); ?>，注册后你们将互相收听！</p></div>
            <div class="clearline"></div>
        </div>
    <?php } ?>
    <?php if($site['closereg']==3){ ?>
        <div class="invite">管理员开启了邀请注册，您必须正确输入邀请码才能注册！</div>
    <?php } ?>
    <form method="post" action="##" class="lf">
    <table class="regtb">
        <?php if($site['closereg']==3){ ?>
        <tr height="50px">
            <th><label class="label_input" for="invitecode">邀请码</label></th>
            <td width="210px"><input tabindex="1" type="text" id="invitecode" name="invitecode" class="input_text" value="" style="ime-mode:disabled"/></td>
            <td></td>
        </tr>
        <?php } ?>
        <tr height="50px">
            <th><label class="label_input" for="username">用户帐号</label></th>
            <td width="210px"><input tabindex="2" type="text" id="username" name="username" class="input_text" value="" maxlength="12"/></td>
            <td>帐户名长度最多 6 个汉字或 12 个字符</td>
        </tr>
        <tr height="30px">
            <td></td>
            <td colspan="2"><span class="grey">您的网址：<?php echo SITE_URL;?>/<span id="wbadd"></span></span></td>
        </tr>
        <tr height="50px">
            <th><label class="label_input" for="mailadres">电子邮箱</label></th>
            <td><input tabindex="4" type="text" id="mailadres" name="mailadres" class="input_text" value="" /></td>
            <td>电子邮箱是找回密码的重要途径，请正确填写</td>
        </tr>
        <tr height="50px">
            <th><label class="label_input" for="password1">注册密码</label></th>
            <td><input tabindex="5" type="password" id="password1" name="password1" class="input_text" value="" maxlength="20" style="ime-mode:disabled" onpaste="return false;"/></td>
            <td>密码长度4-20位，字母区分大小写</td>
        </tr>
        <tr height="50px">
            <th><label class="label_input" for="password2">确认密码</label></th>
            <td><input tabindex="6" type="password" id="password2" name="password2" class="input_text" value="" maxlength="20" style="ime-mode:disabled" onpaste="return false;"/></td>
            <td>请再次输入一次注册密码，以确保正确</td>
        </tr>
        <tr height="50px">
            <td></td>
            <td colspan="2"><?php if($user[user_id]){ ?><input type="hidden" id="inviteuid" value="<?php echo ($user[user_id]); ?>" /><?php } ?>
            <input tabindex="7" type="button" class="button1" value="立即注册" onclick="check_register();"/></td>
        </tr>
    </table>
    </form>
    </td></tr>
    </table>
</div>
<script type="text/javascript">
$("#username").keyup(function(){
    $('#username').val($('#username').val().replace(/\s/ig,""));
    $('#wbadd').html($('#username').val());
    $('#username').val($('#username').val().slice(0,12));
    $('#wbadd').html($('#username').val().slice(0,12));
});
$("#mailadres").keyup(function() {$('#mailadres').val($('#mailadres').val().replace(/\s/ig,""));});
$("#password1").keyup(function() {$('#password1').val($('#password1').val().replace(/\s/ig,""));});
$("#password2").keyup(function() {$('#password2').val($('#password2').val().replace(/\s/ig,""));});
</script>
<?php if($my[user_id]){ ?><a id="reportbutton" href="javascript:void(0)" onclick="reportbox()"></a><?php } ?>
<?php if($my['user_id']){ ?><div class="ad2"><?php echo stripslashes($site['ad2']);?></div><?php } ?>
<div class="bottomLinks">
    <div class="bL_List">
        <div class="bL_info">  
        <h4>找找感兴趣的人</h4>
        <ul>
            <li class="MIB_linkar"><a href="<?php echo SITE_URL;?>/Find">找朋友</a></li>
            <li class="MIB_linkar"><a href="<?php echo SITE_URL;?>/Hot">达人排行榜</a></li>
            <li class="MIB_linkar"><a href="<?php echo SITE_URL;?>/Hot?c=<?php echo getcity($my[live_city],'province');?>">同城达人榜</a></li>
            <li class="MIB_linkar"><a href="<?php echo SITE_URL;?>/Find/invite">邀请好友加入</a></li>
        </ul>
        </div>
        <div class="bL_info">  
        <h4>大家正在说什么</h4>
        <ul>
            <li class="MIB_linkar"><a href="<?php echo SITE_URL;?>/Pub">广播大厅</a></li>
            <li class="MIB_linkar"><a href="<?php echo SITE_URL;?>/Pub?t=hot">热门广播</a></li>
            <li class="MIB_linkar"><a href="<?php echo SITE_URL;?>/Pub?t=city&c=<?php echo getcity($my[live_city],'city');?>">同城广播</a></li>
            <li class="MIB_linkar"><a href="<?php echo SITE_URL;?>/Topic">热门话题榜</a></li>
        </ul>
        </div>
        <div class="bL_info bL_io3">  
        <h4>微博更多玩法</h4>
        <ul>
            <li class="MIB_linkar"><a href="<?php echo ET_URL;?>/m">手机登陆</a></li>
            <li class="MIB_linkar"><a href="##">短信更新</a></li>
            <li class="MIB_linkar"><a href="##">下载客户端</a></li>
            <li class="MIB_linkar"><a href="<?php echo SITE_URL;?>/Setting/theme">设置个性模版</a></li>
        </ul>
        </div>
        <div class="bL_info bL_io4">  
        <h4>认证&合作</h4>
        <ul>
            <li class="MIB_linkar"><a href="<?php echo SITE_URL;?>/Index/vip">微博认证</a></li>
            <li class="MIB_linkar"><a href="<?php echo SITE_URL;?>/Index/about">关于我们</a></li>
            <li class="MIB_linkar"><a href="<?php echo SITE_URL;?>/Index/about">加入我们</a></li>
            <li class="MIB_linkar"><a href="<?php echo SITE_URL;?>/Index/faq">新手帮助</a></li>
        </ul>
        </div>
    </div>
</div>
<div id="footer">
    <a href="<?php echo ET_URL;?>"><?php echo ($site['sitename']); ?></a>&nbsp;<a href="http://www.miibeian.gov.cn" target="_blank"><?php echo ($site[miibeian]); ?></a>&nbsp;<?php echo stripslashes($site["foottongji"]);?><br/>
    Powered by <a href="http://www.nextsns.com" target="_blank">EasyTalk <?php echo ET_VESION;?></a>.&copy; 2009-2011 <a href="http://www.nextsns.com" target="_blank">Nextsns.com</a>
</div>
</div>
<div class="gotop"><button onclick="indextop();" title="返回顶部"><span>返回顶部</span></button></div>
</body>
</html>