DROP TABLE IF EXISTS `et_comments`;
CREATE TABLE IF NOT EXISTS `et_comments` (
  `comment_id` int(10) NOT NULL auto_increment,
  `user_id` int(10) NOT NULL,
  `comment_uid` int(10) NOT NULL,
  `content_id` int(10) NOT NULL,
  `comment_body` varchar(200) NOT NULL,
  `dateline` int(10) NOT NULL,
  PRIMARY KEY  (`comment_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `et_tongji`;
CREATE TABLE IF NOT EXISTS `et_tongji` (
    `id` INT( 10 ) NOT NULL auto_increment,
    `nums` INT( 10 ) NOT NULL,
    `dateline` INT( 10 ) NOT NULL,
    `type` VARCHAR( 20 ) NOT NULL,
    PRIMARY KEY  (`id`)
) ENGINE = MYISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `et_comments`;
CREATE TABLE IF NOT EXISTS `et_comments` (
  `comment_id` int(10) NOT NULL auto_increment,
  `user_id` int(10) NOT NULL,
  `comment_uid` int(10) NOT NULL,
  `content_id` int(10) NOT NULL,
  `comment_body` varchar(200) NOT NULL,
  `dateline` int(10) NOT NULL,
  PRIMARY KEY  (`comment_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `et_content`;
CREATE TABLE IF NOT EXISTS `et_content` (
  `content_id` int(10) NOT NULL auto_increment,
  `user_id` int(10) NOT NULL,
  `content_body` varchar(320) NOT NULL,
  `media_body` varchar(200) NOT NULL,
  `posttime` int(10) NOT NULL,
  `type` varchar(50) NOT NULL,
  `filetype` varchar(10) NOT NULL default '0' COMMENT '照片、视频、音乐',
  `retid` int(10) NOT NULL default '0' COMMENT '转发的id',
  `replyid` int(10) NOT NULL default '0' COMMENT '回复的id',
  `replytimes` smallint(6) NOT NULL default '0' COMMENT '回复次数',
  `zftimes` smallint(6) NOT NULL default '0' COMMENT '转发次数',
  PRIMARY KEY  (`content_id`),
  KEY `user_id` (`user_id`),
  FULLTEXT KEY `content_body` (`content_body`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `et_content_mention`;
CREATE TABLE IF NOT EXISTS `et_content_mention` (
  `id` int(10) NOT NULL auto_increment,
  `cid` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `dateline` int(10) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `et_content_topic`;
CREATE TABLE IF NOT EXISTS `et_content_topic` (
    `id` INT( 10 ) NOT NULL auto_increment,
    `topic_id` INT( 10 ) NOT NULL ,
    `content_id` INT( 10 ) NOT NULL,
    PRIMARY KEY  (`id`)
) ENGINE = MYISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `et_favorite`;
CREATE TABLE IF NOT EXISTS `et_favorite` (
  `fav_id` int(10) NOT NULL auto_increment,
  `content_id` int(10) NOT NULL,
  `sc_uid` int(10) NOT NULL,
  PRIMARY KEY  (`fav_id`),
  KEY `sc_uid` (`sc_uid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `et_friend`;
CREATE TABLE IF NOT EXISTS `et_friend` (
  `fri_id` int(10) NOT NULL auto_increment,
  `fid_jieshou` int(10) NOT NULL,
  `fid_fasong` int(10) NOT NULL,
  PRIMARY KEY  (`fri_id`),
  KEY `fid_jieshou` (`fid_jieshou`),
  KEY `fid_fasong` (`fid_fasong`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `et_invitecode`;
CREATE TABLE IF NOT EXISTS `et_invitecode` (
  `id` int(10) NOT NULL auto_increment,
  `invitecode` varchar(15) NOT NULL COMMENT '邀请码',
  `timeline` int(10) NOT NULL COMMENT '有效期',
  `isused` tinyint(1) NOT NULL default '0' COMMENT '是否被使用',
  `user_name` varchar(20) NOT NULL COMMENT '使用者帐号',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `et_messages`;
CREATE TABLE IF NOT EXISTS `et_messages` (
  `message_id` int(10) NOT NULL auto_increment,
  `senduid` int(10) NOT NULL COMMENT '发送者uid',
  `sendtouid` int(10) NOT NULL COMMENT '发送给的uid',
  `messagebody` varchar(300) NOT NULL,
  `sendtime` int(10) NOT NULL,
  `isread` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`message_id`),
  KEY `senduid` (`senduid`),
  KEY `sendtouid` (`sendtouid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `et_mytopic`;
CREATE TABLE IF NOT EXISTS `et_mytopic` (
  `id` int(10) NOT NULL auto_increment,
  `topic` varchar(30) NOT NULL,
  `user_id` int(10) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `et_pubtop`;
CREATE TABLE IF NOT EXISTS `et_pubtop` (
  `id` smallint(5) NOT NULL auto_increment,
  `user_id` int(10) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `et_report`;
CREATE TABLE IF NOT EXISTS `et_report` (
  `id` int(10) NOT NULL auto_increment,
  `user_name` varchar(20) NOT NULL,
  `reporttype` tinyint(1) NOT NULL,
  `reportbody` varchar(300) NOT NULL,
  `dateline` int(10) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `et_system`;
CREATE TABLE IF NOT EXISTS `et_system` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  `contents` longtext NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `et_topic`;
CREATE TABLE IF NOT EXISTS `et_topic` (
  `id` int(10) NOT NULL auto_increment,
  `topicname` varchar(20) NOT NULL COMMENT '话题内容',
  `info` varchar( 200 ) NOT NULL DEFAULT '0' COMMENT '话题描述',
  `topictimes` smallint(6) NOT NULL COMMENT '话题次数',
  `follownum` INT( 10 ) NOT NULL DEFAULT '0' COMMENT '关注人数',
  `tuijian` TINYINT( 1 ) NOT NULL DEFAULT '0' COMMENT '推荐话题',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `et_url`;
CREATE TABLE IF NOT EXISTS `et_url` (
  `id` int(10) NOT NULL auto_increment,
  `key` varchar(10) NOT NULL,
  `url` text NOT NULL,
  `times` int(10) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `et_users`;
CREATE TABLE IF NOT EXISTS `et_users` (
  `user_id` int(10) NOT NULL auto_increment,
  `user_name` varchar(20) NOT NULL,
  `nickname` varchar(20) NOT NULL,
  `password` varchar(32) NOT NULL,
  `user_head` varchar(100) NOT NULL,
  `user_auth` tinyint(1) NOT NULL default '0' COMMENT '用户认证',
  `auth_info` varchar(200) NOT NULL COMMENT '认证信息',
  `mailadres` varchar(50) NOT NULL,
  `live_city` varchar(20) default NULL,
  `signupdate` int(10) NOT NULL,
  `user_gender` varchar(2) default NULL,
  `user_info` varchar(200) NOT NULL,
  `isadmin` tinyint(1) NOT NULL default '0',
  `msg_num` smallint(6) NOT NULL default '0',
  `follow_num` smallint(6) NOT NULL default '0',
  `followme_num` smallint(6) NOT NULL default '0',
  `priread` smallint(6) NOT NULL default '0' COMMENT '未读的私信',
  `newfollownum` smallint(6) NOT NULL default '0' COMMENT '新收听人数',
  `atnum` smallint(6) NOT NULL default '0' COMMENT '新提及',
  `comments` smallint(6) NOT NULL default '0',
  `theme_bgcolor` varchar(7) default NULL,
  `theme_pictype` varchar(10) default NULL,
  `theme_text` varchar(7) default NULL,
  `theme_link` varchar(7) default NULL,
  `theme_sidebar` varchar(7) default NULL,
  `theme_sidebox` varchar(7) default NULL,
  `theme_bgurl` varchar(100) default NULL,
  `auth_email` varchar(50) NOT NULL default '0',
  `userlock` tinyint(1) NOT NULL default '0',
  `last_login` int(10) NOT NULL default '0',
  `login_date` int( 10 ) NOT NULL default '0' COMMENT '登陆统计字段',
  `lastcontent` varchar(250) NOT NULL default '0' COMMENT '最后发表',
  `lastconttime` int(10) NOT NULL default '0' COMMENT '最后发表时间',
  PRIMARY KEY  (`user_id`),
  KEY `user_name` (`user_name`),
  KEY `password` (`password`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `et_usertemplates`;
CREATE TABLE IF NOT EXISTS `et_usertemplates` (
  `ut_id` smallint(6) NOT NULL auto_increment,
  `theme_bgcolor` varchar(7) NOT NULL,
  `theme_pictype` varchar(10) NOT NULL,
  `theme_text` varchar(7) NOT NULL,
  `theme_link` varchar(7) NOT NULL,
  `theme_sidebar` varchar(7) NOT NULL,
  `theme_sidebox` varchar(7) NOT NULL,
  `theme_upload` tinyint(1) NOT NULL,
  `isopen` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`ut_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6;

INSERT INTO `et_system` (`id`, `name`, `title`, `contents`, `description`) VALUES
(1, 'sitename', '网站名称', 'EasyTalk微博客', '网站名称'),
(2, 'subtitle', '副标题', '微博客解决方案', '用于显示在网站名称后的说明性文字'),
(3, 'seokey', '网站关键词', '迷你博客,微博客,开源迷你博客', '网站SEO关键词，多个关键词请用英文逗号隔开'),
(4, 'seodescription', '网站描述', 'EasyTalk为国内领先的中文微博客解决方案,快速搭建,强大的后台管理系统,可整合ucenter', '网站SEO描述，请简要描述网站的内容及特点'),
(5, 'miibeian', '网站备案', '正在备案...', '请填写网站备案号'),
(6, 'badwords', '屏蔽文字', '', '用于屏蔽广播中的敏感字符文字,多个用“|”隔开'),
(7, 'openrewrite', '开启伪静态', '2', '开启伪静态需要您的服务器支持'),
(8, 'smtp_host', '邮件服务器', 'smtp.163.com', '邮件smtp服务器地址'),
(9, 'smtp_user', '邮件用户名', 'XXX@163.com', '邮箱登陆用户名'),
(10, 'smtp_pass', '邮件密码', '', '邮箱登陆密码'),
(11, 'smtp_port', '邮件服务器端口', '25', '邮件服务器端口，默认为25'),
(12, 'closereg', '网站注册方式', '2', '邀请注册开启后必须通过后台生成邀请码邀请用户注册'),
(13, 'webclose', '关闭网站', '0', '关闭网站后用户将不能访问'),
(14, 'userside', '用户侧边', '[{"name":"bangvip","title":"\\u8ba4\\u8bc1\\u540d\\u4eba\\u699c","val":"\\u7cfb\\u7edf\\u9ed8\\u8ba4\\u5185\\u5bb9"},{"name":"custom","title":"\\u610f\\u89c1\\u53cd\\u9988","val":"\\u4f17\\u4eba\\u62fe\\u67f4\\u706b\\u7130\\u9ad8\\uff0c\\u5982\\u60a8\\u6709\\u4efb\\u4f55\\u5efa\\u8bae\\u6b22\\u8fce\\u70b9\\u53d1\\u8868#\\u610f\\u89c1\\u53cd\\u9988#\\u544a\\u8bc9\\u6211\\u4eec\\u3002"}]', '用户侧边栏设置'),
(15, 'proside', '主页侧边', '[{"name":"userfollower","title":"","val":""},{"name":"bangnormal","title":"","val":""}]', '用户主页侧边栏设置'),
(16, 'pubside', '广场侧边', '[{"name":"custom","title":"\\u516c \\u544a","val":"\\u5728\\u8fd9\\u91cc\\u53ef\\u4ee5\\u6dfb\\u52a0\\u516c\\u544a\\u5185\\u5bb9"},{"name":"bangvip","title":"\\u8ba4\\u8bc1\\u540d\\u4eba\\u699c","val":"\\u7cfb\\u7edf\\u9ed8\\u8ba4\\u5185\\u5bb9"},{"name":"bangnormal","title":"\\u4eba\\u6c14\\u4e4b\\u661f\\u699c","val":"\\u7cfb\\u7edf\\u9ed8\\u8ba4\\u5185\\u5bb9"},{"name":"hottopic","title":"\\u70ed\\u95e8\\u8bdd\\u9898","val":"\\u7cfb\\u7edf\\u9ed8\\u8ba4\\u5185\\u5bb9"}]', '广场侧边栏设置'),
(17, 'hottopic_cache_time', '热门话题缓存时间', '7200', '单位秒，建议7200秒'),
(18, 'hotuser_cache_time', '推荐用户缓存时间', '7200', '单位秒，建议7200秒'),
(19, 'userfollow_cache_time', '用户听众缓存时间', '7200', '单位秒，建议7200秒'),
(20, 'index_cache_time', '首页滚动缓存时间', '7200', '单位秒，建议7200秒'),
(21, 'hotusernum', '推荐用户显示个数', '6', '个数可选为6,9,12'),
(22, 'userfollownum', '用户关注听众显示个数', '6', '个数可选为6,9,12'),
(23, 'hottopicnum', '热门话题显示个数', '5', '个数可选为5,10,15'),
(24, 'cachetype', '数据缓存类型', 'file', '默认为文件形式缓存'),
(25, 'memhost', 'memcache主机地址', '127.0.0.1:12211', 'Memcache主机地址及端口，例如(127.0.0.1:12211)'),
(26, 'servicemail', '客服邮箱', 'server@admin.com', '用于发送邀请邮件显示'),
(27, 'inviteword', '邀请用户说明', '我在 EasyTalk 开通微博了，我和朋友们每天都在记录自己的生活点滴，分享自己的心情体会。', '邀请用户说明文字'),
(28, 'loginindex', '默认主页', 'home', '选择默认进入用户主页还是广播大厅'),
(29, 'wateropen', '水印开关', '1', '上传图片增加文字水印开关'),
(30, 'pubusersx', '广场广播过滤', '0', '只显示设置了头像、性别、签名和邮箱认证用户的广播'),
(31, 'regname', '屏蔽注册帐号', '', '屏蔽的注册帐号，系统静态目录名已默认被屏蔽'),
(32, 'googlekey', '谷歌地图API KEY', '', '申请地址：http://code.google.com/intl/zh-CN/apis/maps/signup.html'),
(33, 'mail_mode', '通过SMTP发送邮件', '0', '选择“否”将通过 PHP 函数的 mail 发送(推荐此方式)'),
(34, 'widgetopen', '博客挂件', '1', '是否开启博客挂件'),
(35, 'wapopen', '手机WAP', '1', '是否开启手机WAP'),
(36, 'googlemapopen', '谷歌地图', '1', '是否开启谷歌地图插件'),
(38, 'shorturl', '设置短域名地址', 'http://shorturl.com', '设置短域名地址'),
(39, 'foottongji', '添加页脚统计代码', '', '统计代码将显示在版本号的旁边'),
(40, 'about', '关于我们设置', '<p>EasyTalk是一个开源微博客系统，该系统稳定、高效、迅速，容易上手、管理简便，是一款值得拥有的软件。</p><p>在这里，你可以通过手机、网页等渠道随时随地发消息，时时刻刻看朋友，及时获取好友动态和更多资讯内容。</p>', '在这里面输入关于我们的描述，支持html代码'),
(41, 'contect', '联系我们设置', '你可以通过以下方式来联系我们：<br/><br/><p><b>兰州乐游网络科技有限责任公司</b></p><p>● Email：<a href="mailto:hp5216@163.com">hp5216@163.com</a></p><p>● QQ：365148961</p><p>● 地址：甘肃省兰州市七里河区瓜州路132号</p><p>● 微博：<a href="http://www.nextsns.com/et/hjoeson" target="_blank">http://www.nextsns.com/et/hjoeson</a></p><p>● 电话：0931-2611277</p>', '在这里面输入联系我们的描述，支持html代码'),
(42, 'join', '加入我们设置', '<b>兰州乐游网络科技有限责任公司诚聘</b>：<br/><br/><p>● PHP程序员</p><p>● AS3程序员</p><p>● FLASH原画</p><br/><p>学历不是问题，能力创造价值</p><p>工作地点：<b>兰州市</b></p>', '在这里面输入加入我们的描述，支持html代码'),
(43, 'ad1', '页头通栏广告', '', '支持HTML代码'),
(44, 'ad2', '页尾通栏广告', '', '支持HTML代码'),
(45, 'ad3', '个人空间广告', '', '支持HTML代码'),
(46, 'shortserver', '短域名服务器', '0', '短域名服务器'),
(47, 'welcomemsg', '注册欢迎私信', '感谢您注册本网站微博，我们会为您提供最优质的服务，愿您使用愉快！', '不支持HTML，最多140个字符，可在网站开关里设置是否开启'),
(48, 'openwelpri', '开启欢迎私信', '1', '是否开启注册欢迎私信，私信内容请在网站设置里设置');

INSERT INTO `et_usertemplates` (`ut_id`, `theme_bgcolor`, `theme_pictype`, `theme_text`, `theme_link`, `theme_sidebar`, `theme_sidebox`, `theme_upload`, `isopen`) VALUES
(1, '#d3edfa', 'center', '#333333', '#2b4a78', '#c9f1ff', '#99dbf2', 1, 1),
(2, '#ff2935', 'center', '#333333', '#7d1f0c', '#ff5555', '#ff2727', 1, 1),
(3, '#3a9dcf', 'left', '#21282B', '#00ABFF', '#346C89', 'repeat', 1, 1),
(4, '#942970', 'repeat', '#660044', '#d957ad', '#ffbfea', '#d9a3c7', 1, 1),
(5, '#000000', 'center', '#FFB300', '#00CDFF', '#303336', 'repeat', 1, 1);