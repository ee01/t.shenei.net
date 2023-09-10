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
<?php if(!$my[user_id]){ ?>
<div id="homelogin">
<div class="main">
    <div class='left'>
    <p><h2>Hi！这是“<?php echo ($user['nickname']); ?>”的生活点滴。</h2></p>
    <p><?php echo ($site['sitename']); ?>称之微博也好，便签也好，这里记录的这些小声音都会成为难忘的记忆。在这里，你可以通过手机、网页等随时随地发消息，时时刻刻看朋友。关注<?php echo ($user['nickname']); ?>的最新消息。</p>
    </div>
    <div class='right'>
    <a href="<?php echo SITE_URL;?>/register/<?php echo ($user['user_name']); ?>"><img src="<?php echo __PUBLIC__;?>/images/button-register.gif" alt="注册"></a><br/>有帐号了，请<a href="<?php echo SITE_URL;?>/login">点击这里登陆</a>
    </div>
</div>
</div>
<?php } ?>

<table id="columns"><tr>
<td id="main">
    <div id="info">
    <div id="avatar"><img alt="<?php echo ($user['nickname']); ?>" src="<?php echo sethead($user['user_head']);?>"/></div>
    <div id="panel">
        <div class="prohead">
            <span class="nickname <?php echo setvip($user[user_auth]);?>"><?php echo ($user['nickname']); ?></span><span class="at">(@<?php echo ($user['user_name']); ?>)</span>
            <?php if($user['userlock']==1){ ?>
                <span class="uofflineico">已被锁定</span>
            <?php }else if($user['userlock']==2){ ?>
                <span class="uofflineico">已被禁言</span>
            <?php }else{ ?>
                <?php if(time()-$user[last_login]<=600){ ?>
                    <?php if($user['isadmin']>0){ ?>
                    <span class="adminico">管理员在线</span>
                    <?php }else{ ?>
                    <span class="uonlineico">用户在线</span>
                    <?php } ?>
                <?php }else{ ?>
                    <span class="uofflineico">用户离线</span>
                <?php } ?>
            <?php } ?>
            <div class="clearline"></div>
            <p><a href="<?php echo SITE_URL;?>/<?php echo ($user['user_name']); ?>"><?php echo SITE_URL;?>/<?php echo ($user['user_name']); ?></a></p>
        </div>
        <p class="state">
            <?php if($user[user_id]==$my[user_id]){ ?>
            <a href="<?php echo SITE_URL;?>/<?php echo ($user[user_name]); ?>/profile">广播 <b><?php echo ($user[msg_num]); ?></b> 条</a>&nbsp;&nbsp;|&nbsp;&nbsp;
            <?php }else{ ?>
            <a href="<?php echo SITE_URL;?>/<?php echo ($user[user_name]); ?>">广播 <b><?php echo ($user[msg_num]); ?></b> 条</a>&nbsp;&nbsp;|&nbsp;&nbsp;
            <?php } ?>
            <a href="<?php echo SITE_URL;?>/<?php echo ($user[user_name]); ?>/following">收听 <b><?php echo ($user[follow_num]); ?></b> 人</a>&nbsp;&nbsp;|&nbsp;&nbsp;
            <a href="<?php echo SITE_URL;?>/<?php echo ($user[user_name]); ?>/follower">听众 <b><?php echo ($user[followme_num]); ?></b> 人</a>
        </p>
        <?php if($user[user_id]!=$my[user_id] && $my[user_id]){ ?>
        <p class="actions">
            <span id='followsp_<?php echo ($user[user_name]); ?>'>
                <?php if($isfriend[$user[user_id]]==1){ ?>
                <span class="followbtn"><img src="<?php echo __PUBLIC__;?>/images/fico2.gif"> 已收听&nbsp;|&nbsp;<a href="javascript:void(0)" onclick="followop('delfollow/user_name/<?php echo ($user[user_name]); ?>','确认要解除收听 <?php echo ($user['nickname']); ?> 吗？','jc','<?php echo ($user[user_name]); ?>','<?php echo ($user['nickname']); ?>','<?php echo $isfriend[$user[user_id]];?>')">取消</a></span>
                <?php }else if ($isfriend[$user[user_id]]==3){ ?>
                <span class="followbtn"><img src="<?php echo __PUBLIC__;?>/images/fico.gif"> 互相收听&nbsp;|&nbsp;<a href="javascript:void(0)" onclick="followop('delfollow/user_name/<?php echo ($user[user_name]); ?>','确认要解除收听 <?php echo ($user['nickname']); ?> 吗？','jc','<?php echo ($user[user_name]); ?>','<?php echo ($user['nickname']); ?>','<?php echo $isfriend[$user[user_id]];?>')">取消</a></span>
                <?php }else{ ?>
                <a class="bh" onclick="followop('addfollow/user_name/<?php echo ($user[user_name]); ?>','','gz','<?php echo ($user[user_name]); ?>','<?php echo ($user['nickname']); ?>','<?php echo $isfriend[$user[user_id]];?>')">收听一下</a>
                <?php } ?>
            </span>
            <span class="others"><a class="bl" onclick="atbox('<?php echo ($user[nickname]); ?>')">@TA</a><a class="bl" onclick="sendprimsgbox('<?php echo ($user[user_name]); ?>')">发私信</a></span>
            <span class="clearline"></span>
        </p>
        <?php } ?>
    </div>
