<?php
/***********************************************************
    [EasyTalk] (C)2009 - 2011 nextsns.com
    This is NOT a freeware, use is subject to license terms

    @Filename Function.php $

    @Author hjoeson $

    @Date 2011-01-09 08:45:20 $
*************************************************************/

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

function StrLenW($str){
    return mb_strlen($str,'UTF8');
}

function StrLenW2($str){
    return (strlen($str)+mb_strlen($str,'UTF8'))/2;
}

function daddslashes($string) {
    $string=str_replace("'",'"',$string);
    !defined('MAGIC_QUOTES_GPC') && define('MAGIC_QUOTES_GPC', get_magic_quotes_gpc());
    if(!MAGIC_QUOTES_GPC) {
        if(is_array($string)) {
            foreach($string as $key => $val) {
                $string[$key] = daddslashes($val);
            }
        } else {
            $string = addslashes($string);
        }
    }
	return $string;
}

function sethead($head) {
    //ucenter头像
    if (ET_UC==TRUE) {
        return UC_API."/avatar.php?uid=".$head."&size=middle";
    }
    if (getsubstr($head,0,4,false)=='http') {
        return $head;
    } else if (getsubstr($head,-4,1,false)!='.') {
        return __PUBLIC__."/images/noavatar.jpg";
    } else {
        return $head?__PUBLIC__."/attachments/head/".$head:__PUBLIC__."/images/noavatar.jpg";
    }
}

function setvip($user_auth) {
    return $user_auth==1?'vip':'';
}

function timeop($time,$type="talk") {
    $ntime=time()-$time;
    if ($ntime<60) {
        return("刚才");
    } elseif ($ntime<3600) {
        return(intval($ntime/60)."分钟前");
    } elseif ($ntime<3600*24) {
        return(intval($ntime/3600)."小时前");
    } else {
        if ($type=="talk") {
            return(gmdate('m月d日 H:i',$time+8*3600));
        } else {
            return(gmdate('Y-m-d H:i',$time+8*3600));
        }

    }
}

function randStr($len=6) {
    $chars='ABDEFGHJKLMNPQRSTVWXY123456789';
    mt_srand((double)microtime()*1000000*getmypid());
    $password='';
    while(strlen($password)<$len)
    $password.=substr($chars,(mt_rand()%strlen($chars)),1);
    return $password;
}

function getsubstr($string, $start = 0,$sublen,$append=true) {
    $pa = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/";
    preg_match_all($pa, $string, $t_string);

    if(count($t_string[0]) - $start > $sublen && $append==true) {
        return join('', array_slice($t_string[0], $start, $sublen))."...";
    } else {
        return join('', array_slice($t_string[0], $start, $sublen));
    }
}

//过滤html
function clean_html($html) {
    $html = nl2br($html);
    $html = str_replace(array("<br />","<br/>","<br>","\r","\n","\r\n","#输入话题标题#"), " ", $html);
    $html = eregi_replace('<("|\')?([^ "\']*)("|\')?.*>([^<]*)<([^<]*)>', '\4', $html);
    $html = preg_replace('#</?.*?\>(.*?)</?.*?\>#i','',$html);
    $html = preg_replace('#(.*?)\[(.*?)\](.*?)javascript(.*?);(.*?)\[/(.*?)\](.*?)#','', $html);
    $html = preg_replace('#javascript(.*?)\;#','', $html);
    $html = htmlspecialchars($html);
    return($html);
}

//缓存目录分组
function cachedir($uid) {
    return strtolower(substr(md5($uid),0,1));
}

//链接过滤
function clean_http($html) {
    $html = preg_replace('`((?:https?|ftp?|http):\/\/([a-zA-Z0-9-.?=&_\/:]*)/?)`si','',$html);
    return($html);
}

//过滤链接ubb等
function ubbreplace($content) {
    $cbody=preg_replace("/\[(F l=.*|V h=.*|M|AT .*|U.*|T)\](\S+?)\[\/.*\]/i","$2",$content);
    return $cbody;
}

