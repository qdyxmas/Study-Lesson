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
	$sql="select * from comproducts";
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
	$sql="select * from comproducts order by id desc limit $startno,$pagesize";
	$rs=mysql_query($sql);
?>
<table width="799" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC" class="table" >
      <tr>
        <td height="27" colspan="7" align="left" bgcolor="#FFFFFF" class="bg_tr">&nbsp;后台管理&nbsp;&gt;&gt;&nbsp;竞品管理</td>
      </tr>
      <tr>
        <td width="6%" height="35" align="center" bgcolor="#FFFFFF">序号</td>
        <td width="11%" align="center" bgcolor="#FFFFFF">编码</td>
        <td width="14%" align="center" bgcolor="#FFFFFF">存货名称</td>
        <td width="16%" align="center" bgcolor="#FFFFFF">规格型号</td>
        <td width="11%" align="center" bgcolor="#FFFFFF">数量</td>
        <td width="16%" align="center" bgcolor="#FFFFFF">库位</td>
        <td width="11%" align="center" bgcolor="#FFFFFF">备注</td>
        <td width="15%" align="center" bgcolor="#FFFFFF">操作</td>
      </tr>
     <?php
	while($rows=mysql_fetch_assoc($rs))
	{
	?>
<tr align="center">
<td class="td_bg" width="6%"><?php echo $rows["id"]?></td>
<td class="td_bg" width="11%" height="26"><?php echo $rows["code"]?></td>
<td class="td_bg" width="14%" height="26"><?php echo $rows["product_name"]?></td>
<td class="td_bg" width="16%" height="26"><?php echo $rows["model_name"]?></td>
<td width="11%" height="26" class="td_bg"><?php echo $rows["numbers"]?></td>
<td width="16%" height="26" class="td_bg"><?php echo $rows["position"]?></td>
<td width="11%" height="26" class="td_bg"><?php echo $rows["mark"]?></td>
<td class="td_bg" width="15%">
<a href="comproducts_update.php?id=<?php echo $rows[id] ?>" class="trlink">修改</a></td>
</tr>
	<?php
	}
?>
	    <tr>
      <th height="25" colspan="7" align="center" class="bg_tr">
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