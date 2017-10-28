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

  if (theForm.code.value == "")
  {
    alert("请输入编码。");
    theForm.code.focus();
    return (false);
  }
    if (theForm.product_name.value == "")
  {
    alert("请输入存货名称。");
    theForm.product_name.focus();
    return (false);
  }
    if (theForm.model_name.value == "")
  {
    alert("请输入规格型号。");
    theForm.model_name.focus();
    return (false);
  }
 return (true);
 }

//--></script>
</head>
<?php
$sql="select * from comproducts where id=".$_GET[id];
$arr=mysql_query($sql,$conn);
$rows=mysql_fetch_row($arr);
?>
<?php 
if($_POST[action]=="modify"){
$sqlstr = "update comproducts set code = '".$_POST[code]."', product_name = '".$_POST[product_name]."', model_name = '".$_POST[model_name]."', numbers = '".$_POST[numbers]."', position = '".$_POST[position]."', mark = '".$_POST[mark]."' where id = ".$_GET[id];
// file_get_contents("C:/xampp/htdocs/lab/admin/log.log",var_export($sqlstr,True),FILE_APPEND);
$arry=mysql_query($sqlstr,$conn);
if ($arry){
				echo "<script> alert('修改成功');location='comproducts_list.php';</script>";
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
          <td colspan="2" align="left" class="bg_tr">&nbsp;后台管理&nbsp;&gt;&gt;&nbsp;竞品资产修改</td>
        </tr>
        <tr>
          <td width="31%" align="right" class="td_bg">编码：</td>
          <td width="69%" class="td_bg">
            <input name="code" type="text" id="code" size="15" maxlength="255" value="<?php echo $rows[1] ?>"/>          </td>
        </tr>
        <tr>
          <td align="right" class="td_bg">存货名称：</td>
          <td class="td_bg">
            <input width="69%" name="product_name" type="text" id="product_name" size="15"  maxlength="255"  value="<?php echo $rows[2] ?>" />         </td>
        </tr>
        <tr>
          <td align="right" class="td_bg">规格型号：</td>
          <td class="td_bg">
            <input name="model_name" size="15" type="text"  id="model_name" maxlength="255"  value="<?php echo $rows[3] ?>" /></td>
        </tr>
        <tr>
          <td align="right" class="td_bg">数量：</td>
          <td class="td_bg">
            <input name="numbers" type="text" id="numbers" size="15" maxlength="255"  value="<?php echo $rows[4] ?>" />          </td>
        </tr>
        <tr>
          <td align="right" class="td_bg">库位：</td>
          <td class="td_bg">
            <input name="position" size="15" type="text" id="position" maxlength="255"  value="<?php echo $rows[5] ?>" />          </td>
        </tr>
        <tr>
          <td align="right" class="td_bg">备注信息：</td>
          <td class="td_bg"><input name="mark" type="text" id="mark" size="15" maxlength="255"  value="<?php echo $rows[6] ?>" />
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