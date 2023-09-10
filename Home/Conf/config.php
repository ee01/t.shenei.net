<?php
//载入公共配置
$config	=	require 'config.inc.php';

//设定项目配置
$array = array(
    'URL_MODEL'=>3,
    'URL_ROUTER_ON'=>true,

    'TMPL_TEMPLATE_SUFFIX'=>'.htm',
    'TMPL_CACHE_TIME'=>0,
    'TMPL_L_DELIM'=>'<{',
    'TMPL_R_DELIM'=>'}>',
    'DATA_CACHE_SUBDIR'=>true,
    'DATA_PATH_LEVEL'=>2,

    'DIFNAME'=>array('admin','home','api','client','index','pub','v','m','setting','dologin','login','logout','register','regcheck','reset','doreset','checkreset','setpass','space','message','find','topic','hot','index','widget','comments','wap','map','plugins','url'),
);

//合并输出配置
return array_merge($config,$array);
?>