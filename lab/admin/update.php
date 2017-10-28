<?php
include("../config.php");
require_once('ly_check.php');
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>Tenda实验室样机管理系统v0.1</title>
<link rel="stylesheet" href="images/css.css" type="text/css">
<script Language="JavaScript" Type="text/javascript">
<!--
function myform_Validator(theForm)
{

  if (theForm.username.value == "")
  {
    alert("请输入借机人。");
    theForm.username.focus();
    return (false);
  }
    if (theForm.productname.value == "")
  {
    alert("请输入产品名。");
    theForm.productname.focus();
    return (false);
  }
    if (theForm.back_numbers.value == "")
  {
    alert("请输入还机数量。");
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
				echo "<script> alert('修改成功');location='list.php';</script>";
			}
			else{
                // echo $sqlstr;
				echo "<script>alert('修改失败');history.go(-1);</script>";
				}

		}
?>
<body>
<form id="myform" name="myform" method="post" action="" onSubmit="return myform_Validator(this)" language="JavaScript" >
    <table width="100%" height="173" border="0" align="center" cellpadding="2" cellspacing="1" class="table">
        <tr>
          <td colspan="2" align="left" class="bg_tr">&nbsp;后台管理&nbsp;&gt;&gt;&nbsp;借机管理</td>
        </tr>
        <tr>
          <td width="31%" align="right" class="td_bg">借机人：</td>
          <td width="69%" class="td_bg">
            <input name="username" type="text" id="username" size="15" maxlength="30" value="<?php echo $rows[1] ?>"/>          </td>
        </tr>
        <tr>
          <td align="right" class="td_bg">产品名：</td>
          <td class="td_bg">
            <input width="69%" name="productname" type="text" id="productname" size="15"  maxlength="30" value="<?php echo $rows[2] ?>"/>         </td>
        </tr>
        <tr>
          <td align="right" class="td_bg">借机时间：</td>
          <td class="td_bg">
            <input name="lend_time" size="15" type="text" readonly="readonly" id="lend_time" value="<?php echo substr($rows[3],0,11) ?>" />          </td>
        </tr>
        <tr>
          <td align="right" class="td_bg">借机数量：</td>
          <td class="td_bg">
            <input name="lend_numbers" type="lend_numbers" id="lend_numbers" size="15" maxlength="19" value="<?php echo $rows[4] ?>"/>          </td>
        </tr>
        <tr>
          <td align="right" class="td_bg">还机时间：</td>
          <td class="td_bg">
            <input name="back_time" size="15" type="text" readonly="readonly" id="back_time" value="<?php echo date("Y-m-d"); ?>" />          </td>
        </tr>
        <tr>
          <td align="right" class="td_bg">还机数量：</td>
          <td class="td_bg"><input name="back_numbers" type="text" id="back_numbers" size="15" maxlength="15" />
            </td>
        </tr>
        <tr>
          <td align="right" class="td_bg">备注信息：</td>
          <td class="td_bg"><input name="mark" type="text" id="mark" size="15" maxlength="15" />
            </td>
        </tr>
        <tr>
          <td align="right" class="td_bg">
          <input type="hidden" name="action" value="modify">
            <input type="submit" name="button" id="button" value="提交" />          </td>
          <td class="td_bg">　　
            <input type="reset" name="button2" id="button2" value="重置" />       </td>
        </tr>
  </table>
</form>
</body>
</html>