<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>- �㿨����</title>
</head>
<style>
*{ font-family:"΢���ź�";font-size:12px}
</style>
<body>
<div style="text-align:center; line-height:22px; margin-top:50px"><strong>��ѡ��㿨</strong></div>
<form name="form1" action="send.asp" method="post">
  <table width="396" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" style="border:#0099FF solid 5px">
    <tr>
      <td height="239" colspan="2" align="center" bordercolor="#00CCFF"><table width="90%" border="0" cellpadding="0" cellspacing="1" bgcolor="#FFFFFF" style="border:#666666 dashed 1px; padding:5px"> 
        <tr>
          <td height="25" colspan="2" align="left" bgcolor="#FFFFFF"><strong>�ֻ���ֵ��</strong></td>
          </tr>
        <tr>
          <td width="32%" height="25" align="left" bgcolor="#FFFFFF"><input name="cardtype" type="radio" value="11" checked="checked" />
            ������</td>
          <td width="32%" align="left" bgcolor="#FFFFFF"><input type="radio" name="cardtype" value="12"  />
��ͨ��</td>
          </tr>
        <tr>
          <td height="25" align="left" bgcolor="#FFFFFF"><input type="radio" name="cardtype" value="10" />
            ���ſ�</td>
          <td align="left" bgcolor="#FFFFFF">&nbsp;</td>
          </tr>
        <tr>
          <td height="25" colspan="2" align="left" bgcolor="#FFFFFF"><strong>��Ϸ�㿨</strong></td>
          </tr>
        <tr>
          <td height="25" align="left" bgcolor="#FFFFFF"><input type="radio" name="cardtype" value="3" />
            ������</td>
          <td align="left" bgcolor="#FFFFFF"><input type="radio" name="cardtype" value="2" />
            ʢ��</td>
        </tr>
        <tr>
          <td height="25" align="left" bgcolor="#FFFFFF"><input type="radio" name="cardtype" value="6" />
            �Ѻ���</td>
          <td align="left" bgcolor="#FFFFFF"><input type="radio" name="cardtype" value="4">
            ������</td>
        </tr>
        <tr>
          <td height="25" align="left" bgcolor="#FFFFFF"><input type="radio" name="cardtype" value="7" />
            ��;��</td>
          <td align="left" bgcolor="#FFFFFF"><input type="radio" name="cardtype" value="8" />
            ���ο�</td>
        </tr>
        <tr>
          <td height="25" align="left" bgcolor="#FFFFFF"><input type="radio" name="cardtype" value="1" />
QQ��</td>
          <td align="left" bgcolor="#FFFFFF"><input type="radio" name="cardtype" value="9" />���׿�</td>
        </tr>

      </table></td>
    </tr>
    <tr>
      <td height="34" align="center"><strong>�� ��</strong>��</td>
      <td><input type="text" name="cardno"></td>
    </tr>
    <tr>
      <td height="34" align="center"><strong>�� ��</strong>��</td>
      <td><input type="text" name="cardpwd"></td>
    </tr>
    <tr>
      <td width="109" height="34" align="center"><strong>��д���</strong></td>
      <td width="277">
      <input name="Price2" type="text" size="10" maxlength="10" />
        Ԫ</td>
    </tr>
    <tr>
      <td height="57" colspan="2" align="center"><input type="submit" name="submit2" value="ȷ�ϸ���" onClick="return checkMoney()" /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" name="submit0" value="������һ��" onClick="history.go(-1)" /> </td>
    </tr>
  </table>
</form>

</html>
</body>
<script language="javascript">
function checkMoney(){
	if(document.form1.Price2.value ==""){
		alert('�������ֵ�Ľ��');
		return false;
	}
	document.form1.submit2.disabled;
}
</script>