function simplecontent($content,$len=50) {
    $sc=clean_html(trim($content));
    $sc=ubbreplace($sc);
    $sc=clean_http($sc);
    if ($len!=0) {
        $sc=getsubstr($sc,0,$len,true);
    }
    $sc=$sc?$sc:"还没有说什么！";
    return $sc;
}

function usertemp($user) {
    if ($user) {
        $css.='body {';
        if ($user['theme_bgcolor']){
            $css.="background:$user[theme_bgcolor]";
        }
        if ($user['theme_bgurl']) {
            if ($user['theme_pictype']=="repeat"){
                $css.=" url('".__PUBLIC__."/attachments/".thumb2theme($user[theme_bgurl])."') repeat left top";
            } else if ($user['theme_pictype']=="center") {
                $css.=" url('".__PUBLIC__."/attachments/".thumb2theme($user[theme_bgurl])."') no-repeat center top;background-attachment: fixed";
            } else if ($user['theme_pictype']=="left") {
                $css.=" url('".__PUBLIC__."/attachments/".thumb2theme($user[theme_bgurl])."') no-repeat left top; background-attachment: fixed";
            }
        }
        if ($user['theme_text']){
            $css.=";color:$user[theme_text]";
        }
        $css.='}';
        if ($user['theme_link']) {
            $css.="a {color:$user[theme_link]}
            a:hover {text-decoration:underline;}
            #navigation li a:hover { background:$user[theme_link];color:#ffffff }
            #navigation .selected a { background:$user[theme_link];color:#ffffff }
            .light .stamp a { color:$user[theme_link]; border-color:$user[theme_link];}
            #sidebar a:hover {color:$user[theme_link]; border-color:$user[theme_link];}
            a:hover .label { border-bottom:1px solid $user[theme_link];}";
        }
        if ($user['theme_sidebar']){
            $css.="#sidebar {background:$user[theme_sidebar]}";
        }
        if ($user['theme_sidebox']){
            $css.="#sidebar,.userauth{border-color:$user[theme_sidebox]}
            #sidebar .homestabs .menu li a {border-top:1px dashed $user[theme_sidebox]}
            #sidebar .sect {border-top:1px solid $user[theme_sidebox]}
            #sidebar .first-sect {border:0;background:url('');}
            .sidebang {border-bottom:1px dashed $user[theme_sidebox]}
            .authdot {border-bottom:1px dashed $user[theme_sidebox]}";
        }
        return $css;
    }
}

function getSafeCode($value) {
    if (is_array($value)) {
        foreach ($value as $key=>$val) {
            $value_1 = $val;
            $value_2 = @iconv("utf-8","gb2312",$value_1);
            $value_3 = @iconv("gb2312","utf-8",$value_2);
            $value_4 = @iconv("gb2312","utf-8",$value_1);
            if ($value_1 == $value_3) {
                $value2[$key]=$value_1;
            } else {
                $value2[$key]=$value_4;
            }
        }
        return $value2;
    } else {
        $value_1 = $value;
        $value_2 = @iconv("utf-8","gb2312",$value_1);
        $value_3 = @iconv("gb2312","utf-8",$value_2);
        $value_4 = @iconv("gb2312","utf-8",$value_1);
        if ($value_1 == $value_3) {
            return $value_1;
        } else {
            return $value_4;
        }
    }
}

function thumb2theme($url) {
    return str_replace('thumb_','theme_',$url);
}

