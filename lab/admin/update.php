<?php
include("../config.php");
require_once('ly_check.php');
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>Tendaʵ������������ϵͳv0.1</title>
<link rel="stylesheet" href="images/css.css" type="text/css">
<script Language="JavaScript" Type="text/javascript">
<!--
function myform_Validator(theForm)
{

  if (theForm.username.value == "")
  {
    alert("���������ˡ�");
    theForm.username.focus();
    return (false);
  }
    if (theForm.productname.value == "")
  {
    alert("�������Ʒ����");
    theForm.productname.focus();
    return (false);
  }
    if (theForm.back_numbers.value == "")
  {
    alert("�����뻹��������");
    theForm.back_numbers.focus();
    return (false);
  }
 return (true);
 }

//--></script>
</head>
<?php
$sql="select * from lend_record where id=".$_GET[id];
$arr=mysql_query($sql,$conn);
$rows=mysql_fetch_row($arr);
?>
<?php 
if($_POST[action]=="modify"){
$sqlstr = "update lend_record set username = '".$_POST[username]."', productname = '".$_POST[productname]."', lend_time = '".$_POST[lend_time]."', lend_numbers = '".$_POST[lend_numbers]."', back_time = '".$_POST[back_time]."', back_numbers = '".$_POST[back_numbers]."', mark = '".$_POST[mark]."' where id = ".$_GET[id];
// file_get_contents("C:/xampp/htdocs/lab/admin/log.log",var_export($sqlstr,True),FILE_APPEND);
$arry=mysql_query($sqlstr,$conn);
if ($arry){
				echo "<script> alert('�޸ĳɹ�');location='list.php';</script>";
			}
			else{
                // echo $sqlstr;
				echo "<script>alert('�޸�ʧ��');history.go(-1);</script>";
				}

		}
?>
<body>
<form id="myform" name="myform" method="post" action="" onSubmit="return myform_Validator(this)" language="JavaScript" >
    <table width="100%" height="173" border="0" align="center" cellpadding="2" cellspacing="1" class="table">
        <tr>
          <td colspan="2" align="left" class="bg_tr">&nbsp;��̨����&nbsp;&gt;&gt;&nbsp;�������</td>
        </tr>
        <tr>
          <td width="31%" align="right" class="td_bg">����ˣ�</td>
          <td width="69%" class="td_bg">
            <input name="username" type="text" id="username" size="15" maxlength="30" value="<?php echo $rows[1] ?>"/>          </td>
        </tr>
        <tr>
          <td align="right" class="td_bg">��Ʒ����</td>
          <td class="td_bg">
            <input width="69%" name="productname" type="text" id="productname" size="15"  maxlength="30" value="<?php echo $rows[2] ?>"/>         </td>
        </tr>
        <tr>
          <td align="right" class="td_bg">���ʱ�䣺</td>
          <td class="td_bg">
            <input name="lend_time" size="15" type="text" readonly="readonly" id="lend_time" value="<?php echo substr($rows[3],0,11) ?>" />          </td>
        </tr>
        <tr>
          <td align="right" class="td_bg">���������</td>
          <td class="td_bg">
            <input name="lend_numbers" type="lend_numbers" id="lend_numbers" size="15" maxlength="19" value="<?php echo $rows[4] ?>"/>          </td>
        </tr>
        <tr>
          <td align="right" class="td_bg">����ʱ�䣺</td>
          <td class="td_bg">
            <input name="back_time" size="15" type="text" readonly="readonly" id="back_time" value="<?php echo date("Y-m-d"); ?>" />          </td>
        </tr>
        <tr>
          <td align="right" class="td_bg">����������</td>
          <td class="td_bg"><input name="back_numbers" type="text" id="back_numbers" size="15" maxlength="15" />
            </td>
        </tr>
        <tr>
          <td align="right" class="td_bg">��ע��Ϣ��</td>
          <td class="td_bg"><input name="mark" type="text" id="mark" size="15" maxlength="15" />
            </td>
        </tr>
        <tr>
          <td align="right" class="td_bg">
          <input type="hidden" name="action" value="modify">
            <input type="submit" name="button" id="button" value="�ύ" />          </td>
          <td class="td_bg">����
            <input type="reset" name="button2" id="button2" value="����" />       </td>
        </tr>
  </table>
</form>
</body>
</html>