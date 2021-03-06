<?php
$gateway_url="https://127.0.0.1:8080/pay/pay.htm";
/**
 * 签名  生成签名串  基于sha1withRSA
 * @param string $data 签名前的字符串
 * @return string 签名串
 */
function sign($data) {
	$certs = array();
	openssl_pkcs12_read(file_get_contents("D:\Java\MyEclipse10.7.1\workspace\pay-interface-1.0.1\merchant_cert.pfx"), 
		$certs,"11111111"); //其中password为你的证书密码
	if(!$certs) return ;
	$signature = '';  
	openssl_sign($data, $signature, $certs['pkey']);
	return base64_encode($signature);
}
/**
 * 验证签名： 
 * @param data：原文 
 * @param signature：签名 
 * @return bool 返回：签名结果，true为验签成功，false为验签失败 
 */  
function verity($data,$signature)  
{  
	$pubKey = file_get_contents("D:\Java\MyEclipse10.7.1\workspace\pay-interface-1.0.1\server_cert.cer");  
	$res = openssl_get_publickey($pubKey);  
	$result = (bool)openssl_verify($data, base64_decode($signature), $res);  
	openssl_free_key($res);
	return $result;  
}
?>