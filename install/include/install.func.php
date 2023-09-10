<?php
$VERSION='X1.3';
$RELEASE='20110418';

function show_msg($title, $error_msg = 'ok', $quit = TRUE) {
    show_header();
    global $step;
    $errormsg = $comment = '';
    if($error_msg) {
        if(!empty($error_msg)) {
            foreach ((array)$error_msg as $k => $v) {
                if(is_numeric($k)) {
                    $comment .= "<li><em class=\"red\">".$v."</em></li>";
                }
            }
        }
    }
    if($step > 0) {
        echo "<div class=\"desc\"><b>$title</b><ul>$comment</ul>";
    } else {
        echo "</div><div class=\"main\" style=\"margin-top: -123px;\"><b>$title</b><ul style=\"line-height: 200%; margin-left: 30px;\">$comment</ul>";
    }
    if($quit) {
        echo '<br /><span class="red">您必须解决以上问题，安装才可以继续</span><br /><br /><br />';
    }
    echo '<input type="button" onclick="history.back()" value="点击返回上一步" /><br /><br /><br /></div>';
    $quit && show_footer();
}

function show_dbinit() {
    show_header();
    echo '<form method="post" action="index.php">
    <input type="hidden" name="step" value="3">
    <div id="form_items_3" ><br /><div class="desc"><b>填写数据库信息</b></div>
    <table class="tb2">
        <tr><th class="tbopt">&nbsp;数据库服务器:</th>
        <td><input type="text" name="dbinfo[dbhost]" value="localhost" size="35" class="txt"></td>
        <td>&nbsp;数据库服务器地址, 一般为 localhost</td>
        </tr>
        <tr><th class="tbopt">&nbsp;数据库名:</th>
        <td><input type="text" name="dbinfo[dbname]" value="easytalk" size="35" class="txt"></td>
        <td>&nbsp;</td>
        </tr>
        <tr><th class="tbopt">&nbsp;数据库用户名:</th>
        <td><input type="text" name="dbinfo[dbuser]" value="root" size="35" class="txt"></td>
        <td>&nbsp;</td>
        </tr>
        <tr><th class="tbopt">&nbsp;数据库密码:</th>
        <td><input type="text" name="dbinfo[dbpw]" value="" size="35" class="txt"></td>
        <td>&nbsp;</td>
        </tr>
        <tr><th class="tbopt">&nbsp;数据表前缀:</th>
        <td><input type="text" name="dbinfo[tablepre]" value="et_" size="35" class="txt"></td>
        <td>&nbsp;同一数据库运行多个微博时，请修改前缀</td>
        </tr>
    </table>
    <div class="desc"><b>填写管理员信息</b></div>
    <table class="tb2">
        <tr><th class="tbopt">&nbsp;管理员账号:</th>
        <td><input type="text" name="admininfo[username]" value="etadmin" size="35" class="txt"></td>
        <td>&nbsp;</td>
        </tr>
        <tr><th class="tbopt">&nbsp;管理员密码:</th>
        <td><input type="password" name="admininfo[password]" value="" size="35" class="txt"></td>
        <td>&nbsp;管理员密码不能为空</td>
        </tr>
        <tr><th class="tbopt">&nbsp;重复密码:</th>
        <td><input type="password" name="admininfo[password2]" value="" size="35" class="txt"></td>
        <td>&nbsp;</td>
        </tr>
        <tr><th class="tbopt">&nbsp;管理员 Email:</th>
        <td><input type="text" name="admininfo[email]" value="admin@admin.com" size="35" class="txt"></td>
        <td>&nbsp;</td>
        </tr>
    </table></div><table class="tb2">
    <tr><th class="tbopt">&nbsp;</th>
    <td><input type="submit" name="submitname" value="下一步" class="btn">
    </td>
    <td>&nbsp;</td>
    </tr>
    </table>
    </form>';
    show_footer();
}

function StrLenW2($str){
    return (strlen($str)+mb_strlen($str,'UTF8'))/2;
}

