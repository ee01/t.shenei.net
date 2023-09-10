<?php
    if (!defined('IN_ET')) exit();

    // ucenter config
    define('UC_CONNECT', 'mysql');
    define('UC_DBHOST', 'localhost');
    define('UC_DBUSER', 'shenebwx_uc');
    define('UC_DBPW', urldecode("%75%63%40%53%68%65%4E%65%69%30%31"));
    define('UC_DBNAME', 'shenebwx_uc');
    define('UC_DBCHARSET', 'gbk');
    define('UC_DBTABLEPRE', '`' . UC_DBNAME . '`.uc_');
    define('UC_DBCONNECT', 0);
    define('UC_CHARSET', 'gbk');
    define('UC_KEY', 'FdCe5cR6kaB2y0hefel4W5y0s06cj1sfzaP4s4sfqbC207D969xbQ3h6b1m6vcCb');
    define('UC_API', 'http://uc.eexx.me');
    define('UC_APPID', '7');
    define('UC_IP', '');
    define('UC_PPP', 20);

    // vesion
    define('ET_VESION', 'X1.3');
    define('ET_RELEASE', '20110418');

    // global config
    define('ET_UC', TRUE);                      //是否开启ucenter ，开启填写 TRUE ，关闭 填写 FALSE
    define('ET_URL','http://t.eexx.me');
    ?>