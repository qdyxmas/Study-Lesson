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

  if (theForm.cost_center.value == "")
  {
    alert("����ɱ�������Ϣ��");
    theForm.cost_center.focus();
    return (false);
  }
  if (theForm.cost_id.value == "")
  {
    alert("�������ʲ������Ϣ��");
    theForm.cost_id.focus();
    return (false);
  }
  if (theForm.cost_name.value == "")
  {
    alert("�������ʲ�������Ϣ��");
    theForm.cost_name.focus();
    return (false);
  }
  if (theForm.cost_model.value == "")
  {
    alert("���������ͺš�");
    theForm.cost_model.focus();
    return (false);
  }
  if (theForm.position.value == "")
  {
    alert("��������õص㡣");
    theForm.position.focus();
    return (false);
  }
 return (true);
 }

//--></script>
</head>
<?php
$sql="select * from cost where id=".$_GET[id];
$arr=mysql_query($sql,$conn);
$rows=mysql_fetch_row($arr);
?>
<?php 
if($_POST[action]=="modify"){
$sqlstr = "update cost set cost_center = '".$_POST[cost_center]."', cost_id = '".$_POST[cost_id]."', cost_name = '".$_POST[cost_name]."', cost_model = '".$_POST[cost_model]."', position = '".$_POST[position]."', mark = '".$_POST[mark]."' where id = ".$_GET[id];
// file_get_contents("C:/xampp/htdocs/lab/admin/log.log",var_export($sqlstr,True),FILE_APPEND);
$arry=mysql_query($sqlstr,$conn);
if ($arry){
				echo "<script> alert('�޸ĳɹ�');location='fixed_list.php';</script>";
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
          <td colspan="2" align="left" class="bg_tr">&nbsp;��̨����&nbsp;&gt;&gt;&nbsp;�̶��ʲ��޸�</td>
        </tr>
        <tr>
          <td width="31%" align="right" class="td_bg">�ɱ�����������</td>
          <td width="69%" class="td_bg">
            <input name="cost_center" type="text" id="cost_center" size="15" maxlength="255" value="<?php echo $rows[1] ?>"/>          </td>
        </tr>
        <tr>
          <td align="right" class="td_bg">�ʲ���ţ�</td>
          <td class="td_bg">
            <input width="69%" name="cost_id" type="text" id="cost_id" size="15"  maxlength="255" value="<?php echo $rows[2] ?>"/>         </td>
        </tr>
        <tr>
          <td align="right" class="td_bg">�ʲ����ƣ�</td>
          <td class="td_bg">
            <input name="cost_name" size="15" type="text"  id="cost_name" maxlength="255" value="<?php echo $rows[3] ?>" /></td>
        </tr>
        <tr>
          <td align="right" class="td_bg">����ͺţ�</td>
          <td class="td_bg">
            <input name="cost_model" type="text" id="cost_model" size="15" maxlength="255" value="<?php echo $rows[4] ?>" />          </td>
        </tr>
        <tr>
          <td align="right" class="td_bg">���õص㣺</td>
          <td class="td_bg">
            <input name="position" size="15" type="text" id="position" maxlength="255" value="<?php echo $rows[5] ?>" />          </td>
        </tr>
        <tr>
          <td align="right" class="td_bg">��ע��Ϣ��</td>
          <td class="td_bg"><input name="mark" type="text" id="mark" size="15" maxlength="255" value="<?php echo $rows[6] ?>" />
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