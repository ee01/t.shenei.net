<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="keywords" content="<?php echo ($site['seokey']); ?>" />
<meta name="description" content="<?php echo ($site['seodescription']); ?>" />
<title><?php echo ($site['sitename']); ?> - <?php echo ($site['subtitle']); ?></title>
<link rel="shortcut icon" href="<?php echo __PUBLIC__;?>/images/favicon.ico" />
<link rel="stylesheet" type="text/css" href="<?php echo __PUBLIC__;?>/images/welcome.css" />
<script type="text/javascript" src="<?php echo __PUBLIC__;?>/js/jquery.js"></script>
</head>

<body>
<div class="main">
    <a href="<?php echo SITE_URL;?>"><div id="header"></div></a>
    <div class="rightbox">
        <div class="rightbox_1">
            <form method="post" action="<?php echo SITE_URL;?>/dologin">
            <table border="0" width="200px">
                <tr height="100px" valign="top">
                    <td><a href="<?php echo SITE_URL;?>/register" class="btn-reg">注册微博</a></td>
                </tr>
                <tr height="40px">
                    <td valign="top">
                    <input tabindex="1" type="text" name="loginname" class="input_text" value="支持微博帐号<?php if(ET_UC!=TRUE){ ?> / 邮箱地址<?php }else{ ?> / Ucenter帐号<?php } ?>" style="width:185px" onfocus="if($(this).val()=='支持微博帐号 / 邮箱地址' || $(this).val()=='支持微博帐号 / Ucenter帐号'){$(this).val('')}" onblur="if($(this).val()==''){$(this).val('支持微博帐号<?php if(ET_UC!=TRUE){ ?> / 邮箱地址<?php }else{ ?> / Ucenter帐号<?php } ?>')}"/>
                    </td>
                </tr>
                <tr height="80px">
                    <td valign="top">
                    <input tabindex="2" type="password" name="password" class="input_text" value="******" maxlength="20" style="width:185px" onfocus="if($(this).val()=='******'){$(this).val('')}"/>
                    <div style="margin-top:15px">
                        <label class="label_check" for="rememberMe">
                        <input tabindex="3" type="checkbox" name="rememberMe" id="rememberMe" value="on" class="checkbox"/>&nbsp;&nbsp;下次自动登录&nbsp;&nbsp;&nbsp;<a href="<?php echo SITE_URL;?>/reset" id="forgot">忘记密码？</a>
                        </label>
                    </div>
                    </td>
                </tr>
                <tr height="30px">
                    <td align="center"><input type="hidden" name="action" value="login" /><input tabindex="4" type="submit" class="button1" value="立即登录" /></td>
                </tr>
            </table>
            </form>
        </div>
        <div class="rightbox_2">
            <p><img src="<?php echo __PUBLIC__;?>/images/phone.png">&nbsp;&nbsp;如何用手机上微博</p>
            <p style="text-indent:24px"><?php echo ET_URL;?>/m</p>
            <p><img src="<?php echo __PUBLIC__;?>/images/help.gif">&nbsp;&nbsp;新手帮助：<a href="<?php echo SITE_URL;?>/Index/faq">点击进入</a></p>
            <p><img src="<?php echo __PUBLIC__;?>/images/favor.gif">&nbsp;&nbsp;关于我们：<a href="<?php echo SITE_URL;?>/Index/about">点击进入</a></p>
        </div>
    </div>
    <div class="weltop">
        <div class="hottopic"><ul><?php echo ($topiclist); ?></ul><div class="clearline"></div></div>
    </div>
    <div class="welbody">
        <div class="hotuser">
            <div class="hotuserico">有趣的人</div>
            <div class="userlist"><ul><?php echo ($userlist); ?></ul></div>
        </div>
        <div class="hottalk">
            <div class="theysay">他们正在说：</div>
            <div class="marqueegb"><ul><?php echo ($welData); ?></ul></div>
        </div>
    </div>
    <div class="welbottom"></div>
    <div id="indexbottom">
        Powered by <a href="http://www.nextsns.com" target="_blank">EasyTalk <?php echo ET_VESION;?></a>.&copy; 2009-2011 <a href="http://www.nextsns.com" target="_blank">Nextsns.com</a>&nbsp;&nbsp;&nbsp;<a href="<?php echo ET_URL;?>"><?php echo ($site['sitename']); ?></a>&nbsp;<a href="http://www.miibeian.gov.cn" target="_blank"><?php echo ($site[miibeian]); ?></a>&nbsp;<?php echo stripslashes($site["foottongji"]);?>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
    //talk
    if ($(".marqueegb ul li").length>3) {
        var firstli;
        var tksi;
        firstli=$(".marqueegb ul li").first();
        firstli.before("<li>"+$(".marqueegb ul li").last().html()+"</li>");
        $(".marqueegb ul li").last().remove();
        firstli.before("<li>"+$(".marqueegb ul li").last().html()+"</li>");
        $(".marqueegb ul li").last().remove();
        firstli.before("<li>"+$(".marqueegb ul li").last().html()+"</li>");
        $(".marqueegb ul li").last().remove();
        function tkscroll() {
            tksi=setInterval(function(){
                firstli=$(".marqueegb ul li").first();
                $(".marqueegb ul li").first().slideDown(1000);
                firstli.before("<li style='display:none'>"+$(".marqueegb ul li").last().html()+"</li>");
                $(".marqueegb ul li").last().remove();
            }, 4000);
        }
        $("a").focus(function(){this.blur()});
        $('.marqueegb').mouseover(function(){clearInterval(tksi)});
        $('.marqueegb').mouseout(function(){tkscroll()});
        tkscroll();
    }
    //topic
    var topiculw=0;
    var l=0;
    var firstl12;
    var tpsi;
    $('.hottopic ul li').each(function(){
        topiculw=topiculw+$(this).width()+10;
    });
    $('.hottopic ul').width(topiculw+'px');
    function tpscroll() {
        tpsi=setInterval(function(){
            l=l+1;
            firstl12=$('.hottopic ul li').first();
            firstl12.css('margin-left',-l);
            if (l==firstl12.width()+10) {
                $('.hottopic ul').append(firstl12);
                $('.hottopic ul li').last().removeAttr('style');
                l=0;
            }
        },50);
    }
    if (topiculw>=530) {
        $('.hottopic').mouseover(function(){clearInterval(tpsi)});
        $('.hottopic').mouseout(function(){tpscroll()});
        tpscroll();
    }
});
</script>
</body>
</html>