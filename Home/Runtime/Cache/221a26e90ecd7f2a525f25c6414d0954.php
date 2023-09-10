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
<table id="columns">
<tr>
<td id="main">
    <div id="infohead">
        <div class="hometip">来，说说你在做什么，想什么：</div>
        <textarea id="contentbox" class="input_text headtextarea" onkeydown="javascript:return ctrlEnter_st(event);"><?php if(!$my[lastconttime]){ ?>#新人报道#大家好，我是新加入的成员@<?php echo ($my[user_name]); ?> 欢迎大家来收听！<?php } ?></textarea>
        <div class="sendbox">
        <div id="uploadbox">
            <div id="emotion"></div>
            <div class="topic"><a href="javascript:void(0);" onclick="Sharetopic()">话题</a>
            <div id="sharetopic">
                <div class="topicbox">
                <ul id="tabnav2"> 
                    <a id="topic1" onclick="topicajax(1);" href="javascript:void(0)">我关注的</a>
                    <a id="topic2" onclick="topicajax(2);" href="javascript:void(0)">推荐话题</a>
                </ul> 
                <ul class="tagB"></ul>
                </div>
            </div>
            </div>
            <div class="video"><a href="javascript:void(0);">视频</a>
            <div id="sharevideo">
                <p>请直接在微博发布框粘贴视频播放页面URL地址，或MP3/WMA音乐文件地址</p>
	            <p>支持如下视频的站内播放：<a href="http://video.sina.com.cn/" rel="nofollow" target="_blank">新浪</a>、<a href="http://www.youku.com/" rel="nofollow" target="_blank">优酷</a>、<a href="http://v.blog.sohu.com/" rel="nofollow" target="_blank">搜狐</a>、<a href="http://www.ku6.com/" rel="nofollow" target="_blank">酷6</a>、<a href="http://www.tudou.com/" rel="nofollow" target="_blank">土豆</a>、<a href="http://tv.mofile.com/" rel="nofollow" target="_blank">魔方</a></p>
            </div></div>
            <div class="emos"><a href="javascript:void(0);" onclick="showemotion('emotion','contentbox')">表情</a></div>
            <div class="photo"><a href="javascript:void(0);">照片</a>
            <div id="sharephoto">
                <div id="loadform" style="display:block">
                    <div id="closephoto"></div>
                    请选择要上传的图片：
                    <form target="imageUpload" method="post" enctype="multipart/form-data" action="<?php echo SITE_URL;?>/Space/uploadpic" id="upform">
                        <input type="file" id="uploadbtn" class="uploadbtn" name="image" title="支持jpg、jpeg、gif、png格式，文件小于2M"/>
                    </form>
                </div>
                <div id="priviewbtn"></div>
                <div id="uploading"><img src='<?php echo __PUBLIC__;?>/images/spinner.gif'> 上传中 <a href='javascript:void(0)' onclick='cencelUpload();'>[取消]</a></div>
                <div class="clearline"></div>
                <div id="priviewpoic"></div>
            </div>
            </div>
            <iframe style="display:none;" src="about:blank" name="imageUpload" id="imageUpload"></iframe>
            <span id="morecontent" style="display:none;"></span>
        </div>
        <div class="fright">
            <div class="sendtip"><span class="sendsp">还能输入<span id="nums">140</span>字</span></div>
            <input type="button" class="sendbutton" onclick="sendTalk()" value=""/>
        </div>
        </div>
    </div>
    <div class="contenter">
        <div class="ad3"><?php echo stripslashes($site['ad3']);?></div>
        <div class="hometitle">
        <?php if($type=='home'){ ?>
            <span class="mine">所有广播</span>
        <?php }else if($type=='mine'){ ?>
            <span class="mine">我的广播</span>
        <?php }else if($type=='at'){ ?>
            <span class="at">提到我的</span>
        <?php }else if($type=='favor'){ ?>
            <span class="favor">我的收藏</span>
        <?php } ?>
        <div class="fright">
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
                <?php foreach($content as $val){
                    if ($type=='favor') echo $ctent->loadoneli($val,0);
                    else echo $ctent->loadoneli($val);
                } ?>
            <?php }else{ ?>
                <li class="unlight" id="nonemsg">这里暂时还没有广播</li>
            <?php } ?>
            </ol>
        </div>
    </div>