function show_setup() {
    global $default_appurl;
    show_header();
    echo '<form method="post" action="index.php">
    <input type="hidden" name="step" value="2">
    <div class="desc"><b><br><label><input type="radio" checked="checked" name="install_ucenter" value="yes" onclick="if(this.checked){$(\'#form_items_1\').show();$(\'#form_items_2\').hide()}" /> 整合Ucenter 安装 EasyTalk</label></b></div>
    <div id="form_items_1" style="display:none;margin-left:50px;padding-top:10px;">
        <div class="desc"><b>请填写 UCenter 相关信息</b></div>
        <table class="tb2">
            <tr><th class="tbopt">&nbsp;UCenter URL:</th>
            <td><input type="text" name="ucenter[ucurl]" value="" size="35" class="txt"></td>
            <td>&nbsp;</td>
            </tr>
            <tr><th class="tbopt">&nbsp;UCenter IP地址:</th>
            <td><input type="text" name="ucenter[ucip]" value="" size="35" class="txt"></td>
            <td>&nbsp;绝大多数情况下您可以不填</td>
            </tr>
            <tr><th class="tbopt">&nbsp;UCenter 密码:</th>
            <td><input type="password" name="ucenter[ucpw]" value="" size="35" class="txt"></td>
            <td>&nbsp;</td>
            </tr>
        </table>
        <div class="desc"><b>请填写站点信息</b></div>
        <table class="tb2">
            <tr><th class="tbopt">&nbsp;站点名称:</th>
            <td><input type="text" name="siteinfo[sitename]" value="EasyTalk" size="35" class="txt"></td>
            <td>&nbsp;</td>
            </tr>
            <tr><th class="tbopt">&nbsp;站点 URL:</th>
            <td><input type="text" name="siteinfo[siteurl]" value="'.$default_appurl.'" size="35" class="txt"></td>
            <td>&nbsp;</td>
            </tr>
        </table>
    </div>
    <div class="desc"><b><br><label><input type="radio" checked name="install_ucenter" value="no" onclick="if(this.checked){$(\'#form_items_1\').hide();$(\'#form_items_2\').show()}" /> 独立安装 EasyTalk</label></b></div>
    <div id="form_items_2" style="margin-left:10px;">
        <table class="tb2">
            <tr><th class="tbopt">&nbsp;站点名称:</th>
            <td><input type="text" name="siteinfo[sitename]" value="EasyTalk" size="35" class="txt"></td>
            <td>&nbsp;</td>
            </tr>
            <tr><th class="tbopt">&nbsp;站点 URL:</th>
            <td><input type="text" name="siteinfo[siteurl]" value="'.$default_appurl.'" size="35" class="txt"></td>
            <td>&nbsp;</td>
            </tr>
        </table>
    </div>
    <table class="tb2">
        <tr><th class="tbopt">&nbsp;</th>
        <td><input type="submit" name="submitname" value="下一步" class="btn">
        </td>
        <td>&nbsp;</td>
        </tr>
    </table>
    </form>';
    show_footer();
}

function check_adminuser($username, $password, $email) {
	include ET_ROOT.'./define.inc.php';
	include ET_ROOT.'./client/client.php';

	$error = '';
	$ucresult = uc_user_login($username, $password);
	list($tmp['uid'], $tmp['username'], $tmp['password'], $tmp['email']) = uc_addslashes($ucresult);
	$ucresult = $tmp;
	if($ucresult['uid'] <= 0) {
		$uid = uc_user_register($username, $password, $email);
		if($uid == -1 || $uid == -2) {
			$error = '非法用户名，用户名长度不应当超过 12 个英文字符，且不能包含特殊字符，一般是中文，字母或者数字';
		} elseif($uid == -4 || $uid == -5 || $uid == -6) {
			$error = 'Email 地址错误，此邮件地址已经被使用或者格式无效，请更换为其他地址';
		} elseif($uid == -3) {
			$error = '该用户已经存在，如果您要设置此用户为微博的管理员，请正确输入该用户的密码，或者请更换微博管理员的名字';
		}
	} else {
		$uid = $ucresult['uid'];
		$email = $ucresult['email'];
		$password = $ucresult['password'];
	}

	if(!$error && $uid > 0) {
		$password = md5($password);
		uc_user_addprotected($username, '');
	} else {
		$uid = 0;
		$error = empty($error) ? '未知的错误' : $error;
	}
	return array('uid' => $uid, 'username' => $username, 'password' => $password, 'email' => $email, 'error' => $error);
}

