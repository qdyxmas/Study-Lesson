<?php
include("../config.php");
require_once('ly_check.php');
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>Tenda实验室样机管理系统v0.1</title>
<link rel="stylesheet" href="images/css.css" type="text/css">
</head>
<body>
<?php
	$pagesize=10;
	$sql="select * from lend_record";
	$rs=mysql_query($sql);
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
	$sql="select * from lend_record order by id desc limit $startno,$pagesize";
	$rs=mysql_query($sql);
?>
<table width="799" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC" class="table" >
      <tr>
        <td height="27" colspan="9" align="left" bgcolor="#FFFFFF" class="bg_tr">&nbsp;后台管理&nbsp;&gt;&gt;&nbsp;还机管理</td>
      </tr>
      <tr>
        <td width="6%" height="35" align="center" bgcolor="#FFFFFF">ID</td>
        <td width="8%" align="center" bgcolor="#FFFFFF">借机人</td>
        <td width="14%" align="center" bgcolor="#FFFFFF">产品名</td>
        <td width="16%" align="center" bgcolor="#FFFFFF">借机时间</td>
        <td width="8%" align="center" bgcolor="#FFFFFF">借机数量</td>
        <td width="16%" align="center" bgcolor="#FFFFFF">还机时间</td>
        <td width="8%" align="center" bgcolor="#FFFFFF">还机数量</td>
        <td width="9%" align="center" bgcolor="#FFFFFF">备注</td>
        <td width="15%" align="center" bgcolor="#FFFFFF">操作</td>
      </tr>
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
	首页 | 上一页 | <a href="?pageno=<?php echo $pageno+1?>&id=<?php echo $id?>">下一页</a> | <a href="?pageno=<?php echo $pagecount?>&id=<?php echo $id?>">末页</a>
	<?php
	}
	else if($pageno==$pagecount)
	{
	?>
	<a href="?pageno=1&id=<?php echo $id?>">首页</a> | <a href="?pageno=<?php echo $pageno-1?>&id=<?php echo $id?>">上一页</a> | 下一页 | 末页
	<?php
	}
	else
	{
	?>
	<a href="?pageno=1&id=<?php echo $id?>">首页</a> | <a href="?pageno=<?php echo $pageno-1?>&id=<?php echo $id?>">上一页</a> | <a href="?pageno=<?php echo $pageno+1?>&id=<?php echo $id?>" class="forumRowHighlight">下一页</a> | <a href="?pageno=<?php echo $pagecount?>&id=<?php echo $id?>">末页</a>
	<?php
	}
?>
	&nbsp;页次：<?php echo $pageno ?>/<?php echo $pagecount ?>页&nbsp;共有<?php echo $recordcount?>条信息 </th>
	  </tr>
</table>
</body>
</html>