</div>
<div class="clearline"></div>
    <div class="contenter">
        <div class="title">
        <h3 class="fleft"><?php echo ($user[nickname]); ?>说</h3>
        <div class="fright" style="margin-top:10px">
            查看类型：
            <select id="lookmore">
            <option value="a">所有广播</option>
            <option value="p">图片广播</option>
            <option value="m">媒体广播</option>
            <option value="o">原创广播</option>
            <option value="r">转播广播</option>
            </select>
        </div>
        </div>
        <div id="stream" class="message">
            <ol class="wa">
            <?php if(count($content)>0){ ?>
                <?php foreach($content as $val){echo $ctent->loadoneli($val);} ?>
            <?php }else{ ?>
                <li class="unlight" id="nonemsg">这里还没有任何广播</li>
            <?php } ?>
            </ol>
        </div>
    </div>
</td>
<td id="sidebar" rowspan="2"><div class="contenter">
    <div class="sect first-sect">
        <h2>个人资料</h2>
        <?php if($user[user_gender]){ ?><?php echo ($user[user_gender]); ?>，<?php } ?>
        <?php if($user[live_city]){ ?><?php echo ($user[live_city]); ?><?php } ?>
        <p class="userurl">介绍：<?php echo $ctent->ubb($user[user_info]?$user[user_info]:'这家伙很懒，什么都没有写！');?></p>
        <?php if($user[user_auth]==1){ ?>
        <div class="userauth">
            <div class="bg"></div>
            <div class="body">
            <p><img src="<?php echo __PUBLIC__;?>/images/viphome.png" /></p>
            <p><?php echo ($user[auth_info]); ?></p>
            </div>
        </div>
        <?php } ?>
    </div>
    
    <?php if($usertopic){ ?>
    <div class="sect">
        <h2>关注的话题<em>(<?php echo count($usertopic);?>)</em></h2>
        <ul class="ulist">
        <?php foreach($usertopic as $val){ ?>
        <li><a href="<?php echo SITE_URL;?>/k/<?php echo ($val['topic']); ?>"><?php echo ($val['topic']); ?></a></li>
        <?php } ?>
        </ul>
    </div>
    <?php } ?>

    <!-- 用户侧边 -->
    <?php echo ($userside); ?>
</div></td>
</tr>
<tr>
<td height="36px">
    <div id="indexpage" class="page"><?php echo ($page); ?></div>
</td>
</tr>
</table>
<script type="text/javascript">$("#lookmore").val('<?php echo ($t); ?>');</script>
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