function save_uc_config($config, $file,$opuc,$siteurl) {
    global $VERSION,$RELEASE;
	$success = false;
    if ($opuc=='TRUE') {
        list($appauthkey, $appid, $ucdbhost, $ucdbname, $ucdbuser, $ucdbpw, $ucdbcharset, $uctablepre, $uccharset, $ucapi, $ucip) = $config;
        $link = mysql_connect($ucdbhost, $ucdbuser, $ucdbpw, 1);
        $uc_connnect = $link && mysql_select_db($ucdbname, $link) ? 'mysql' : '';
    }

	$config = "<?php
    if (!defined('IN_ET')) exit();

    // ucenter config
    define('UC_CONNECT', '$uc_connnect');
    define('UC_DBHOST', '$ucdbhost');
    define('UC_DBUSER', '$ucdbuser');
    define('UC_DBPW', '$ucdbpw');
    define('UC_DBNAME', '$ucdbname');
    define('UC_DBCHARSET', '$ucdbcharset');
    define('UC_DBTABLEPRE', '`$ucdbname`.$uctablepre');
    define('UC_DBCONNECT', 0);
    define('UC_CHARSET', '$uccharset');
    define('UC_KEY', '$appauthkey');
    define('UC_API', '$ucapi');
    define('UC_APPID', '$appid');
    define('UC_IP', '$ucip');
    define('UC_PPP', 20);

    // vesion
    define('ET_VESION', '".$VERSION."');
    define('ET_RELEASE', '".$RELEASE."');

    // global config
    define('ET_UC', $opuc);                      //是否开启ucenter ，开启填写 TRUE ，关闭 填写 FALSE
    define('ET_URL','$siteurl');
    ?>";

	if($fp = fopen($file, 'w')) {
		fwrite($fp, $config);
		fclose($fp);
		$success = true;
	}
	return $success;
}

function save_config_file($config, $file) {
	$success = false;
	$config = "<?php
    if (!defined('IN_ET')) exit();

    return array(
        'DB_TYPE'=>'mysql',
        'DB_HOST'=>'$config[dbhost]',
        'DB_NAME'=>'$config[dbname]',
        'DB_USER'=>'$config[dbuser]',
        'DB_PWD'=>'$config[dbpw]',
        'DB_PORT'=>3306,
        'DB_PREFIX'=>'$config[tablepre]',
        'APP_DEBUG'=>false,
    );
    ?>";
	if($fp = fopen($file, 'w')) {
		fwrite($fp, $config);
		fclose($fp);
		$success = true;
	}
	return $success;
}

function transfer_ucinfo(&$post) {
	global $uchidden;
	if(isset($_post['ucapi']) && isset($_post['ucfounderpw'])) {
		$arr = array(
			'ucapi' => $_post['ucapi'],
			'ucfounderpw' => $_post['ucfounderpw']
			);
		$uchidden = urlencode(serialize($arr));
	} else {
		$uchidden = '';
	}
}

