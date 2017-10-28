<?php
include("../config.php");
require_once('ly_check.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
if($_POST[action]=="insert"){
$sql = "insert into comproducts (id,code,product_name,model_name,numbers,position,mark) values('','".$_POST[code]."','".$_POST[product_name]."','".$_POST[model_name]."','".$_POST[numbers]."','".$_POST[position]."','".$_POST[mark]."')";
$arr=mysql_query($sql,$conn);
if ($arr){
		echo "<script language=javascript>alert('添加成功！');window.location='comproducts_insert.php'</script>";
			}
			else{
				echo "<script>alert('添加失败');history.go(-1);</script>";
				}

		}
?>
<body>
<form id="myform" name="myform" method="post" action="" onsubmit="return myform_Validator(this)" language="JavaScript">
      <table width="100%" height="173" border="0" align="center" cellpadding="2" cellspacing="1" class="table">
        <tr>
          <td colspan="2" align="left" class="bg_tr">&nbsp;后台管理&nbsp;&gt;&gt;&nbsp;竞品添加</td>
        </tr>
        <tr>
          <td width="31%" align="right" class="td_bg">编码：</td>
          <td width="69%" class="td_bg">
            <input name="code" type="text" id="code" size="15" maxlength="255" />          </td>
        </tr>
        <tr>
          <td align="right" class="td_bg">存货名称：</td>
          <td class="td_bg">
            <input width="69%" name="product_name" type="text" id="product_name" size="15"  maxlength="255" />         </td>
        </tr>
        <tr>
          <td align="right" class="td_bg">规格型号：</td>
          <td class="td_bg">
            <input name="model_name" size="15" type="text"  id="model_name" maxlength="255" /></td>
        </tr>
        <tr>
          <td align="right" class="td_bg">数量：</td>
          <td class="td_bg">
            <input name="numbers" type="text" id="numbers" size="15" maxlength="255" />          </td>
        </tr>
        <tr>
          <td align="right" class="td_bg">库位：</td>
          <td class="td_bg">
            <input name="position" size="15" type="text" id="position" maxlength="255" />          </td>
        </tr>
        <tr>
          <td align="right" class="td_bg">备注信息：</td>
          <td class="td_bg"><input name="mark" type="text" id="mark" size="15" maxlength="255"/>
            </td>
        </tr>
        <tr>
          <td align="right" class="td_bg">
          <input type="hidden" name="action" value="insert">
            <input type="submit" name="button" id="button" value="提交" />          </td>
          <td class="td_bg">　　
            <input type="reset" name="button2" id="button2" value="重置" />       </td>
        </tr>
  </table>
</form>
</body>
</html>