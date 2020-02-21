DROP TABLE IF EXISTS `pre_config`;
create table `pre_config` (
`k` varchar(32) NOT NULL,
`v` text NULL,
PRIMARY KEY  (`k`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `pre_config` VALUES ('version', '2001');
INSERT INTO `pre_config` VALUES ('admin_user', 'admin');
INSERT INTO `pre_config` VALUES ('admin_pwd', '123456');
INSERT INTO `pre_config` VALUES ('admin_paypwd', '123456');
INSERT INTO `pre_config` VALUES ('homepage', '1');
INSERT INTO `pre_config` VALUES ('sitename', '彩虹易支付');
INSERT INTO `pre_config` VALUES ('title', '彩虹易支付 - 行业领先的免签约支付平台');
INSERT INTO `pre_config` VALUES ('keywords', '彩虹易支付,支付宝免签约即时到账,财付通免签约,微信免签约支付,QQ钱包免签约,免签约支付');
INSERT INTO `pre_config` VALUES ('description', '彩虹易支付是郑州追梦网络科技有限公司旗下的免签约支付产品，完美解决支付难题，一站式接入支付宝，微信，财付通，QQ钱包,微信wap，帮助开发者快速集成到自己相应产品，效率高，见效快，费率低！');
INSERT INTO `pre_config` VALUES ('orgname', '郑州追梦网络科技有限公司');
INSERT INTO `pre_config` VALUES ('kfqq', '123456789');
INSERT INTO `pre_config` VALUES ('template', 'index1');
INSERT INTO `pre_config` VALUES ('pre_maxmoney', '1000');
INSERT INTO `pre_config` VALUES ('blockname', '百度云|摆渡|云盘|点券|芸盘|萝莉|罗莉|网盘|黑号|q币|Q币|扣币|qq货币|QQ货币|花呗|baidu云|bd云|吃鸡|透视|自瞄|后座|穿墙|脚本|外挂|模拟|辅助|检测|武器|套装');
INSERT INTO `pre_config` VALUES ('blockalert', '温馨提醒该商品禁止出售，如有疑问请联系网站客服！');
INSERT INTO `pre_config` VALUES ('settle_open', '1');
INSERT INTO `pre_config` VALUES ('settle_type', '1');
INSERT INTO `pre_config` VALUES ('settle_money', '30');
INSERT INTO `pre_config` VALUES ('settle_rate', '0.5');
INSERT INTO `pre_config` VALUES ('settle_fee_min', '0.1');
INSERT INTO `pre_config` VALUES ('settle_fee_max', '20');
INSERT INTO `pre_config` VALUES ('settle_alipay', '1');
INSERT INTO `pre_config` VALUES ('settle_wxpay', '1');
INSERT INTO `pre_config` VALUES ('settle_qqpay', '1');
INSERT INTO `pre_config` VALUES ('settle_bank', '0');
INSERT INTO `pre_config` VALUES ('transfer_alipay', '0');
INSERT INTO `pre_config` VALUES ('transfer_wxpay', '0');
INSERT INTO `pre_config` VALUES ('transfer_qqpay', '0');
INSERT INTO `pre_config` VALUES ('transfer_name', '彩虹易支付');
INSERT INTO `pre_config` VALUES ('transfer_desc', '彩虹易支付自动结算');
INSERT INTO `pre_config` VALUES ('login_qq', '0');
INSERT INTO `pre_config` VALUES ('login_qq_appid', '310786672');
INSERT INTO `pre_config` VALUES ('login_qq_appkey', 'mkgbmYqS8IZzfGqn');
INSERT INTO `pre_config` VALUES ('login_alipay', '0');
INSERT INTO `pre_config` VALUES ('login_alipre_channel', '0');
INSERT INTO `pre_config` VALUES ('login_wx', '0');
INSERT INTO `pre_config` VALUES ('login_wx_channel', '0');
INSERT INTO `pre_config` VALUES ('reg_open', '1');
INSERT INTO `pre_config` VALUES ('reg_pay', '1');
INSERT INTO `pre_config` VALUES ('reg_pre_uid', '1000');
INSERT INTO `pre_config` VALUES ('reg_pre_price', '5');
INSERT INTO `pre_config` VALUES ('verifytype', '1');
INSERT INTO `pre_config` VALUES ('test_open', '1');
INSERT INTO `pre_config` VALUES ('test_pre_uid', '1000');
INSERT INTO `pre_config` VALUES ('mail_cloud', '0');
INSERT INTO `pre_config` VALUES ('mail_smtp', 'smtp.qq.com');
INSERT INTO `pre_config` VALUES ('mail_port', '465');
INSERT INTO `pre_config` VALUES ('mail_name', '');
INSERT INTO `pre_config` VALUES ('mail_pwd', '');
INSERT INTO `pre_config` VALUES ('sms_api', '0');
INSERT INTO `pre_config` VALUES ('captcha_open', '1');
INSERT INTO `pre_config` VALUES ('captcha_id', 'b31335edde91b2f98dacd393f6ae6de8');
INSERT INTO `pre_config` VALUES ('captcha_key', '170d2349acef92b7396c7157eb9d8f47');
INSERT INTO `pre_config` VALUES ('onecode', '1');
INSERT INTO `pre_config` VALUES ('recharge', '1');


DROP TABLE IF EXISTS `pre_cache`;
create table `pre_cache` (
  `k` varchar(32) NOT NULL,
  `v` longtext NULL,
  `expire` int(11) NOT NULL DEFAULT '0',
PRIMARY KEY  (`k`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `pre_anounce`;
create table `pre_anounce` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `content` text DEFAULT NULL,
  `color` varchar(10) DEFAULT NULL,
  `sort` int(11) NOT NULL DEFAULT '1',
  `addtime` datetime DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `pre_type`;
CREATE TABLE `pre_type` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(30) NOT NULL,
  `device` int(1) unsigned NOT NULL DEFAULT '0',
  `showname` varchar(30) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
 PRIMARY KEY (`id`),
 KEY name (`name`,`device`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `pre_type` VALUES (1, 'alipay', 0, '支付宝', 1);
INSERT INTO `pre_type` VALUES (2, 'wxpay', 0, '微信支付', 1);
INSERT INTO `pre_type` VALUES (3, 'qqpay', 0, 'QQ钱包', 1);
INSERT INTO `pre_type` VALUES (4, 'bank', 0, '网银支付', 0);
INSERT INTO `pre_type` VALUES (5, 'jdpay', 0, '京东支付', 0);

DROP TABLE IF EXISTS `pre_plugin`;
CREATE TABLE `pre_plugin` (
  `name` varchar(30) NOT NULL,
  `showname` varchar(60) DEFAULT NULL,
  `author` varchar(60) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `types` varchar(50) DEFAULT NULL,
  `inputs` text DEFAULT NULL,
  `select` text DEFAULT NULL,
 PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `pay_plugin` (`name`, `showname`, `author`, `link`, `types`, `inputs`, `select`) VALUES
('aliold', '支付宝旧版接口', '支付宝', 'https://b.alipay.com/signing/productSetV2.htm', 'alipay', 'appid:合作者身份(PID),appkey:安全校验码(Key)', '1:电脑网站支付,2:手机网站支付'),
('alipay', '支付宝官方支付', '支付宝', 'https://b.alipay.com/signing/productSetV2.htm', 'alipay', 'appid:应用APPID,appkey:支付宝公钥(RSA2),appsecret:商户私钥(RSA2)', '1:电脑网站支付,2:手机网站支付,3:当面付扫码,4:JS支付'),
('epay', '彩虹易支付', '彩虹', 'http://blog.cccyun.cc/', 'alipay,qqpay,wxpay,bank', 'appurl:接口地址,appid:商户ID,appkey:商户密钥', ''),
('jdpay', '京东支付', '京东', 'https://www.jdpay.com/', 'jdpay', 'appid:商户号,appkey:商户DES密钥', ''),
('micro', '小微支付', '小微支付', 'http://blog.cccyun.cc/', 'alipay,wxpay', 'appurl:接口地址,appid:APPID,appkey:APPKEY,appmchid:商户号MCHID', ''),
('qqpay', 'QQ钱包官方支付', 'QQ钱包', 'https://qpay.qq.com/', 'qqpay', 'appid:QQ钱包商户号,appkey:QQ钱包API密钥', '1:扫码支付(包含H5),2:公众号支付'),
('swiftpass', '威富通', '威富通', 'https://www.swiftpass.cn/', 'alipay,wxpay,qqpay,bank,jdpay', 'appid:商户号,appkey:RSA平台公钥,appsecret:RSA应用私钥', '1.手机微信使用公众号支付,1.手机微信使用H5支付'),
('wxpay', '微信官方支付', '微信', 'https://pay.weixin.qq.com/', 'wxpay', 'appid:公众号APPID,appmchid:商户号,appkey:商户支付密钥,appsecret:公众号SECRET', '1:扫码支付,2:公众号支付,3:H5支付'),
('wxpaysl', '微信官方支付服务商版', '微信', 'https://pay.weixin.qq.com/partner/public/home', 'wxpay', 'appid:公众号APPID,appmchid:商户号,appkey:商户支付密钥,appsecret:公众号SECRET,appurl:子商户号', '1:扫码支付,2:公众号支付,3:H5支付');

DROP TABLE IF EXISTS `pre_channel`;
CREATE TABLE `pre_channel` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `type` int(11) unsigned NOT NULL,
  `plugin` varchar(30) NOT NULL,
  `name` varchar(30) NOT NULL,
  `rate` decimal(5,2) NOT NULL DEFAULT '100.00',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `appid` varchar(255) DEFAULT NULL,
  `appkey` text DEFAULT NULL,
  `appsecret` text DEFAULT NULL,
  `appurl` varchar(255) DEFAULT NULL,
  `appmchid` varchar(255) DEFAULT NULL,
  `apptype` varchar(50) DEFAULT NULL,
 PRIMARY KEY (`id`),
 KEY type (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `pre_roll`;
CREATE TABLE `pre_roll` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `type` int(11) unsigned NOT NULL,
  `name` varchar(30) NOT NULL,
  `kind` int(1) unsigned NOT NULL DEFAULT '0',
  `info` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `index` int(11) NOT NULL DEFAULT '0',
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=101;

DROP TABLE IF EXISTS `pre_order`;
CREATE TABLE `pre_order` (
  `trade_no` varchar(64) NOT NULL,
  `out_trade_no` varchar(255) NOT NULL,
  `api_trade_no` varchar(255) DEFAULT NULL,
  `uid` int(11) unsigned NOT NULL,
  `tid` int(11) unsigned NOT NULL DEFAULT '0',
  `type` int(10) unsigned NOT NULL,
  `channel` int(10) unsigned NOT NULL,
  `name` varchar(64) NOT NULL,
  `money` decimal(10,2) NOT NULL,
  `realmoney` decimal(10,2) DEFAULT NULL,
  `getmoney` decimal(10,2) DEFAULT NULL,
  `notify_url` varchar(255) DEFAULT NULL,
  `return_url` varchar(255) DEFAULT NULL,
  `addtime` datetime DEFAULT NULL,
  `endtime` datetime DEFAULT NULL,
  `date` date DEFAULT NULL,
  `domain` varchar(32) DEFAULT NULL,
  `ip` varchar(20) DEFAULT NULL,
  `buyer` varchar(30) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `notify` int(5) NOT NULL DEFAULT '0',
  `invite` int(11) unsigned NOT NULL DEFAULT '0',
  `invitemoney` decimal(10,2) DEFAULT NULL,
 PRIMARY KEY (`trade_no`),
 KEY uid (`uid`),
 KEY out_trade_no (`uid`,`out_trade_no`),
 KEY api_trade_no (`api_trade_no`),
 KEY invite (`invite`),
 KEY date (`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `pre_group`;
CREATE TABLE `pre_group` (
  `gid` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(30) NOT NULL,
  `info` varchar(255) DEFAULT NULL,
  `isbuy` tinyint(1) NOT NULL DEFAULT 0,
  `price` decimal(10,2) DEFAULT NULL,
  `sort` int(10) NOT NULL DEFAULT 0,
  `expire` int(10) NOT NULL DEFAULT 0,
 PRIMARY KEY (`gid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `pre_group` (`gid`, `name`, `info`) VALUES
(0, '默认用户组', '{"1":{"type":"","channel":"-1","rate":""},"2":{"type":"","channel":"-1","rate":""},"3":{"type":"","channel":"-1","rate":""}}');

DROP TABLE IF EXISTS `pre_user`;
CREATE TABLE `pre_user` (
  `uid` int(11) unsigned NOT NULL auto_increment,
  `gid` int(11) unsigned NOT NULL DEFAULT 0,
  `upid` int(11) unsigned NOT NULL DEFAULT 0,
  `key` varchar(32) NOT NULL,
  `pwd` varchar(32) DEFAULT NULL,
  `account` varchar(32) DEFAULT NULL,
  `username` varchar(32) DEFAULT NULL,
  `codename` varchar(32) DEFAULT NULL,
  `settle_id` int(1) NOT NULL DEFAULT '1',
  `alipre_uid` varchar(32) DEFAULT NULL,
  `qq_uid` varchar(32) DEFAULT NULL,
  `wxid` varchar(32) DEFAULT NULL,
  `money` decimal(10,2) NOT NULL,
  `email` varchar(32) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `qq` varchar(20) DEFAULT NULL,
  `url` varchar(64) DEFAULT NULL,
  `cert` int(1) NOT NULL DEFAULT '0',
  `certno` varchar(18) DEFAULT NULL,
  `certname` varchar(32) DEFAULT NULL,
  `certtime` datetime DEFAULT NULL,
  `addtime` datetime DEFAULT NULL,
  `lasttime` datetime DEFAULT NULL,
  `endtime` datetime DEFAULT NULL,
  `level` int(1) NOT NULL DEFAULT '1',
  `pay` int(1) NOT NULL DEFAULT '1',
  `settle` int(1) NOT NULL DEFAULT '1',
  `keylogin` int(1) NOT NULL DEFAULT '1',
  `apply` int(1) NOT NULL DEFAULT '0',
  `mode` int(1) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '0',
 PRIMARY KEY (`uid`),
 KEY email (`email`),
 KEY phone (`phone`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1000;

DROP TABLE IF EXISTS `pre_settle`;
CREATE TABLE `pre_settle` (
  `id` int(11) NOT NULL auto_increment,
  `uid` int(11) NOT NULL,
  `batch` varchar(20) DEFAULT NULL,
  `auto` int(1) NOT NULL DEFAULT '1',
  `type` int(1) NOT NULL DEFAULT '1',
  `account` varchar(32) NOT NULL,
  `username` varchar(10) NOT NULL,
  `money` decimal(10,2) NOT NULL,
  `realmoney` decimal(10,2) NOT NULL,
  `addtime` datetime DEFAULT NULL,
  `endtime` datetime DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  `transfer_status` int(1) NOT NULL DEFAULT '0',
  `transfer_result` varchar(64) DEFAULT NULL,
  `transfer_date` datetime DEFAULT NULL,
  `result` varchar(64) DEFAULT NULL,
 PRIMARY KEY (`id`),
 KEY uid (`uid`),
 KEY batch (`batch`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `pre_log`;
CREATE TABLE `pre_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0',
  `type` varchar(20) NULL,
  `date` datetime NOT NULL,
  `ip` varchar(20) DEFAULT NULL,
  `city` varchar(20) DEFAULT NULL,
  `data` text NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `pre_record`;
CREATE TABLE `pre_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `action` int(1) NOT NULL DEFAULT '0',
  `money` decimal(10,2) NOT NULL,
  `oldmoney` decimal(10,2) NOT NULL,
  `newmoney` decimal(10,2) NOT NULL,
  `type` varchar(20) DEFAULT NULL,
  `trade_no` varchar(64) DEFAULT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY uid (`uid`),
  KEY trade_no (`trade_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `pre_batch`;
CREATE TABLE `pre_batch` (
  `batch` varchar(20) NOT NULL,
  `allmoney` decimal(10,2) NOT NULL,
  `count` int(11) NOT NULL DEFAULT '0',
  `time` datetime DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
 PRIMARY KEY (`batch`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `pre_regcode`;
CREATE TABLE `pre_regcode` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0',
  `type` int(1) NOT NULL DEFAULT '0',
  `code` varchar(32) NOT NULL,
  `to` varchar(32) DEFAULT NULL,
  `time` int(11) NOT NULL,
  `ip` varchar(20) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY code (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `pre_risk`;
CREATE TABLE `pre_risk` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0',
  `type` int(1) NOT NULL DEFAULT '0',
  `url` varchar(64) DEFAULT NULL,
  `content` varchar(64) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY uid (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;