function dfopen($url, $limit = 0, $post = '', $cookie = '', $bysocket = FALSE, $ip = '', $timeout = 15, $block = TRUE) {
	$return = '';
	$matches = parse_url($url);
	$host = $matches['host'];
	$path = $matches['path'] ? $matches['path'].(isset($matches['query']) && $matches['query'] ? '?'.$matches['query'] : '') : '/';
	$port = !empty($matches['port']) ? $matches['port'] : 80;
	if($post) {
		$out = "POST $path HTTP/1.0\r\n";
		$out .= "Accept: */*\r\n";
		$out .= "Accept-Language: zh-cn\r\n";
		$out .= "Content-Type: application/x-www-form-urlencoded\r\n";
		$out .= "User-Agent: $_SERVER[HTTP_USER_AGENT]\r\n";
		$out .= "Host: $host\r\n";
		$out .= 'Content-Length: '.strlen($post)."\r\n";
		$out .= "Connection: Close\r\n";
		$out .= "Cache-Control: no-cache\r\n";
		$out .= "Cookie: $cookie\r\n\r\n";
		$out .= $post;
	} else {
		$out = "GET $path HTTP/1.0\r\n";
		$out .= "Accept: */*\r\n";
		$out .= "Accept-Language: zh-cn\r\n";
		$out .= "User-Agent: $_SERVER[HTTP_USER_AGENT]\r\n";
		$out .= "Host: $host\r\n";
		$out .= "Connection: Close\r\n";
		$out .= "Cookie: $cookie\r\n\r\n";
	}
	if(function_exists('fsockopen')) {
		$fp = @fsockopen(($ip ? $ip : $host), $port, $errno, $errstr, $timeout);
	} elseif (function_exists('pfsockopen')) {
		$fp = @pfsockopen(($ip ? $ip : $host), $port, $errno, $errstr, $timeout);
	} else {
		$fp = false;
	}
	if(!$fp) {
		return '';
	} else {
		stream_set_blocking($fp, $block);
		stream_set_timeout($fp, $timeout);
		@fwrite($fp, $out);
		$status = stream_get_meta_data($fp);
		if(!$status['timed_out']) {
			while (!feof($fp)) {
				if(($header = @fgets($fp)) && ($header == "\r\n" ||  $header == "\n")) {
					break;
				}
			}
			$stop = false;
			while(!feof($fp) && !$stop) {
				$data = fread($fp, ($limit == 0 || $limit > 8192 ? 8192 : $limit));
				$return .= $data;
				if($limit) {
					$limit -= strlen($data);
					$stop = $limit <= 0;
				}
			}
		}
		@fclose($fp);
		return $return;
	}
}

