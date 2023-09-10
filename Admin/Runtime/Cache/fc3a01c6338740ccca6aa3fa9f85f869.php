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
<div class="infomation"><b>说明：</b>数据备份功能根据您的选择备份数据表，导出的数据文件可用“数据恢复”功能或 phpMyAdmin 导入。<br/><b>提示：</b><span style="color:red">如果您的数据过过大请使用其他专业数据库备份软件或者在服务器通过脚本备份</span>。</div><br/>
<form action="<?php echo SITE_URL;?>/admin.php?s=/Database/export" method="POST">
<h3>数据备份类型</h3>
<div style="margin:10px 15px 15px 15px">
<p><input type="radio" name="expottype" value="exportall" onclick="$('#customtable').hide();" checked> 备份全部表</p>
<p><input type="radio" name="expottype" value="custom" onclick="$('#customtable').show();"> 自定义备份 </p>
<div id="customtable" style="margin:10px 0 0 18px;display:none">
<?php foreach($table as $val){ ?>
    <div style="width:160px;float:left"><input class="checkbox" type="checkbox" name="tables[]" value="<?php echo ($val[Name]); ?>" checked>&nbsp;&nbsp;<?php echo ($val['Name']); ?></div>
<?php } ?>
<div class="clearline"></div>
<p style="margin-top:10px"><input type='checkbox' id='chkall' value='check' checked>&nbsp;&nbsp;全选/反选</p>
</div>
<div class="clearline"></div>
</div>
<h3>备份设置</h3>
<div style="margin:10px 15px 15px 15px">
<p><b>备份文件名</b></p>
<p><input type="text" class="txt_input" name="filename" value="<?php echo date('YmdHis');?>">.sql</p><br/>
<p><b>压缩备份文件</b></p>
<p><input type="radio" name="usezip" value="1"> zip压缩</p>
<p><input type="radio" name="usezip" value="0" checked> 不压缩</p><br/>
<p><b>扩展方式插入(Extended Insert)</b></p>
<p><input type="radio" name="extendin" value="1"> 是</p>
<p><input type="radio" name="extendin" value="0" checked> 否</p><br/>
<p><b>分卷大小</b></p>
<p><input type="text" name="sizelimit" value="2048"> KB</p><br/>
<input type="submit" class="button1" value="确定备份">
</div>
</form>
<script type="text/javascript">
$("#chkall").click(function() {
    if ($(this).attr("checked") == true) {
        $("input[name='tables[]']").each(function() {   
            $(this).attr("checked", true);   
        });   
    } else {
        $("input[name='tables[]']").each(function() {   
            $(this).attr("checked", false);   
        });   
    }   
});
</script>
</div>
</div>
</body>
</html>