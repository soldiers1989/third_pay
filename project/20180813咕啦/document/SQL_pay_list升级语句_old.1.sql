﻿
INSERT INTO `7k111data1_db`.`pay_list` (pay_name,pay_wyUrl,pay_wxUrl,pay_zfbUrl,is_wx,is_wy,is_zfb,wy_postUrl,wx_postUrl,zfb_postUrl,wy_returnUrl,wx_returnUrl,zfb_returnUrl,wy_synUrl,wx_synUrl,zfb_synUrl,is_direct,is_qq,qq_postUrl,qq_returnUrl,qq_synUrl)
 VALUES ('咕啦', '/pay/pay.php', '/pay/wxpay.php', '/pay/zfbpay.php', '1', '1', '1', '/pay/gula/post.php', '/pay/gula/wxpost.php', '/pay/gula/zfbpost.php', '/pay/gula/return_url.php', '/pay/gula/return_url.php', '/pay/gula/return_url.php', '/pay/gula/notify_url.php', '/pay/gula/notify_url.php', '/pay/gula/notify_url.php', '1', '1', '/pay/gula/qqpost.php', '/pay/gula/return_url.php', '/pay/gula/notify_url.php');

INSERT INTO `7k111data1_db`.`pay_set` (`pay_name`, `mer_id`, `mer_key`, `mer_account`, `pay_domain`, `pay_type`, `is_wy`, `is_wx`, `is_zfb`, `show_name`, `is_qq`)
 VALUES ('咕啦', '', '', NULL, 'http://pay7.5566205.com', '咕啦', '1', '1', '1', '咕啦', '1');

INSERT INTO `testdata1_db`.`pay_list` (pay_name,pay_wyUrl,pay_wxUrl,pay_zfbUrl,is_wx,is_wy,is_zfb,wy_postUrl,wx_postUrl,zfb_postUrl,wy_returnUrl,wx_returnUrl,zfb_returnUrl,wy_synUrl,wx_synUrl,zfb_synUrl,is_direct,is_qq,qq_postUrl,qq_returnUrl,qq_synUrl)
 VALUES ('咕啦', '/pay/pay.php', '/pay/wxpay.php', '/pay/zfbpay.php', '1', '1', '1', '/pay/gula/post.php', '/pay/gula/wxpost.php', '/pay/gula/zfbpost.php', '/pay/gula/return_url.php', '/pay/gula/return_url.php', '/pay/gula/return_url.php', '/pay/gula/notify_url.php', '/pay/gula/notify_url.php', '/pay/gula/notify_url.php', '1', '1', '/pay/gula/qqpost.php', '/pay/gula/return_url.php', '/pay/gula/notify_url.php');

INSERT INTO `testdata1_db`.`pay_set` (`pay_name`, `mer_id`, `mer_key`, `mer_account`, `pay_domain`, `pay_type`, `is_wy`, `is_wx`, `is_zfb`, `show_name`, `is_qq`)
 VALUES ('咕啦', '', '', NULL, 'http://paytest.7k111.com', '咕啦', '1', '1', '1', '咕啦', '1');