function show_license() {
	global $uchidden, $step;
	$next = $step + 1;
    show_header();
    $license = '<div class="license"><h1>EasyTalk 中文版授权协议</h1>
    <p>版权所有 (c) 2009-2011，兰州乐游网络科技有限责任公司保留所有权利。</p>
    <p>感谢您选择 EasyTalk 微博客产品。我们将继续努力打造顶尖的中文微博客解决方案。</p>
    <p>EasyTalk 英文全称为 EasyTalk Microblog System，中文全称为 EasyTalk微博客，以下简称 EasyTalk。</p>
    <p>兰州乐游网络科技有限责任公司为 EasyTalk 产品的开发商，依法独立拥有 EasyTalk 产品著作权。兰州乐游网络科技有限责任公司网址为 http://www.nextsns.com。</p>
    <p>EasyTalk 著作权已在中华人民共和国国家版权局注册，著作权受到法律和国际公约保护。使用者：无论个人或组织、盈利与否、用途如何（包括以学习和研究为目的），均需仔细阅读本协议，在理解、同意、并遵守本协议的全部条款后，方可开始使用 EasyTalk 软件。</p>
    <p>本授权协议适用且仅适用于 EasyTalk X版本，兰州乐游网络科技有限责任公司拥有对本授权协议的最终解释权。</p>
    <h3>I. 协议许可的权利</h3>
    <ol>
    <li>您可以在完全遵守本最终用户授权协议的基础上，将本软件应用于非商业用途，而不必支付软件版权授权费用。</li>
    <li>您可以在协议规定的约束和限制范围内修改 EasyTalk 源代码或界面风格以适应您的网站要求。</li>
    <li>您拥有使用本软件构建的微博客中全部会员资料、信息内容及相关信息的所有权，并独立承担与信息内容的相关法律义务。</li>
    <li>获得商业授权之后，您可以将本软件应用于商业用途。</li>
    </ol>
    <h3>II. 协议规定的约束和限制</h3>
    <ol>
    <li>未获商业授权之前，不得将本软件用于商业用途（包括但不限于企业网站、经营性网站、以营利为目或实现盈利的网站）。购买商业授权请登陆http://www.nextsns.com参考相关说明。</li>
    <li>不得对本软件或与之关联的商业授权进行出租、出售、抵押或发放子许可证。</li>
    <li>无论如何，即无论用途如何、是否经过修改或美化、修改程度如何，只要使用 EasyTalk 的整体或任何部分，未经书面许可，论坛页面页脚处的 EasyTalk 名称和网站（http://www.nextsns.com）的链接都必须保留，而不能清除或修改。</li>
    <li>禁止在 EasyTalk 的整体或任何部分基础上以发展任何派生版本、修改版本或第三方版本用于重新分发。</li>
    <li>如果您未能遵守本协议的条款，您的授权将被终止，所被许可的权利将被收回，并承担相应法律责任。</li>
    </ol>
    <h3>III. 有限担保和免责声明</h3>
    <ol>
    <li>本软件及所附带的文件是作为不提供任何明确的或隐含的赔偿或担保的形式提供的。</li>
    <li>用户出于自愿而使用本软件，您必须了解使用本软件的风险，在尚未购买产品技术服务之前，我们不承诺提供任何形式的技术支持，也不承担任何因使用本软件而产生问题的相关责任。</li>
    <li>兰州乐游网络科技有限责任公司不对使用本软件构建的微博客中的信息内容承担责任。</li>
    </ol>
    <p>有关 EasyTalk 最终用户授权协议、商业授权与技术服务的详细内容，均由 EasyTalk 官方网站独家提供。兰州乐游网络科技有限责任公司拥有在不事先通知的情况下，修改授权协议和服务价目表的权力，修改后的协议或价目表对自改变之日起的新授权用户生效。</p>
    <p>电子文本形式的授权协议如同双方书面签署的协议一样，具有完全的和等同的法律效力。您一旦开始安装 EasyTalk，即被视为完全理解并接受本协议的各项条款，在享有上述条款授予的权力的同时，受到相关的约束和限制。协议许可范围以外的行为，将直接违反本授权协议并构成侵权，我们有权随时终止授权，责令停止损害，并保留追究相关责任的权力。</p></div>';
    echo '</div>
    <div class="main" style="margin-top:-123px;">
    <div class="licenseblock">'.$license.'</div>
    <div class="btnbox marginbot">
        <form method="get" autocomplete="off" action="index.php">
        <input type="hidden" name="step" value="'.$next.'">
        <input type="hidden" name="uchidden" value="'.$uchidden.'">
        <input type="submit" value="我同意" style="padding: 2px">&nbsp;
        <input type="button" value="我不同意" style="padding: 2px" onclick="javascript: window.close(); return false;">
        </form>
    </div>';
    show_footer();
}

function dirfile_check(&$dirfile_items) {
	foreach($dirfile_items as $key => $item) {
		$item_path = $item['path'];
		if($item['type'] == 'dir') {
			if(!dir_writeable(ET_ROOT.$item_path)) {
				if(is_dir(ET_ROOT.$item_path)) {
					$dirfile_items[$key]['status'] = 0;
					$dirfile_items[$key]['current'] = '+r';
				} else {
					$dirfile_items[$key]['status'] = -1;
					$dirfile_items[$key]['current'] = 'nodir';
				}
			} else {
				$dirfile_items[$key]['status'] = 1;
				$dirfile_items[$key]['current'] = '+r+w';
			}
		} else {
			if(file_exists(ET_ROOT.$item_path)) {
				if(is_writable(ET_ROOT.$item_path)) {
					$dirfile_items[$key]['status'] = 1;
					$dirfile_items[$key]['current'] = '+r+w';
				} else {
					$dirfile_items[$key]['status'] = 0;
					$dirfile_items[$key]['current'] = '+r';
				}
			} else {
				if(dir_writeable(dirname(ET_ROOT.$item_path))) {
					$dirfile_items[$key]['status'] = 1;
					$dirfile_items[$key]['current'] = '+r+w';
				} else {
					$dirfile_items[$key]['status'] = -1;
					$dirfile_items[$key]['current'] = 'nofile';
				}
			}
		}
	}
}