</td>
<td id="sidebar" rowspan="2"><div class="contenter">
    <div class="sect first-sect" style="margin-bottom:0px">
        <div class="fleft" style="width:60px"><a href="<?php echo SITE_URL;?>/Setting/face" title="修改头像"><img src="<?php echo sethead($my[user_head]);?>" width="50px" height="50px" alt="<?php echo ($my[nickname]); ?>" class="imgborder"></a></div>
        <div class="fleft">
            <div class="sidename"><span class="<?php echo setvip($my[user_auth]);?>"><a href="<?php echo SITE_URL;?>/<?php echo ($my[user_name]); ?>/profile"><?php echo ($my[nickname]); ?></a></span></div>
            <div><?php if($my[live_city]){ ?><?php echo ($my[live_city]); ?><?php }else{ ?><a href="<?php echo SITE_URL;?>/Setting">填写您的地区</a><?php } ?></div>
        </div>
        <table class="sidetable">
            <tr style="line-height:100%">
                <td class="tz"><a href="<?php echo SITE_URL;?>/<?php echo ($my[user_name]); ?>/follower"><p><b><?php echo ($my[followme_num]); ?></b></p><p>听众</p></a></td>
                <td class="st"><a href="<?php echo SITE_URL;?>/<?php echo ($my[user_name]); ?>/following"><p><b><?php echo ($my[follow_num]); ?></b></p><p>收听</p></a></td>
                <td class="gb"><a href="<?php echo SITE_URL;?>/<?php echo ($my[user_name]); ?>/mine"><p><b id="mymsgnum"><?php echo ($my[msg_num]); ?></b></p><p>广播</p></a></td>
            </tr>
        </table>
        <?php if($my[user_auth]==1){ ?>
        <div class="userauth">
            <div class="bg"></div>
            <div class="body">
            <p><img src="<?php echo __PUBLIC__;?>/images/viphome.png" /></p>
            <p><?php echo ($my[auth_info]); ?></p>
            </div>
        </div>
        <?php } ?>
    </div>

    <div class="homestabs">
        <ul class="menu">
            <li><a href="<?php echo SITE_URL;?>/<?php echo ($my[user_name]); ?>" class="home<?php if($type=='home'){ ?> curt<?php } ?>">我的主页</a><b class="arr<?php if($type=='home'){ ?> arrCurt<?php } ?>"></b></li>
            <li><a href="<?php echo SITE_URL;?>/<?php echo ($my[user_name]); ?>/mine" class="mytalk<?php if($type=='mine'){ ?> curt<?php } ?>">我的广播</a><b class="arr<?php if($type=='mine'){ ?> arrCurt<?php } ?>"></b></li>
            <li><a href="<?php echo SITE_URL;?>/<?php echo ($my[user_name]); ?>/at" class="at<?php if($type=='at'){ ?> curt<?php } ?>">提到我的<?php if($my[atnum]>0){ ?><span id="atnum">(<?php echo ($my[atnum]); ?>)</span><?php } ?></a><b class="arr<?php if($type=='at'){ ?> arrCurt<?php } ?>"></b></li>
            <li><a href="<?php echo SITE_URL;?>/<?php echo ($my[user_name]); ?>/favor" class="favor<?php if($type=='favor'){ ?> curt<?php } ?>">我的收藏</a><b class="arr<?php if($type=='favor'){ ?> arrCurt<?php } ?>"></b></li>
            <li><a href="<?php echo SITE_URL;?>/Comments" class="comments<?php if($type=='comments'){ ?> curt<?php } ?>">我的评论<?php if($my[comments]>0){ ?><span id="commentstip">(<?php echo ($my[comments]); ?>)</span><?php } ?></a><b class="arr<?php if($type=='comments'){ ?> arrCurt<?php } ?>"></b></li>
            <li><a href="<?php echo SITE_URL;?>/Message/inbox" class="pmsg<?php if($type=='message'){ ?> curt<?php } ?>">私 信<?php if($my[priread]>0){ ?><span id="msgtip">(<?php echo ($my[priread]); ?>)</span><?php } ?></a><b class="arr<?php if($type=='message'){ ?> arrCurt<?php } ?>"></b></li>
        </ul>
    </div>

    <div class="clearline"></div>
    
    <?php if($usertopic){ ?>
    <div class="sect">
        <h2>关注的话题<em>(<?php echo count($usertopic);?>)</em></h2>
        <ul class="ulist" id="mytopic">
        <?php foreach($usertopic as $val){ ?>
        <li><span class="fleft"><a href="<?php echo SITE_URL;?>/k/<?php echo ($val['topic']); ?>"><?php echo ($val['topic']); ?></a></span><span class="num" style="display:none"><a href="javascript:void(0);" onclick="fltopic('<?php echo ($val['topic']); ?>','确认要解除关注该话题？','jc',this.parentNode.parentNode)" title="取消关注该话题">x</a></span><span class="clearline"></span></li>
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
<script type="text/javascript">
    $("#contentbox").focus(function(){$("#contentbox").css({border: "1px solid #7bd6f6" });});
    $("#contentbox").blur(function(){$("#contentbox").css({border: "1px solid #b3b3b3" });});
    $("#contentbox").focus();
    <?php if($type=='at'){ ?>$(document).ready(function(){$("#atnum").remove();closetip("t_at");});<?php } ?>
    $("#lookmore").val('<?php echo ($t); ?>');
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