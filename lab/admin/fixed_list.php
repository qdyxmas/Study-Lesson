<?php
include("../config.php");
require_once('ly_check.php');
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>Tendaʵ������������ϵͳv0.1</title>
<link rel="stylesheet" href="images/css.css" type="text/css">
</head>
<body>
<?php
	$pagesize=10;
	$sql="select * from cost";
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
	$sql="select * from cost order by id desc limit $startno,$pagesize";
	$rs=mysql_query($sql);
?>
<table width="799" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC" class="table" >
      <tr>
        <td height="27" colspan="7" align="left" bgcolor="#FFFFFF" class="bg_tr">&nbsp;��̨����&nbsp;&gt;&gt;&nbsp;��������</td>
      </tr>
      <tr>
        <td width="6%" height="35" align="center" bgcolor="#FFFFFF">���</td>
        <td width="11%" align="center" bgcolor="#FFFFFF">�ɱ�����</td>
        <td width="14%" align="center" bgcolor="#FFFFFF">�ʲ����</td>
        <td width="16%" align="center" bgcolor="#FFFFFF">�ʲ�����</td>
        <td width="11%" align="center" bgcolor="#FFFFFF">����ͺ�</td>
        <td width="16%" align="center" bgcolor="#FFFFFF">���õص�</td>
        <td width="11%" align="center" bgcolor="#FFFFFF">��ע</td>
        <td width="15%" align="center" bgcolor="#FFFFFF">����</td>
      </tr>
     <?php
	while($rows=mysql_fetch_assoc($rs))
	{
	?>
<tr align="center">
<td class="td_bg" width="6%"><?php echo $rows["id"]?></td>
<td class="td_bg" width="11%" height="26"><?php echo $rows["cost_center"]?></td>
<td class="td_bg" width="14%" height="26"><?php echo $rows["cost_id"]?></td>
<td class="td_bg" width="16%" height="26"><?php echo $rows["cost_name"]?></td>
<td width="11%" height="26" class="td_bg"><?php echo $rows["cost_model"]?></td>
<td width="16%" height="26" class="td_bg"><?php echo $rows["position"]?></td>
<td width="11%" height="26" class="td_bg"><?php echo $rows["mark"]?></td>
<td class="td_bg" width="15%">
<a href="update.php?id=<?php echo $rows[id] ?>" class="trlink">�޸�</a>&nbsp;&nbsp;<a href="del.php?id=<?php echo $rows[id] ?>" class="trlink">ɾ��</a></td>
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
	��ҳ | ��һҳ | <a href="?pageno=<?php echo $pageno+1?>&id=<?php echo $id?>">��һҳ</a> | <a href="?pageno=<?php echo $pagecount?>&id=<?php echo $id?>">ĩҳ</a>
	<?php
	}
	else if($pageno==$pagecount)
	{
	?>
	<a href="?pageno=1&id=<?php echo $id?>">��ҳ</a> | <a href="?pageno=<?php echo $pageno-1?>&id=<?php echo $id?>">��һҳ</a> | ��һҳ | ĩҳ
	<?php
	}
	else
	{
	?>
	<a href="?pageno=1&id=<?php echo $id?>">��ҳ</a> | <a href="?pageno=<?php echo $pageno-1?>&id=<?php echo $id?>">��һҳ</a> | <a href="?pageno=<?php echo $pageno+1?>&id=<?php echo $id?>" class="forumRowHighlight">��һҳ</a> | <a href="?pageno=<?php echo $pagecount?>&id=<?php echo $id?>">ĩҳ</a>
	<?php
	}
?>
	&nbsp;ҳ�Σ�<?php echo $pageno ?>/<?php echo $pagecount ?>ҳ&nbsp;����<?php echo $recordcount?>����Ϣ </th>
	  </tr>
</table>
</body>
</html>