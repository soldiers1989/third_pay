<?php
header("Content-type:text/html; charset=utf-8");
include_once("../../../database/mysql.php");
include_once("../moneyfunc.php");

#function
function curl_post($url, $data)
{ #POST访问
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
  curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
  curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $tmpInfo = curl_exec($ch);
  if (curl_errno($ch)) {
    return curl_error($ch);
  }
  return $tmpInfo;
}
function QRcodeUrl($code)
{
  if (strstr($code, "&")) {
    $code2 = str_replace("&", "aabbcc", $code);//有&换成aabbcc
  } else {
    $code2 = $code;
  }
  return $code2;
}

#获取第三方资料(非必要不更动)
$pay_type = $_REQUEST['pay_type'];
$params = array(':pay_type' => $pay_type);
$sql = "select t.pay_name,t.mer_id,t.mer_key,t.mer_account,t.pay_type,t.pay_domain,t1.wy_returnUrl,t1.wx_returnUrl,t1.zfb_returnUrl,t1.wy_synUrl,t1.wx_synUrl,t1.zfb_synUrl from pay_set t left join pay_list t1 on t1.pay_name=t.pay_name where t.pay_type=:pay_type";
$stmt = $mysqlLink->sqlLink('read1')->prepare($sql);
$stmt->execute($params);
$row = $stmt->fetch();
$pay_mid = $row['mer_id'];//商户号
$pay_mkey = $row['mer_key'];//商戶密钥
$pay_account = $row['mer_account'];//商户支付Key
$return_url = $row['pay_domain'] . $row['wx_returnUrl'];//return跳转地址
$merchant_url = $row['pay_domain'] . $row['wx_synUrl'];//notify回传地址
if ($pay_mid == "" || $pay_mkey == "") {
  echo "非法提交参数";
  exit;
}
#固定参数设置
$top_uid = $_REQUEST['top_uid'];
$order_no = getOrderNo();
$mymoney = number_format($_REQUEST['MOAmount'], 2, '.', '');
$form_url = 'http://www.kzqpay.com/Pay_Index.html';
#第三方参数设置
$data = array(
  'pay_memberid' => $pay_mid,//商户ID
  'pay_orderid' => $order_no,//订单号
  'pay_amount' => $mymoney,//金额
  'pay_applydate' => date("Y-m-d H:i:s"),//订单提交时间
  'pay_bankcode' => '',//支付产品编号
  'pay_notifyurl' => $merchant_url,//异步通知地址
  'pay_callbackurl' => $return_url,// 页面跳转地址
  'pay_md5sign' => ""//MD5大写签名
);
#变更参数设置

$scan = 'zfb';
$payType = $pay_type . "_zfb";
$bankname = $pay_type . "->支付宝在线充值";
$data['pay_bankcode'] = '903';//支付宝掃碼(目前沒有掃碼)
if (_is_mobile()) {
  $data['pay_bankcode'] = '904';//支付宝微信
}

#新增至资料库，確認訂單有無重複， function在 moneyfunc.php裡(非必要不更动)
$result_insert = insert_online_order($_REQUEST['S_Name'], $order_no, $mymoney, $bankname, $payType, $top_uid);
if ($result_insert == -1) {
  echo "会员信息不存在，无法支付，请重新登录网站进行支付！";
  exit;
} else if ($result_insert == -2) {
  echo "订单号已存在，请返回支付页面重新支付";
  exit;
}
#签名排列，可自行组字串或使用http_build_query($array)

ksort($data);
$noarr = array('pay_md5sign');
$signtext = '';
foreach ($data as $arr_key => $arr_val) {
  if (!in_array($arr_key, $noarr) && (!empty($arr_val) || $arr_val === 0 || $arr_val === '0')) {
    $signtext .= $arr_key . '=' . $arr_val . '&';
  }
}

$signtext = substr($signtext, 0, -1) . '&key=' . $pay_mkey;
$data['pay_md5sign'] = strtoupper(md5($signtext));

#跳轉方法
$jumpurl = $form_url;
$form_data = $data;
?>
<html>
  <head>
      <title>跳转......</title>
      <meta http-equiv="content-Type" content="text/html; charset=utf-8" />
  </head>
  <body>
      <form name="dinpayForm" method="post" id="frm1" action="<?php echo $jumpurl ?>" target="_self">
          <p>正在为您跳转中，请稍候......</p>
          <?php
          if (isset($form_data)) {
            foreach ($form_data as $arr_key => $arr_value) {
              ?>
              <input type="hidden" name="<?php echo $arr_key; ?>" value="<?php echo $arr_value; ?>" />
          <?php 
        }
      } ?>
      </form>
      <script language="javascript">
          document.getElementById("frm1").submit();
      </script>
   </body>
</html>
