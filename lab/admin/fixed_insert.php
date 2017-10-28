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

  if (theForm.username.value == "")
  {
    alert("请输入借机人姓名。");
    theForm.username.focus();
    return (false);
  }
    if (theForm.productname.value == "")
  {
    alert("请输入产品型号。");
    theForm.productname.focus();
    return (false);
  }
    if (theForm.lend_numbers.value == "")
  {
    alert("请输入产品数量。");
    theForm.lend_numbers.focus();
    return (false);
  }
 return (true);
 }

//--></script>
</head>
<?php
if($_POST[action]=="insert"){
$sql = "insert into cost (id,cost_center,cost_id,cost_name,cost_model,position,mark) values('','".$_POST[cost_center]."','".$_POST[cost_id]."','".$_POST[cost_name]."','".$_POST[cost_model]."','".$_POST[position]."','".$_POST[mark]."')";
$arr=mysql_query($sql,$conn);
if ($arr){
		echo "<script language=javascript>alert('添加成功！');window.location='insert_fixed.php'</script>";
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
          <td colspan="2" align="left" class="bg_tr">&nbsp;后台管理&nbsp;&gt;&gt;&nbsp;固定资产添加</td>
        </tr>
        <tr>
          <td width="31%" align="right" class="td_bg">成本中心描述：</td>
          <td width="69%" class="td_bg">
            <input name="cost_center" type="text" id="cost_center" size="15" maxlength="255" />          </td>
        </tr>
        <tr>
          <td align="right" class="td_bg">资产编号：</td>
          <td class="td_bg">
            <input width="69%" name="cost_id" type="text" id="cost_id" size="15"  maxlength="255" />         </td>
        </tr>
        <tr>
          <td align="right" class="td_bg">资产名称：</td>
          <td class="td_bg">
            <input name="cost_name" size="15" type="text"  id="cost_name" maxlength="255" /></td>
        </tr>
        <tr>
          <td align="right" class="td_bg">规格型号：</td>
          <td class="td_bg">
            <input name="cost_model" type="text" id="cost_model" size="15" maxlength="255" />          </td>
        </tr>
        <tr>
          <td align="right" class="td_bg">放置地点：</td>
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