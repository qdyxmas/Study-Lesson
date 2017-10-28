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
</head>
<body>
<table width="799" border="0" align="center" cellpadding="2" cellspacing="1" class="table">
  <tr>
    <td width="799" height="27" valign="top" bgcolor="#FFFFFF" class="bg_tr">&nbsp;后台管理&nbsp;&gt;&gt;&nbsp;样机查询</td>
  <tr>
    <td height="27" valign="top" bgcolor="#FFFFFF" class="bg_tr"><form id="form1" name="form1" method="post" action="" style="margin:0px; padding:0px;">
        <table width="45%" height="42" border="0" align="center" cellpadding="0" cellspacing="0" class="bk">
          <tr>
            <td width="36%" align="center">
              <select name="seltype" id="seltype">
                <!-- <option value="id">样机序号</option> !-->
                <option value="username">借机人</option>
                <option value="productname">样机名称</option>
              </select>            </td>
            <td width="31%" align="center">
              <input type="text" name="coun" id="coun" />            </td>
            <td width="33%" align="center">
            <input type="submit" name="button" id="button" value="查询" onClick="return q_cont();" />            </td>
          </tr>
        </table>
    </form></td>  
  </table>
</td>
  </tr>
</table>
<table width="799" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC" class="table" >
      
      <tr>
        <td width="6%" height="35" align="center" bgcolor="#FFFFFF">ID</td>
        <td width="8%" align="center" bgcolor="#FFFFFF">借机人</td>
        <td width="14%" align="center" bgcolor="#FFFFFF">产品名</td>
        <td width="10%" align="center" bgcolor="#FFFFFF">借机时间</td>
        <td width="8%" align="center" bgcolor="#FFFFFF">借机数量</td>
        <td width="10%" align="center" bgcolor="#FFFFFF">还机时间</td>
        <td width="8%" align="center" bgcolor="#FFFFFF">还机数量</td>
        <td width="16%" align="center" bgcolor="#FFFFFF">备注</td>
        <td width="15%" align="center" bgcolor="#FFFFFF">操作</td>
      </tr>
<?php
	$pagesize=10;
	$sql = "select * from lend_record where ".$_POST[seltype]." like ('%".$_POST[coun]."%')";
	$rs=mysql_query($sql) or die("请输入查询条件!!!");
	$recordcount=mysql_num_rows($rs);
	$pagecount=($recordcount-1)/$pagesize+1;
	$pagecount=(int)$pagecount;
	$pageno=$_GET["pageno"];
	if($pageno=="")
	{
		$pageno=1;
	}
	if($pageno<1)
	{
		$pageno=1;
	}
	if($pageno>$pagecount)
	{
		$pageno=$pagecount;
	}
	$startno=($pageno-1)*$pagesize;
	$sql="select * from lend_record where ".$_POST[seltype]." like ('%".$_POST[coun]."%') order by id desc limit $startno,$pagesize";
	$rs=mysql_query($sql);
?>
     <?php
	while($rows=mysql_fetch_assoc($rs))
	{
	?>
<tr align="center">
<td class="td_bg" width="6%"><?php echo $rows["id"]?></td>
<td class="td_bg" width="8%" height="26"><?php echo $rows["username"]?></td>
<td class="td_bg" width="14%" height="26"><?php echo $rows["productname"]?></td>
<td class="td_bg" width="10%" height="26"><?php echo  substr($rows["lend_time"],0,11) ?></td>
<td width="8%" height="26" class="td_bg"><?php echo $rows["lend_numbers"]?></td>
<td width="10%" height="26" class="td_bg"><?php echo substr($rows["back_time"],0,11)?></td>
<td width="8%" height="26" class="td_bg"><?php echo $rows["back_numbers"]?></td>
<td width="16%" height="26" class="td_bg"><?php echo $rows["mark"]?></td>
<td class="td_bg" width="15%">
<a href="update.php?id=<?php echo $rows[id] ?>" class="trlink">修改</a>&nbsp;&nbsp;<a href="del.php?id=<?php echo $rows[id] ?>" class="trlink">删除</a></td>
</tr>
	<?php
	}
?>
	    <tr>
      <th height="25" colspan="9" align="center" class="bg_tr">
    <?php
	if($pageno==1)
	{
	?>
	首页 | 上一页 | <a href="?pageno=<?php echo $pageno+1?>">下一页</a> | <a href="?pageno=<?php echo $_POST[seltype]?>">末页</a>
	<?php
	}
	else if($pageno==$pagecount)
	{
	?>
	<a href="?pageno=1">首页</a> | <a href="?pageno=<?php echo $pageno-1?>">上一页</a> | 下一页 | 末页
	<?php
	}
	else
	{
	?>
	<a href="?pageno=1">首页</a> | <a href="?pageno=<?php echo $pageno-1?>">上一页</a> | <a href="?pageno=<?php echo $pageno+1?>" class="forumRowHighlight">下一页</a> | <a href="?pageno=<?php echo $pagecount?>">末页</a>
	<?php
	}
?>
	&nbsp;页次：<?php echo $pageno ?>/<?php echo $pagecount ?>页&nbsp;共有<?php echo $recordcount?>条信息 </th>
	  </tr>
</table>
</body>
</html>