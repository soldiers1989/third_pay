<?php

include_once("./addsign.php");
include_once("../moneyfunc.php");
include_once("../../../database/mysql.config.php");


$S_Name = $_REQUEST['S_Name'];
$top_uid = $_REQUEST['top_uid'];
$pay_type =$_REQUEST['pay_type'];
#跳转qrcode.php网址调试
function QRcodeUrl($code){
  if(strstr($code,"&")){
    $code2=str_replace("&", "aabbcc", $code);//有&换成aabbcc
  }else{
    $code2=$code;
  }
  return $code2;
}


#修正url
function fix_postdata_url($url, $data){
    $post_url='';
    if(substr($url,-1) == '?' || substr($url,-1) == '/'){
      $post_url=substr($url,0,-1)."?".$data;
 }else{
       $post_url=$url."?".$data;
 }
 return $post_url ;
}


#curl请求设定
function curl_post($url, $data){
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
  curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
  $tmpInfo = curl_exec($ch);
  if (curl_errno($ch)) {
    echo(curl_errno($ch));
    exit;
  }
  curl_close($ch);
  return $tmpInfo;
}

if (strstr($_REQUEST['pay_type'], "QQ反扫") || strstr($_REQUEST['pay_type'], "qq反扫")) {
  if (!$_POST['authCode']) {
    $data = array();
    foreach ($_REQUEST as $key => $value) {
      $data[$key] = $value;
    }
    ?>
    <html>
      <head>
          <title>跳转......</title>
          <meta http-equiv="content-Type" content="text/html; charset=utf-8" />
      </head>
      <body>
        <form name="dinpayForm" method="post" id="frm2" action="./fscard.php" target="_self">
            <p>正在为您跳转中，请稍候......</p>
            <input type="hidden" name="file" value="qq" />
            <?php foreach ($data as $arr_key => $arr_value) { ?>
              <input type="hidden" name="<?php echo $arr_key; ?>" value="<?php echo $arr_value; ?>" />
            <?php } ?>
        </form>
          <script language="javascript">
              document.getElementById("frm2").submit();
          </script>
       </body>
    </html>
<?php }}
#获取第三方资料(非必要不更动)
$params = array(':pay_type' => $pay_type);
$sql = "select t.pay_name,t.mer_id,t.mer_key,t.mer_account,t.pay_type,t.pay_domain,t1.wy_returnUrl,t1.wx_returnUrl,t1.zfb_returnUrl,t1.wy_synUrl,t1.wx_synUrl,t1.zfb_synUrl from pay_set t left join pay_list t1 on t1.pay_name=t.pay_name where t.pay_type=:pay_type";
$stmt = $mydata1_db->prepare($sql);
$stmt->execute($params);
$row = $stmt->fetch();
$pay_mid = $row['mer_id'];
$pay_mkey = $row['mer_key'];
$pay_account = $row['mer_account'];
$return_url = $row['pay_domain'] . $row['wx_returnUrl'];//同步
$merchant_url = $row['pay_domain'] . $row['wx_synUrl'];//异步
if ($pay_mid == "" || $pay_mkey == "") {
  echo "非法提交参数";
  exit;
}


#固定参数设置
$form_url = 'http://103.21.141.192:8080/pay/qr.do';
$bank_code = $_REQUEST['bank_code'];
$order_no = getOrderNo();
$notify_url = $merchant_url;
$client_ip = getClientIp();
$pr_key = $pay_mkey;//私钥
$pu_key = $pay_account;//公钥
$order_time = date("YmdHis");