function env_check(&$env_items) {
	foreach($env_items as $key => $item) {
		if($key == 'PHP 版本') {
			$env_items[$key]['current'] = PHP_VERSION;
		} elseif($key == '附件上传') {
			$env_items[$key]['current'] = @ini_get('file_uploads') ? ini_get('upload_max_filesize') : 'unknow';
		} elseif($key == 'GD 库') {
			$tmp = function_exists('gd_info') ? gd_info() : array();
			$env_items[$key]['current'] = empty($tmp['GD Version']) ? 'noext' : $tmp['GD Version'];
			unset($tmp);
		} elseif($key == '磁盘空间') {
			if(function_exists('disk_free_space')) {
				$env_items[$key]['current'] = floor(disk_free_space(ET_ROOT) / (1024*1024)).'M';
			} else {
				$env_items[$key]['current'] = 'unknow';
			}
		} elseif(isset($item['c'])) {
			$env_items[$key]['current'] = constant($item['c']);
		}
		$env_items[$key]['status'] = 1;
		if($item['r'] != 'notset' && strcmp($env_items[$key]['current'], $item['r']) < 0) {
			$env_items[$key]['status'] = 0;
		}
	}
}

function show_env_result(&$env_items, &$dirfile_items) {
	$env_str = $file_str = $dir_str = '';
	$error_code = 0;

	foreach($env_items as $key => $item) {
		if($key == 'php' && strcmp($item['current'], $item['r']) < 0) {
			show_msg('php_version_too_low', $item['current']);
		}
		$status = 1;
		if($item['r'] != '不限制') {
			if(intval($item['current']) && intval($item['r'])) {
				if(intval($item['current']) < intval($item['r'])) {
					$status = 0;
					$error_code = 31;
				}
			} else {
				if(strcmp($item['current'], $item['r']) < 0) {
					$status = 0;
					$error_code = 31;
				}
			}
		}
        $env_str .= "<tr>\n";
        $env_str .= "<td>".$key."</td>\n";
        $env_str .= "<td class=\"padleft\">".$item['r']."</td>\n";
        $env_str .= "<td class=\"padleft\">".$item['b']."</td>\n";
        $env_str .= ($status ? "<td class=\"w pdleft1\">" : "<td class=\"nw pdleft1\">").$item['current']."</td>\n";
        $env_str .= "</tr>\n";
	}

	foreach($dirfile_items as $key => $item) {
		$tagname = $item['type'] == 'file' ? 'File' : 'Dir';
		$variable = $item['type'].'_str';
        $$variable .= "<tr>\n";
        $$variable .= "<td>$item[path]</td><td class=\"w pdleft1\">可写</td>\n";
        if($item['status'] == 1) {
            $$variable .= "<td class=\"w pdleft1\">可写</td>\n";
        } elseif($item['status'] == -1) {
            $error_code = 31;
            $$variable .= "<td class=\"nw pdleft1\">目录不存在</td>\n";
        } else {
            $error_code = 31;
            $$variable .= "<td class=\"nw pdleft1\">不可写</td>\n";
        }
        $$variable .= "</tr>\n";
	}
    show_header();
    echo "<h2 class=\"title\">开始安装</h2>\n";
    echo "<table class=\"tb\" style=\"margin:20px 0 20px 55px;\">\n";
    echo "<tr>\n";
    echo "\t<th>项目</th>\n";
    echo "\t<th class=\"padleft\">EasyTalk配置</th>\n";
    echo "\t<th class=\"padleft\">EasyTalk最佳</th>\n";
    echo "\t<th class=\"padleft\">当前服务器</th>\n";
    echo "</tr>\n";
    echo $env_str;
    echo "</table>\n";

    echo "<h2 class=\"title\">目录、文件权限检查</h2>\n";
    echo "<table class=\"tb\" style=\"margin:20px 0 20px 55px;width:90%;\">\n";
    echo "\t<tr>\n";
    echo "\t<th>目录文件</th>\n";
    echo "\t<th class=\"padleft\">所需状态</th>\n";
    echo "\t<th class=\"padleft\">当前状态</th>\n";
    echo "</tr>\n";
    echo $file_str;
    echo $dir_str;
    echo "</table>\n";

    show_next_step(2, $error_code);
    show_footer();
}

