<%@ page language="java" contentType="text/html; charset=UTF-8" pageEncoding="UTF-8" %>
<%@ page import="java.io.*" %>
<%@ page import="com.itrus.util.sign.*" %>

<%
///////////////////////////////////  接收请求参数  ////////////////////////////////////

		// 接收表单提交参数
		request.setCharacterEncoding("UTF-8");
		String merchant_code = request.getParameter("merchant_code");	
		String service_type = request.getParameter("service_type");	
		String interface_version = request.getParameter("interface_version");		
		String sign_type = request.getParameter("sign_type");				
		String order_no = request.getParameter("order_no");
		String trade_no = request.getParameter("trade_no");		

		/** 数据签名
		签名规则定义如下：
		（1）参数列表中，除去sign_type、sign两个参数外，其它所有非空的参数都要参与签名，值为空的参数不用参与签名；
		（2）签名参数排序按照参数名a到z的顺序排序，若遇到相同首字母，则看第二个字母，以此类推，组成规则如下：
		参数名1=参数值1&参数名2=参数值2&……&参数名n=参数值n		*/

		StringBuffer signSrc= new StringBuffer();			
		signSrc.append("interface_version=").append(interface_version).append("&");
		signSrc.append("merchant_code=").append(merchant_code).append("&");
		signSrc.append("order_no=").append(order_no).append("&");			
		signSrc.append("service_type=").append(service_type);			
		if (null != trade_no && !"".equals(trade_no)) {
			signSrc.append("&trade_no=").append(trade_no);	
		}
		
			
		String signInfo = signSrc.toString();
		String sign = "" ;
		if("RSA-S".equals(sign_type)){ // sign_type = "RSA-S"
			
			/** 
			1)merchant_private_key，商户私钥，商户按照《密钥对获取工具说明》操作并获取商户私钥；获取商户私钥的同时，也要获取商户公钥（merchant_public_key）；调试运行
			代码之前首先先将商户公钥上传到商家后台"支付管理"->"公钥管理"（如何获取和上传请查看《密钥对获取工具说明》），不上传商户公钥会导致调试运行代码时报错。
  			2)demo提供的merchant_private_key是测试商户号800004007888的商户私钥，请自行获取商户私钥并且替换	*/	
  			
			String merchant_private_key ="MIICdwIBADANBgkqhkiG9w0BAQEFAASCAmEwggJdAgEAAoGBAOD/K22eGec3qNQmk9LwsjpbJDJE9JYfsTJJQGJhfWsKbcZ9UISKXZxuhSCVaf2z9/pEln5RoE7GNwOrYv8R00P8nRJONHNPaLcf0Y8+c6DBWGVewZKojUzn18uAEGGW5XMjLs5/OU//opRB4ieeSmBJ4jp954XfR4Z57bjOpe/3AgMBAAECgYEArCr2K2JQxfp0aSq/8SkX6Mm3T/QuCPZlXGprJx0coJ0RVVKtG07ZxQtZOY671VQyjEKRukVx2vWYQWmTTkVwl+U71fh1mmiu00Y3odNoERc02ZN0zJmrSuhbcuEv6F8kBATunB55wOZ3jlbkXD9h+KUyePBOkrPb+81LhJ6kZXkCQQD18nQ1U2m9laS8ROJmZ1LuecQ4maaHW3xFxHoM9sS1YcpB3peQuXBrKa483zYADIJV2NYstc0QXMMZIXleKFFzAkEA6jF+xx4q+p/lhH8M3rHucHmkgFce90Jh1eHTdx5czizl3LiOYZ5D7cNL8x7piJDMmzkVz8+OidXm0wf5aT82bQJAP9TSJjjk26hn3dj+7Vbppi0CKTJvjvfGdBD/IDg3a1/a72eG7K/EJnvl1bSUvkSA2yjwxR/V/eYlWHNgnXhXUwJBANA6h+3FfhNvXmSrjqbncAljrwdJ70eMJ29DpoFQZtYPB6Z0FmzniqB6OCqIPr7leHc/j4xBkQwvO1hBy9pvkRUCQEVOGouGVeiXL/MuupUdbdBSV4nkYb9hrqE11gzbLu4A+OCpV8Xwdqu5SqX9Js1mQ6vQwTHu63vyfpxxl7oN9Jw=";
			sign = RSAWithSoftware.signByPrivateKey(signInfo, merchant_private_key);	// 签名   signInfo签名参数排序，  merchant_private_key商户私钥
			System.out.println("RSA-S签名参数排序：" + signInfo.length() + " -->" + signInfo);
			System.out.println("RSA-S签名：" + sign.length() + " -->" + sign + "\n");
		}
		
		if("RSA".equals(sign_type)){ // 数字证书加密方式  sign_type = "RSA"
		
			// 请在商家后台"支付管理"->"证书下载"处申请和下载pfx数字证书，一般要1~3个工作日才能获取到，800004007888.pfx是测试商户号800004007888的数字证书
			String webRootPath = request.getSession().getServletContext().getRealPath("/");
			String merPfxPath = webRootPath + "pfx/800004007888.pfx";						// 商家的pfx证书文件路径
			String merPfxPass = "800004007888";											// 商家的pfx证书密码，初始密码是商户号
			RSAWithHardware mh = new RSAWithHardware();						
			mh.initSigner(merPfxPath, merPfxPass);		  
			sign = mh.signByPriKey(signInfo);											// 签名   signInfo签名参数排序
			System.out.println("RSA商户pfx证书文件路径：" + merPfxPath.length() + " -->" + merPfxPath);
			System.out.println("RSA签名参数排序：" + signInfo.length() + " -->" + signInfo);
			System.out.println("RSA签名：" + sign.length() + " -->" + sign + "\n");
		}

%>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" >
</head>
<body onLoad="document.dinpayForm.submit();">
  <form name="dinpayForm" method="post" action="https://query.zdfmf.com/query" >
	<input type="hidden" name="sign" value="<%=sign%>" />
	<input type="hidden" name="merchant_code" value="<%=merchant_code%>" />
	<input type="hidden" name="service_type" value="<%=service_type%>" />		
	<input type="hidden" name="interface_version" value="<%=interface_version%>" />		
	<input type="hidden" name="sign_type" value="<%=sign_type%>" />		
	<input type="hidden" name="order_no" value="<%=order_no%>"/>
	<input type="hidden" name="trade_no" value="<%=trade_no%>" />	
  </form>
</body>
</html>
