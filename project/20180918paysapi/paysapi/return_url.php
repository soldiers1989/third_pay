<? header("content-Type: text/html; charset=UTF-8"); ?>
<?php
include_once("../../../database/mysql.php");//现数据库的连接方式
include_once("../moneyfunc.php");

#接收资料
#REQUEST方法
$data = array();
foreach ($_REQUEST as $key => $value) {
	$data[$key] = $value;
	write_log("return:".$key."=".$value);
}
$manyshow = 0;
if(!empty($data)){
	$manyshow = 1;
	#设定固定参数
	$order_no = $data['orderid']; //订单号
	// $success_msg = $data['is_success'];//成功讯息
	// $success_code = "1";//文档上的成功讯息
	$sign = $data['key'];//签名
	$echo_msg = "";//回调讯息

	#根据订单号读取资料库
	$params = array(':m_order' => $order_no);
	$sql = "select operator from k_money where m_order=:m_order";
	$stmt = $mysqlLink->sqlLink("read1")->prepare($sql);//现数据库的连接方式
	$stmt->execute($params);
	$row = $stmt->fetch();

	#获取该订单的支付名称
	$pay_type = substr($row['operator'], 0, strripos($row['operator'], "_"));
	$params = array(':pay_type' => $pay_type);
	$sql = "select * from pay_set where pay_type=:pay_type";
	$stmt = $mysqlLink->sqlLink("read1")->prepare($sql);//现数据库的连接方式
	$stmt->execute($params);
	$payInfo = $stmt->fetch();
	$pay_mid = $payInfo['mer_id'];
	$pay_mkey = $payInfo['mer_key'];
	$pay_account = $payInfo['mer_account'];
	if ($pay_mid == "" || $pay_mkey == "") {
		echo "非法提交参数";
		exit;
	}

	#验签方式2
	$signtext = "";
	$signtext .= $data['orderid'] . $data['orderuid'] . $data['paysapi_id'] . $data['price'] . $data['realprice'] . $pay_mkey;
	write_log("signtext=".$signtext);
	$mysign = md5($signtext);//签名
	write_log("mysign=".$mysign);


	#到账判断
	if ( $mysign == $sign) {
				$message = ("支付成功");
		}else{
			$message = ('签名不正确！');
		}
	}else{
		$message = ("交易失败");
	}
?>

<!-- Html顯示充值資訊 須改變訂單echo變數名稱-->
<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>支付同步结果展示</title>
    <style type="text/css">
        *,html,body{ background: #fff;font-size: 14px;font-family: "Microsoft Yahei", "微软雅黑"}
        html,body{ width: 100%;margin: 0;padding: 0;}
        table .tips{ background: #F0F0FF;height: 35px;line-height: 35px;padding-left: 5px;font-weight: 600;}
    </style>
</head>
<body>
	<table width="98%" border="1" cellspacing="0" cellpadding="3" bordercolordark="#fff" bordercolorlight="#d3d3d3" style="margin: 10px auto;">
    <tr>
			<td colspan="2" class="tips">处理结果</td>
		</tr>
		<?php 
			if($manyshow == 1){
		?>
		<tr>
			<td style="width: 120px; text-align: right;">订单号：</td>
			<td style="padding-left: 10px;">
				<label id="lborderno"><?php echo $order_no; ?></label>
			</td>
		</tr>
		<?php
			}
		?>
		<tr>
			<td style="width: 120px; text-align: right;">处理结果：</td>
			<td style="padding-left: 10px;">
				<label id="lbmessage"><?php echo $message; ?></label>
			</td>
		</tr>
		<tr>
			<td style="width: 120px; text-align: right;">备注：</td>
			<td style="padding-left: 10px;">
				<label id="lbmessage">该页面仅作为通知用，若与支付平台不相符时，则以支付平台结果为准</label>
			</td>
		</tr>
		
	</table>
</body>
</html>