function show_next_step($step, $error_code) {
	global $uchidden;
	echo "<form action=\"index.php\" method=\"post\">\n";
	echo "<input type=\"hidden\" name=\"step\" value=\"$step\" />";
	if(isset($GLOBALS['hidden'])) {
		echo $GLOBALS['hidden'];
	}
	echo "<input type=\"hidden\" name=\"uchidden\" value=\"$uchidden\" />";
	if($error_code == 0) {
		$nextstep = "<input type=\"button\" onclick=\"history.back();\" value=\"上一步\"><input type=\"submit\" value=\"下一步\">\n";
	} else {
		$nextstep = "<input type=\"button\" disabled=\"disabled\" value=\"请将以上红叉部分修正再试\">\n";
	}
	echo "<div class=\"btnbox marginbot\">".$nextstep."</div>\n";
	echo "</form>\n";
}

function dir_writeable($dir) {
	$writeable = 0;
	if(!is_dir($dir)) {
		@mkdir($dir, 0777);
	}
	if(is_dir($dir)) {
		if($fp = @fopen("$dir/test.txt", 'w')) {
			@fclose($fp);
			@unlink("$dir/test.txt");
			$writeable = 1;
		} else {
			$writeable = 0;
		}
	}
	return $writeable;
}

function show_header() {
	global $step;
	echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>EasyTalk 安装向导</title>
    <link rel="stylesheet" href="images/style.css" type="text/css" media="all" />
    <script type="text/javascript" src="../Public/js/jquery.js"></script>
    <script type="text/javascript">
    function showmessage(message) {
		$("#notice").html($("#notice").html()+message+"<br />");
	}
    </script>
    </head>
    <div class="container">
    <div class="header">
    <h1>EasyTalk 安装向导</h1>
    <span>EasyTalk '.ET_VESION.' '.ET_RELEASE.'</span>';

	$step > 0 && show_step($step);
}

function show_footer($quit = true) {
	echo '<div class="footer">&copy;2009 - 2011 <a href="http://www.nextsns.com/">Nextsns.com</a></div></div></div></body></html>';
	$quit && exit();
}

function show_step($step) {
	global $method;
	$laststep = 4;

    if ($method=='env_check') {
        $title = '开始安装';
        $comment = '环境以及文件目录权限检查';
    } else if ($method=='app_reg') {
        $title = '设置运行环境';
        $comment = '检测服务器环境以及设置 UCenter';
    } else if ($method=='db_init') {
        $title = '安装数据库';
        $comment = '正在执行数据库安装';
    }

	$stepclass = array();
	for($i = 1; $i <= $laststep; $i++) {
		$stepclass[$i] = $i == $step ? 'current' : ($i < $step ? '' : 'unactivated');
	}
	$stepclass[$laststep] .= ' last';

	echo '<div class="setup step'.$step.'">
            <h2>'.$title.'</h2>
            <p>'.$comment.'</p>
        </div>
        <div class="stepstat">
            <ul>
                <li class="'.$stepclass[1].'">1</li>
                <li class="'.$stepclass[2].'">2</li>
                <li class="'.$stepclass[3].'">3</li>
                <li class="'.$stepclass[4].'">4</li>
            </ul>
            <div class="stepstatbg stepstat1"></div>
        </div>
    </div>
    <div class="main">';
}

function show_install() {
    ?>
    <script type="text/javascript">
    function showmessage(message) {
        $('#notice').html($('#notice').html() + message + '<br />');
        $('#notice').scrollTop(100000000);
    }
    function initinput() {/*window.location='index.php?method=ext_info';*/}
    </script>
    <div class="main"><div class="btnbox"><div id="notice"></div></div><div class="btnbox marginbot"><input type="button" name="submit" value="正在安装..." disabled style="height: 25" id="laststep" onclick="initinput()"></div>
    <?php
}