//表情过滤
function emotionrp($content) {
    $p= array("(疑问)","(惊喜)","(鄙视)","(呕吐)","(拜拜)","(大笑)","(求)","(色)","(撇嘴)","(调皮)","(流泪)","(偷笑)","(鲜花)","(流汗)","(困)","(惊恐)","(闪人)","(惊讶)","(心)","(发怒)","(发愁)","(投降)","(便便)","(害羞)","(大哭)","(得意)","(跪服)","(难过)","(生气)","(闭嘴)","(抓狂)","(人品)","(钱)","(酷)","(挨打)","(痛打)","(阴险)","(困惑)","(尴尬)","(发呆)","(睡)","(嘘)","(鼻血)","(可爱)","(亲吻)","(寒)","(谢谢)","(顶)","(胜利)");

    $r=array();
    for ($i=0;$i<49;$i++) {
        $r[]="<img class='emo' src='".__PUBLIC__."/images/emotion/".($i+1).".gif' alt='$p[$i]'>";
    }
    return str_replace($p, $r, $content);
}

function getcity($city,$type) {
    $tp=explode(' ',$city);
    if (is_array($tp)) {
        if ($type=='province') {
            return $tp[0];
        } else {
            return $tp[1];
        }
    } else {
        return '';
    }
}

function arraynull($array) {
    if (is_array($array)) {
        foreach($array as $key=>$val) {
            if (trim($val)!=='' && !is_array($val)) {
                return 1;
            } else {
                return arraynull($val);
            }
        }
    }
    return 0;
}

function dfopen($url, $limit = 10485760 , $post = '', $cookie = '', $bysocket = false,$timeout=5,$agent="") {
	if(ini_get('allow_url_fopen') && !$bysocket && !$post) {
		$fp = @fopen($url, 'r');
		$s = $t = '';
		if($fp) {
			while ($t=@fread($fp,2048)) {
				$s.=$t;
			}
			fclose($fp);
		}
		if($s) {
			return $s;
		}
	}
	$return = '';
	$agent=$agent?$agent:"Mozilla/5.0 (compatible; Googlebot/2.1; +http:/"."/www.google.com/bot.html)";
	$matches = parse_url($url);
	$host = $matches['host'];
	$script = $matches['path'].($matches['query'] ? '?'.$matches['query'] : '').($matches['fragment'] ? '#'.$matches['fragment'] : '');
	$script = $script ? $script : '/';
	$port = !empty($matches['port']) ? $matches['port'] : 80;
	if($post) {
		$out = "POST $script HTTP/1.1\r\n";
		$out .= "Accept: */"."*\r\n";
		$out .= "Referer: $url\r\n";
		$out .= "Accept-Language: zh-cn\r\n";
		$out .= "Content-Type: application/x-www-form-urlencoded\r\n";
		$out .= "Accept-Encoding: none\r\n";
		$out .= "User-Agent: $agent\r\n";
		$out .= "Host: $host\r\n";
		$out .= 'Content-Length: '.strlen($post)."\r\n";
		$out .= "Connection: Close\r\n";
		$out .= "Cache-Control: no-cache\r\n";
		$out .= "Cookie: $cookie\r\n\r\n";
		$out .= $post;
	} else {
		$out = "GET $script HTTP/1.1\r\n";
		$out .= "Accept: */"."*\r\n";
		$out .= "Referer: $url\r\n";
		$out .= "Accept-Language: zh-cn\r\n";
		$out .= "Accept-Encoding:\r\n";
		$out .= "User-Agent: $agent\r\n";
		$out .= "Host: $host\r\n";
		$out .= "Connection: Close\r\n";
		$out .= "Cookie: $cookie\r\n\r\n";
	}
	$fp = fsockopen($host, $port, $errno, $errstr, $timeout);
	if(!$fp) {
		return false;
	} else {
		fwrite($fp, $out);
		$return = '';
		while(!feof($fp) && $limit > -1) {
			$limit -= 8192;
			$return .= @fread($fp, 8192);
			if(!isset($status)) {
				preg_match("|^HTTP/[^\s]*\s(.*?)\s|",$return, $status);
				$status=$status[1];
				if($status!=200) {
					return false;
				}
			}
		}
		fclose($fp);
				preg_match("/^Location: ([^\r\n]+)/m",$return,$match);
		if(!empty($match[1]) && $location=$match[1]) {
			if(strpos($location,":/"."/")===false) {
				$location=dirname($url).'/'.$location;
			}
			$args=func_get_args();
			$args[0]=$location;
			return call_user_func_array("dfopen",$args);
		}
		if(false!==($strpos = strpos($return, "\r\n\r\n"))) {
			$return = substr($return,$strpos);
			$return = preg_replace("~^\r\n\r\n(?:[\w\d]{1,8}\r\n)?~","",$return);
			if("\r\n\r\n"==substr($return,-4)) {
				$return = preg_replace("~(?:\r\n[\w\d]{1,8})?\r\n\r\n$~","",$return);
			}
		}

		return $return;
	}
}

