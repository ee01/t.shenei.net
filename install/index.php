<?php
date_default_timezone_set("PRC");
header('Content-Type: text/html; charset=utf-8');
define('IN_ET', TRUE);
define('ET_ROOT', dirname(__FILE__).'/../');
@set_time_limit(1000);
@set_magic_quotes_runtime(0);
error_reporting(7);
require('../define.inc.php');
require('include/install.func.php');
require('include/db_mysql.class.php');

$env_items = array(
	'操作系统' => array('c' => 'PHP_OS', 'r' => '不限制', 'b' => '类Unix'),
	'PHP 版本' => array('c' => 'PHP_VERSION', 'r' => '4.3', 'b' => '5.0'),
	'附件上传' => array('r' => '不限制', 'b' => '2M'),
	'GD 库' => array('r' => '1.0', 'b' => '2.0'),
	'磁盘空间' => array('r' => '10M', 'b' => '不限制'),
);
$dirfile_items = array(
	'config' => array('type' => 'file', 'path' => './config.inc.php'),
	'ucenter config' => array('type' => 'file', 'path' => './define.inc.php'),
    'home' => array('type' => 'dir', 'path' => './Home'),
	'home_runtime' => array('type' => 'dir', 'path' => './Home/Runtime'),
	'home_runtime_cache' => array('type' => 'dir', 'path' => './Home/Runtime/Cache'),
    'home_runtime_data' => array('type' => 'dir', 'path' => './Home/Runtime/Data'),
    'home_runtime_logs' => array('type' => 'dir', 'path' => './Home/Runtime/Logs'),
    'home_runtime_temp' => array('type' => 'dir', 'path' => './Home/Runtime/Temp'),
    'admin' => array('type' => 'dir', 'path' => './Admin'),
    'admin_runtime' => array('type' => 'dir', 'path' => './Admin/Runtime'),
	'admin_runtime_cache' => array('type' => 'dir', 'path' => './Admin/Runtime/Cache'),
    'admin_runtime_data' => array('type' => 'dir', 'path' => './Admin/Runtime/Data'),
    'admin_runtime_logs' => array('type' => 'dir', 'path' => './Admin/Runtime/Logs'),
    'admin_runtime_temp' => array('type' => 'dir', 'path' => './Admin/Runtime/Temp'),
	'public_att' => array('type' => 'dir', 'path' => './Public/attachments'),
    'public_att_ut' => array('type' => 'dir', 'path' => './Public/attachments/usertemplates'),
    'public_att_utth' => array('type' => 'dir', 'path' => './Public/attachments/usertemplates/themetemp'),
    'public_att_photo' => array('type' => 'dir', 'path' => './Public/attachments/photo'),
    'public_att_head' => array('type' => 'dir', 'path' => './Public/attachments/head'),
    'public_att_downtheme' => array('type' => 'dir', 'path' => './Public/attachments/downtheme'),
    'public_backup' => array('type' => 'dir', 'path' => './Public/backup'),
);
$DIFNAME=array('admin','home','api','client','index','pub','v','m','setting','dologin','login','logout','register','regcheck','reset','doreset','checkreset','setpass','space','message','find','topic','hot','index','widget','comments','wap','map','plugins','url');

$lockfile = ET_ROOT.'./Public/install.lock';
$allow_method = array('show_license', 'env_check', 'app_reg', 'db_init', 'ext_info');

$step = intval($_REQUEST['step']) ? intval($_REQUEST['step']) : 0;
$method = $_REQUEST['method'];

if(empty($method) || !in_array($method, $allow_method)) {
	$method = isset($allow_method[$step]) ? $allow_method[$step] : '';
}

if(empty($method)) {
	show_msg('未定义方法', $method);
}

if(file_exists($lockfile) && $method != 'ext_info') {
	show_msg('安装锁定，已经安装过了，如果您确定要重新安装，请到服务器上删除<br /> '.str_replace(ET_ROOT, '', $lockfile), '');
}

