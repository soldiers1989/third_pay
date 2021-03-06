package com.cn.hunst.demo;

import java.text.SimpleDateFormat;
import java.util.Date;
import java.util.HashMap;
import java.util.Map;

import com.cn.hunst.util.HttpUtil;
import com.cn.hunst.util.Signature;

public class CnpPayDemo {
	
	public static void main(String[] args) {
		Map<String, String> paramMap = new HashMap<String, String>();
		paramMap.put("merchant_no", "10000000019");// 商户号
		paramMap.put("amount", "1.1"); //支付金额
		paramMap.put("currency", "156");
		String orderNo = String.valueOf(System.currentTimeMillis()); // 订单编号
		paramMap.put("order_no", orderNo);
//		支付宝WAP支付	10000
		paramMap.put("pay_code","20000");
		Date orderTime = new Date();// 订单时间
		String orderTimeStr = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss").format(orderTime);// 订单时间
		paramMap.put("request_time", orderTimeStr);
		paramMap.put("product_name", "abc");// 商品名称
		paramMap.put("pay_ip", "127.0.0.1");
		paramMap.put("return_url", "http://www.baidu.com");
		paramMap.put("notify_url", "http://www.baidu.com");
		paramMap.put("remark", "支付备注");
		paramMap.put("sign", Signature.sign(paramMap, "abc"));
		String result = HttpUtil.methodPost("http://47.105.46.192:7071/pay/cnp/gateway", paramMap, "utf-8");
	//	String result = HttpUtil.methodPost("http://localhost:8080/pay/cnp/gateway", paramMap, "utf-8");
		System.out.println("返回的参数是：" + result);
		
	}
}