$mymoney = number_format($_REQUEST['MOAmount'], 2, '.', '');
$MOAmount = number_format($_REQUEST['MOAmount']*100, 0, '.', '');
#第三方传值参数设置
$data = array(
"sign" => array(
"str_arr" => array(
"authCode" => $_POST['authCode'],
"goodsDesc" => "pay",
"ip" => $client_ip,
"merchantId" => (int)$pay_mid,
"notifyUrl" => $notify_url,
"outTradeNo" => $order_no,
"payMoney" => (int)$MOAmount,
"payType" => (int)40,
),
"mid_conn" => "=",
"last_conn" => "&",
"encrypt" => array(
"0" => "MD5",
"1" => "upper",
),
"havekey" => "1",
"key_str" => "",
"key" => $pr_key,
),
"authCode" => $_POST['authCode'],
"merchantId" => (int)$pay_mid,
"outTradeNo" => $order_no,
"payMoney" => (int)$MOAmount,
"notifyUrl" => $notify_url,
"payType" => (int)40,
"goodsDesc" => 'pay',
"ip" => $client_ip,
);
#变更参数设定
$scan = 'qq';
$bankname = $pay_type."->QQ钱包在线充值";
$payType = $pay_type."_qq";
if (strstr($_REQUEST['pay_type'], "QQ反扫")||strstr($_REQUEST['pay_type'], "qq反扫")) {
  $form_url = 'http://103.21.141.192:8080/pay/barcode.do';
  $scan = 'qqf';
  $data['sign']['str_arr']['payType'] = (int)42;
  $data['payType'] = (int)42;
  $bankname = $pay_type."->QQ钱包在线充值";
  $payType = $pay_type."_qq";
}else {
  if(_is_mobile()){
  $form_url = 'http://103.21.141.192:8080/pay/h5.do';
  $data['sign']['str_arr']['payType'] = (int)41;
  $data['payType'] = (int)41;
  $data['sign']['str_arr']['returnUrl'] = $return_url;
  $data['returnUrl'] = $return_url;
  }
  unset($data['sign']['str_arr']['authCode']);
  unset($data['authCode']);
}
#新增至资料库，確認訂單有無重複， function在 moneyfunc.php裡(非必要不更动)
$result_insert = insert_online_order($S_Name , $order_no , $mymoney,$bankname,$payType,$top_uid);
if ($result_insert == -1){
  echo "会员信息不存在，无法支付，请重新登录网站进行支付！";
  exit;
} else if ($result_insert == -2){
  echo "订单号已存在，请返回支付页面重新支付";
  exit;
}

#签名排列，可自行组字串或使用http_build_query($array)
foreach ($data as $arr_key => $arr_value) {
  if (is_array($arr_value)) {
    $data[$arr_key] = sign_text($arr_value);
  }
}
foreach ($data as $arr_key => $arr_value) {
  $data_str .= $arr_key.'='.$arr_value.'&';
}
$data_str = substr($data_str,0,-1);

#curl获取响应值
$res = curl_post($form_url,$data_str);
$row = json_decode($res,1);
#跳转qrcode
if ($row['retCode'] == '00') {
  if (_is_mobile() && $scan == 'qq') {
    $url = $row['prepayUrl'];
    $jumpurl = $url;
  }elseif ($scan == 'qqf') {
    echo "正確码：".$row['retCode']."讯息：".$row['retMsg'];
    exit();
  }else {
    $url = $row['qrCodeUrl'];
    $qrurl = QRcodeUrl($url);
    $jumpurl = '../qrcode/qrcode.php?type='.$scan.'&code=' . $qrurl;
  }
?>
<html>
  <head>
      <title>跳转......</title>
      <meta http-equiv="content-Type" content="text/html; charset=utf-8" />
  </head>
  <body>
      <form name="dinpayForm" method="post" id="frm1" action="<?php echo $jumpurl?>" target="_self">
          <p>正在为您跳转中，请稍候......</p>
          <?php
          if(isset($form_data)){
              foreach ($form_data as $arr_key => $arr_value) {
          ?>
              <input type="hidden" name="<?php echo $arr_key; ?>" value="<?php echo $arr_value; ?>" />
          <?php }} ?>
      </form>
      <script language="javascript">
          document.getElementById("frm1").submit();
      </script>
   </body>
</html>
<?php
}else {
  echo "错误码：".$row['retCode']."错误讯息：".$row['retMsg'];
}
