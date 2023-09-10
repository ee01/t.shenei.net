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
<h3>搜索用户</h3>
<form action='<?php echo SITE_URL;?>/admin.php?s=/Users/index' method="POST">
<table style="margin:5px 0 20px 0">
<tr>
    <td width="150px">用户帐号</td>
    <td><input type="text" name="user_name" class="txt_input"></td>
</tr>
</table>
<input type="submit" class="button1 submit" value="提交查询">
</form>
<?php if($user){ ?>
<h3>编辑用户</h3>
<form action='<?php echo SITE_URL;?>/admin.php?s=/Users/edituser' method="POST" onsubmit="if($('#delmsg').val()==1){if(confirm('你是否要确定删除该用户的广播？')){return true;}else{return false;}}">
<table style="margin:5px 0 20px 0">
<tr>
    <td width="150px">用户帐号</td>
    <td width="330px"><input type="text" name="user_name" class="readonly" value="<?php echo ($user['user_name']); ?>" readonly='true'></td>
    <td></td>
</tr>
<tr>
    <td>注册时间</td>
    <td><?php echo date('Y-m-d H:i:s',$user['signupdate']);?></td>
    <td></td>
</tr>
<tr>
    <td>用户昵称</td>
    <td><input type="text" name="user[nickname]" class="txt_input" value="<?php echo ($user['nickname']); ?>"></td>
    <td></td>
</tr>
<tr>
    <td>用户密码</td>
    <td><input type="text" name="user[password]" class="txt_input" value=""></td>
    <td class="info">● 如果不修改密码请留空</td>
</tr>
<tr>
    <td>用户邮箱</td>
    <td><input type="text" name="user[mailadres]" class="txt_input" value="<?php echo ($user['mailadres']); ?>"></td>
    <td></td>
</tr>
<tr>
    <td valign="top">认证说明</td>
    <td><textarea type="text" name="user[auth_info]" style="font-size:12px;border:1px solid #cccccc;height:80px;width:300px;padding:1px 3px"><?php echo ($user['auth_info']); ?></textarea></td>
    <td class="info" valign="top">● 用户认证信息，支持HTML</td>
</tr>
<tr>
    <td>用户认证</td>
    <td><select name="user[user_auth]">
    <option value="0" <?php if($user['user_auth']==0){ ?>selected<?php } ?>>普通用户</option>
    <option value="1" <?php if($user['user_auth']==1){ ?>selected<?php } ?>>认证用户</option>
    </select></td>
    <td></td>
</tr>
<tr>
    <td>管理员组</td>
    <td>
    <?php if($user[user_id]!=1){ ?>
    <select name="user[isadmin]">
    <option value="0" <?php if($user['isadmin']==0){ ?>selected<?php } ?>>普通用户</option>
    <option value="1" <?php if($user['isadmin']==1){ ?>selected<?php } ?>>总管理员</option>
    <option value="2" <?php if($user['isadmin']==2){ ?>selected<?php } ?>>前台管理</option>
    </select>
    <?php }else{ ?>
    默认管理员无法修改
    <?php } ?>
    </td>
    <td class="info">● 总管理员拥有所有权限，前台管理员仅拥有网站广播的审核权限</td>
</tr>
<tr>
    <td>广场用户榜</td>
    <td><select name="pubtop">
    <option value="0" <?php if($user['pubtop']==0){ ?>selected<?php } ?>>下榜</option>
    <option value="1" <?php if($user['pubtop']==1){ ?>selected<?php } ?>>上榜</option>
    </select></td>
    <td></td>
</tr>
<tr>
    <td>禁止类型</td>
    <td><select name="user[userlock]">
    <option value="0" <?php if($user['userlock']==0){ ?>selected<?php } ?>>正常状态</option>
    <option value="1" <?php if($user['userlock']==1){ ?>selected<?php } ?>>锁定状态</option>
    <option value="2" <?php if($user['userlock']==2){ ?>selected<?php } ?>>禁言状态</option>
    </select></td>
    <td class="info">● 用户锁定后将不能登陆，其他用户也不可浏览其主页</td>
</tr>
<tr>
    <td>删除用户广播</td>
    <td><select id="delmsg" name="delmsg">
    <option value="0" selected>不删除</option>
    <option value="1">删除</option>
    </select></td>
    <td class="info">● 选择此项提交后将删除用户的所有广播</td>
</tr>
</table>
<input type="submit" class="button1 submit" value="保存提交">
</form>
<?php } ?>
</div>
</div>
</body>
</html>