function runquery($sql) {
	global $tablepre, $db;
	if(!isset($sql) || empty($sql)) return;
	$sql = str_replace("\r", "\n", str_replace(' et_', ' '.$tablepre, $sql));
	$sql = str_replace("\r", "\n", str_replace(' `et_', ' `'.$tablepre, $sql));
	$ret = array();
	$num = 0;
	foreach(explode(";\n", trim($sql)) as $query) {
		$ret[$num] = '';
		$queries = explode("\n", trim($query));
		foreach($queries as $query) {
			$ret[$num] .= (isset($query[0]) && $query[0] == '#') || (isset($query[1]) && isset($query[1]) && $query[0].$query[1] == '--') ? '' : $query;
		}
		$num++;
	}
	unset($sql);
	foreach($ret as $query) {
		$query = trim($query);
		if($query) {
			if(substr($query, 0, 12) == 'CREATE TABLE') {
				$name = preg_replace("/CREATE TABLE IF NOT EXISTS `([a-z0-9_]+)` .*/is", "\\1", $query);
				showjsmessage('建立数据表 '.$name.' ... 成功');
				$db->query(createtable($query));
			} else {
				$db->query($query);
			}
		}
	}
}

function createtable($sql) {
	$type = strtoupper(preg_replace("/^\s*CREATE TABLE\s+.+\s+\(.+?\).*(ENGINE|TYPE)\s*=\s*([a-z]+?).*$/isU", "\\2", $sql));
	$type = in_array($type, array('MYISAM', 'HEAP', 'MEMORY')) ? $type : 'MYISAM';
	return preg_replace("/^\s*(CREATE TABLE\s+.+\s+\(.+?\)).*$/isU", "\\1", $sql).
	(mysql_get_server_info() > '4.1' ? " ENGINE=$type DEFAULT CHARSET=utf8" : " TYPE=$type");
}

function showjsmessage($message) {
	echo '<script type="text/javascript">showmessage(\''.addslashes($message).' \');</script>'."\r\n";
	flush();
	ob_flush();
}

function deleteDir($dirName){
    if(!is_dir($dirName)){
        @unlink($dirName);
        return false;
    }
    $handle = @opendir($dirName);
    while(($file = @readdir($handle)) !== false){
        if($file != '.' && $file != '..'){
            $dir = $dirName . '/' . $file;
            is_dir($dir) ? deleteDir($dir) : @unlink($dir);
        }
    }
    closedir($handle);
    return rmdir($dirName);
}

function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
    global $webaddr;
    $auth_key=md5($webaddr);
	$ckey_length = 4;
	$key = md5($key ? $key : $auth_key);
	$keya = md5(substr($key, 0, 16));
	$keyb = md5(substr($key, 16, 16));
	$keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';
	$cryptkey = $keya.md5($keya.$keyc);
	$key_length = strlen($cryptkey);
	$string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
	$string_length = strlen($string);
	$result = '';
	$box = range(0, 255);
	$rndkey = array();
	for($i = 0; $i <= 255; $i++) {
		$rndkey[$i] = ord($cryptkey[$i % $key_length]);
	}
	for($j = $i = 0; $i < 256; $i++) {
		$j = ($j + $box[$i] + $rndkey[$i]) % 256;
		$tmp = $box[$i];
		$box[$i] = $box[$j];
		$box[$j] = $tmp;
	}
	for($a = $j = $i = 0; $i < $string_length; $i++) {
		$a = ($a + 1) % 256;
		$j = ($j + $box[$a]) % 256;
		$tmp = $box[$a];
		$box[$a] = $box[$j];
		$box[$j] = $tmp;
		$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
	}
	if($operation == 'DECODE') {
		if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
			return substr($result, 26);
		} else {
			return '';
		}
	} else {
		return $keyc.str_replace('=', '', base64_encode($result));
	}
}
?>