//share functions
function get_host($str){
	$list=array(
        "sina.com.cn",
        "youku.com",
        "tudou.com",
        "ku6.com",
        "sohu.com",
        "mofile.com",
	);
	foreach($list as $v){
		if( strpos($str,$v)>0){
			$re= substr($str,strpos($str,$v),100);
			break;
		}
	}
	return $re;
}

function uc_html($text) {
    return '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>正在跳转中...</title><style>body{font-size:12px;margin:0 auto}.box{text-aign:center;width:250px;background:#f1f2f2;color:#000000;padding:15px 100px;margin:200px auto;}</style></head><body><div class="box">'.$text.'</div></body></html>';
}

function makethumb($srcfile,$dstfile,$thumbwidth,$thumbheight,$maxthumbwidth=0,$maxthumbheight=0,$src_x=0,$src_y=0,$src_w=0,$src_h=0) {
    if (!is_file($srcfile)) {
		return '';
	}
	$tow = $thumbwidth;
	$toh = $thumbheight;
	if($tow < 30) {
		$tow = 30;
	}
	if($toh < 30) {
		$toh = 30;
	}
	$make_max = 0;
	$maxtow = $maxthumbwidth;
	$maxtoh = $maxthumbheight;
	if($maxtow >= 300 && $maxtoh >= 300) {
		$make_max = 1;
	}
	$im = '';
	if($data = getimagesize($srcfile)) {
		if($data[2] == 1) {
			$make_max = 0;
            if(function_exists("imagecreatefromgif")) {
				$im = imagecreatefromgif($srcfile);
			}
		} elseif($data[2] == 2) {
			if(function_exists("imagecreatefromjpeg")) {
				$im = imagecreatefromjpeg($srcfile);
			}
		} elseif($data[2] == 3) {
			if(function_exists("imagecreatefrompng")) {
				$im = imagecreatefrompng($srcfile);
			}
		}
	}
	if(!$im) return '';
	$srcw = ($src_w ? $src_w : imagesx($im));
	$srch = ($src_h ? $src_h : imagesy($im));
	$towh = $tow/$toh;
	$srcwh = $srcw/$srch;
	if($towh <= $srcwh){
		$ftow = $tow;
		$ftoh = $ftow*($srch/$srcw);
		$fmaxtow = $maxtow;
		$fmaxtoh = $fmaxtow*($srch/$srcw);
	} else {
		$ftoh = $toh;
		$ftow = $ftoh*($srcw/$srch);
		$fmaxtoh = $maxtoh;
		$fmaxtow = $fmaxtoh*($srcw/$srch);
	}
	if($srcw <= $maxtow && $srch <= $maxtoh) {
		$make_max = 0;	}
	if($srcw >= $tow || $srch >= $toh) {
		if(function_exists("imagecreatetruecolor") && function_exists("imagecopyresampled") && $ni = imagecreatetruecolor($ftow, $ftoh)) {
			imagecopyresampled($ni, $im, 0, 0, $src_x, $src_y, $ftow, $ftoh, $srcw, $srch);
            if($make_max && $maxni = imagecreatetruecolor($fmaxtow, $fmaxtoh)) {
				imagecopyresampled($maxni, $im, 0, 0, $src_x, $src_y, $fmaxtow, $fmaxtoh, $srcw, $srch);
			}
		} elseif(function_exists("imagecreate") && function_exists("imagecopyresized") && $ni = imagecreate($ftow, $ftoh)) {
			imagecopyresized($ni, $im, 0, 0, $src_x, $src_y, $ftow, $ftoh, $srcw, $srch);
			if($make_max && $maxni = imagecreate($fmaxtow, $fmaxtoh)) {
				imagecopyresized($maxni, $im, 0, 0, $src_x, $src_y, $fmaxtow, $fmaxtoh, $srcw, $srch);
			}
		} else {
			return '';
		}
		if(function_exists('imagejpeg')) {
			imagejpeg($ni, $dstfile);
			if($make_max) {
				imagejpeg($maxni, $srcfile);
			}
		} elseif(function_exists('imagepng')) {
			imagepng($ni, $dstfile);
			if($make_max) {
				imagepng($maxni, $srcfile);
			}
		}
		imagedestroy($ni);
		if($make_max) {
			imagedestroy($maxni);
		}
	}
	imagedestroy($im);
	if(!is_file($dstfile)) {
		return '';
	} else {
		return $dstfile;
	}
}

