﻿
INSERT INTO `7k111data1_db`.`pay_list` (pay_name,pay_wyUrl,pay_wxUrl,pay_zfbUrl,is_wx,is_wy,is_zfb,wy_postUrl,wx_postUrl,zfb_postUrl,wy_returnUrl,wx_returnUrl,zfb_returnUrl,wy_synUrl,wx_synUrl,zfb_synUrl,is_direct,is_qq,qq_postUrl,qq_returnUrl,qq_synUrl)
 VALUES ('易年', '/pay/pay.php', '/pay/wxpay.php', '/pay/zfbpay.php', '1', '1', '1', '/pay/yinian/post.php', '/pay/yinian/wxpost.php', '/pay/yinian/zfbpost.php', '/pay/yinian/return_url.php', '/pay/yinian/return_url.php', '/pay/yinian/return_url.php', '/pay/yinian/notify_url.php', '/pay/yinian/notify_url.php', '/pay/yinian/notify_url.php', '1', '1', '/pay/yinian/qqpost.php', '/pay/yinian/return_url.php', '/pay/yinian/notify_url.php');

INSERT INTO `7k111data1_db`.`pay_set` (`pay_name`, `mer_id`, `mer_key`, `mer_account`, `pay_domain`, `pay_type`, `is_wy`, `is_wx`, `is_zfb`, `show_name`, `is_qq`)
 VALUES ('易年', 'gl00032739', '1fbcf2d407ed45b1937ee12de4f5323c', NULL, 'http://pay7.5566205.com', '易年', '1', '1', '1', '易年', '1');

INSERT INTO `testdata1_db`.`pay_list` (pay_name,pay_wyUrl,pay_wxUrl,pay_zfbUrl,is_wx,is_wy,is_zfb,wy_postUrl,wx_postUrl,zfb_postUrl,wy_returnUrl,wx_returnUrl,zfb_returnUrl,wy_synUrl,wx_synUrl,zfb_synUrl,is_direct,is_qq,qq_postUrl,qq_returnUrl,qq_synUrl)
 VALUES ('易年', '/pay/pay.php', '/pay/wxpay.php', '/pay/zfbpay.php', '1', '1', '1', '/pay/yinian/post.php', '/pay/yinian/wxpost.php', '/pay/yinian/zfbpost.php', '/pay/yinian/return_url.php', '/pay/yinian/return_url.php', '/pay/yinian/return_url.php', '/pay/yinian/notify_url.php', '/pay/yinian/notify_url.php', '/pay/yinian/notify_url.php', '1', '1', '/pay/yinian/qqpost.php', '/pay/yinian/return_url.php', '/pay/yinian/notify_url.php');

INSERT INTO `testdata1_db`.`pay_set` (`pay_name`, `mer_id`, `mer_key`, `mer_account`, `pay_domain`, `pay_type`, `is_wy`, `is_wx`, `is_zfb`, `show_name`, `is_qq`)
 VALUES ('易年', 'gl00032739', '1fbcf2d407ed45b1937ee12de4f5323c', NULL, 'http://paytest.7k111.com', '易年', '1', '1', '1', '易年', '1');