if($method == 'show_license') {
	transfer_ucinfo($_POST);
	show_license();
} elseif($method == 'env_check') {
	env_check($env_items);
	dirfile_check($dirfile_items);
	show_env_result($env_items, $dirfile_items);
} elseif($method == 'app_reg') {
    $PHP_SELF = $_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
	$etserver = 'http://'.preg_replace("/\:\d+/", '', $_SERVER['HTTP_HOST']).($_SERVER['SERVER_PORT'] && $_SERVER['SERVER_PORT'] != 80 ? ':'.$_SERVER['SERVER_PORT'] : '');
	$default_ucapi = $etserver.'/ucenter';
	$default_appurl = $etserver.substr($PHP_SELF, 0, strpos($PHP_SELF, 'install/') - 1);
    if ($_POST['submitname']) {
        $ucenter=$_POST['ucenter'];
        $siteinfo=$_POST['siteinfo'];
        $install_ucenter=$_POST['install_ucenter'];
        $app_type = 'EasyTalk';
        $app_name = $siteinfo['sitename'] ? $siteinfo['sitename'] : 'EasyTalk';
        $app_url = $siteinfo['siteurl'] ? $siteinfo['siteurl'] : $default_appurl;

        if ($install_ucenter=='yes') {
            include_once ET_ROOT.'./client/client.php';

            $ucinfo = dfopen($ucenter['ucurl'].'/index.php?m=app&a=ucinfo&release=1.5.0', 500, '', '', 1,$ucenter['ucip']);
            list($status, $ucversion, $ucrelease, $uccharset, $ucdbcharset, $apptypes) = explode('|', $ucinfo);
            if($status != 'UC_STATUS_OK') {
                show_msg('UCenter 的 URL 地址可能填写错误，请检查', $ucenter['ucurl']);
            } else {
                $postdata = "m=app&a=add&ucfounder=&ucfounderpw=".urlencode($ucenter['ucpw'])."&apptype=".urlencode($app_type)."&appname=".urlencode($app_name)."&appurl=".urlencode($app_url)."&appip=&appcharset=gbk&appdbcharset=gbk&&release=1.5.0";

                $ucconfig = dfopen($ucenter['ucurl'].'/index.php', 500, $postdata, '', 1,$ucenter['ucip']);
                if(empty($ucconfig)) {
                    show_msg('向 UCenter 添加应用错误', $ucapi);
                } elseif($ucconfig == '-1') {
                    show_msg('UCenter 创始人密码错误，请重新填写', '');
                } else {
                    list($appauthkey, $appid) = explode('|', $ucconfig);
                    $ucconfig_array = explode('|', $ucconfig);
                    $ucconfig_array[] = $ucenter['ucurl'];
                    $ucconfig_array[] = $ucenter['ucip'];
                    if(empty($appauthkey) || empty($appid)) {
                        show_msg('通信失败，请检查 UCenter 的URL 地址是否正确', '');
                    } elseif($succeed = save_uc_config($ucconfig_array, ET_ROOT.'./define.inc.php','TRUE',$app_url)) {
                        $step = $step + 1;
                        header("Location: index.php?step=$step");
                        exit;
                    } else {
                        show_msg('安装向导无法写入配置文件, 请设置 config.inc.php / define.inc.php 文件属性为可写状态(777)','');
                    }
                }
            }
        } else {
            if($succeed = save_uc_config(array(), ET_ROOT.'./define.inc.php','FALSE',$app_url)) {
                $step = $step + 1;
                header("Location: index.php?step=$step");
                exit;
            } else {
                show_msg('安装向导无法写入配置文件, 请设置 config.inc.php / define.inc.php 文件属性为可写状态(777)','');
            }
        }
    } else {
        show_setup();
    }
} else if ($method == 'db_init') {
    if ($_POST['submitname']) {
        $step = $step + 1;
        $dbinfo=$_POST['dbinfo'];
        $admininfo=$_POST['admininfo'];

		if(empty($dbinfo['dbhost']) || empty($dbinfo['dbname']) || empty($dbinfo['dbuser']) || empty($dbinfo['dbpw'])) {
			show_msg('数据库信息没有填写完成', '');
		} else {
			if(!$link = @mysql_connect($dbinfo['dbhost'],$dbinfo['dbuser'],$dbinfo['dbpw'])) {
				$errno = @mysql_errno($link);
				$error = @mysql_error($link);
				if($errno == 1045) {
					show_msg('无法连接数据库，请检查数据库用户名或者密码是否正确', $error);
				} elseif($errno == 2003) {
					show_msg('无法连接数据库，请检查数据库是否启动，数据库服务器地址是否正确', $error);
				} else {
					show_msg('数据库连接错误', $error);
				}
			}
			if(mysql_get_server_info() > '4.1') {
				mysql_query("CREATE DATABASE IF NOT EXISTS `".$dbinfo['dbname']."` DEFAULT CHARACTER SET utf8", $link);
			} else {
				mysql_query("CREATE DATABASE IF NOT EXISTS `".$dbinfo['dbname']."`", $link);
			}
			if(mysql_errno()) {
				show_msg('无法创建新的数据库，请检查数据库名称填写是否正确', mysql_error());
			}
			mysql_close($link);
		}

        if(strpos($dbinfo['tablepre'], '.') !== false) {
			show_msg('数据表前缀为空，或者格式错误，请检查', $tablepre);
		}

        if($admininfo['username'] && $admininfo['password'] && $admininfo['email'] && ($admininfo['password']==$admininfo['password2'])) {
	/*		if(StrLenW2($admininfo['username'])>12 || StrLenW2($admininfo['username'])<3 || !$admininfo['username'] || in_array($admininfo['username'],$DIFNAME)) {
				show_msg('非法用户名，用户名长度不应当超过 12 个英文字符，一般是中文，字母或者数字', $admininfo['username']);
			} else*/if(!strstr($admininfo['email'], '@') || $admininfo['email'] != stripslashes($admininfo['email']) || $admininfo['email'] != htmlspecialchars($admininfo['email'])) {
				show_msg('Email 地址错误，此邮件地址已经被使用或者格式无效，请更换为其他地址',$admininfo['email']);
			} else {
				if(ET_UC==TRUE) {
					$adminuser = check_adminuser($admininfo['username'],$admininfo['password'],$admininfo['email']);
					if($adminuser['uid'] < 1) {
						show_msg($adminuser['error'], '');
					}
				}
			}
		} else {
			show_msg('管理员信息不完整，请检查管理员账号，密码，邮箱','');
		}

        save_config_file($dbinfo,ET_ROOT.'./config.inc.php');

        $db = new dbstuff;
		$db->connect($dbinfo['dbhost'],$dbinfo['dbuser'],$dbinfo['dbpw'],$dbinfo['dbname'],0,true);
        @mysql_query("set names utf8");
        $tablepre=$dbinfo['tablepre'];

        $sql = file_get_contents(ET_ROOT.'./install/include/data.sql');
		$sql = str_replace("\r\n", "\n", $sql);

        show_header();
	    show_install();
        runquery($sql);

        $db->query("INSERT INTO {$tablepre}users (user_name,nickname,password,user_head,user_auth,auth_info,mailadres,signupdate,isadmin) VALUES ('$admininfo[username]','$admininfo[username]', '".md5(md5($admininfo['password']))."','1','1','网站管理员','$admininfo[email]','".time()."','1');");

        touch($lockfile);
        deleteDir(ET_ROOT.'./Home/Runtime');
        deleteDir(ET_ROOT.'./Admin/Runtime');

        echo '<script type="text/javascript">$("#laststep").removeAttr("disabled");$("#laststep").val("安装完成");setTimeout(function(){window.location=\'index.php?method=ext_info\'}, 3000);</script>'."\r\n";
	    show_footer();
    } else {
        show_dbinit();
    }
} elseif($method == 'ext_info') {
	@touch($lockfile);
    show_header();
    echo '</div><div class="main" style="margin-top: -123px;"><ul style="line-height: 200%; margin-left: 30px;">';
    echo '<li><a href="../">安装成功，点击进入</a><br>';
    echo '<script>setTimeout(function(){window.location=\'../\'}, 2000);</script>浏览器会自动跳转页面，无需人工干预</li>';
    echo '</ul></div>';
    show_footer();
}
?>