function getExtensionName($filePath){
    $num=strrpos($filePath,'.');
    $len=strlen($filePath);
    $extension=substr($filePath,$num+1,$len-$num);
    return $extension;
}

function shortserver($sid) {
    if ($sid==0) {
        return 'http://goo.gl';
    } else if ($sid==1) {
        return 'http://bit.ly';
    }
}

function get_content($server,$url){
    return file_get_contents('http://gold.sinaapp.com/go/urlget.php?type='.$server.'&url='.urlencode($url));
}

function ubburl($v1,$v2,$shorturl) {
    $st=-1;
    $tp=explode(' ',$v1);
    if (count($tp)==2) {
        $v1=$tp[0];
        $st=$tp[1];
    }
    if ($st==0 || $st==1) {
        $surl=shortserver($st);
    } else {
        $surl=$shorturl;
    }
    return "<a href='".$surl."/{$v1}' target='_blank' title='{$v2}'>".$surl."/{$v1}</a>";
}

function ubbpic($pic1,$pic2,$type) {
    if (getsubstr(trim($pic1),0,4,false)!='http') {
        $pic1=__PUBLIC__.'/attachments'.$pic1;
        $pic2=__PUBLIC__.'/attachments'.$pic2;
    }
    if ($type=='in') {
        return "<div class='imageshow'><a class='miniImg artZoom' href='javascript:void(0)'><img src='".$pic2."' onerror='this.src=\"".__PUBLIC__."/images/noavatar.jpg\"'></a>
        <div class='artZoomBox'>
        <div class='tool'><a title='收起' href='javascript:void(0)' class='hideImg'>收起</a><a title='向右转' href='javascript:void(0)' class='imgRight'>向右转</a><a title='向左转' href='javascript:void(0)' class='imgLeft'>向左转</a><a title='查看原图' href='$1' class='viewImg' target='_blank'>查看原图</a></div>
        <div class='clearline'></div>
        <a class='maxImgLink' href='javascript:void(0)'><img src='".$pic1."' onerror='this.src=\"".__PUBLIC__."/images/noavatar.jpg\"' class='maxImg'></a>
        </div>
        </div>";
    } else if ($type=='out') {
        return "<p><a title='查看原图' href='".$pic1."' target='_blank'><img src='".$pic2."' onerror='this.src=\"".__PUBLIC__."/images/noavatar.jpg\"'></a></p>";
    } else if ($type=='wap') {
        return "<p><a href='".$pic1."' target='_blank'><img src='".$pic2."' onerror='this.src=\"".__PUBLIC__."/images/noavatar.jpg\"' class='photo'></a></p>";
    }
}
?>