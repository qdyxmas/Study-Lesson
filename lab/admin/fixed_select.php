<?php
include("../config.php");
require_once('ly_check.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>Tendaʵ������������ϵͳv0.1</title>
<link rel="stylesheet" href="images/css.css" type="text/css">
</head>
<body>
<table width="799" border="0" align="center" cellpadding="2" cellspacing="1" class="table">
  <tr>
    <td width="799" height="27" valign="top" bgcolor="#FFFFFF" class="bg_tr">&nbsp;��̨����&nbsp;&gt;&gt;&nbsp;�ʲ���ѯ</td>
  <tr>
    <td height="27" valign="top" bgcolor="#FFFFFF" class="bg_tr"><form id="form1" name="form1" method="post" action="" style="margin:0px; padding:0px;">
        <table width="45%" height="42" border="0" align="center" cellpadding="0" cellspacing="0" class="bk">
          <tr>
            <td width="36%" align="center">
              <select name="seltype" id="seltype">
                <option value="cost_center">�ɱ���������</option>
                <option value="cost_id">�ʲ����</option>
                <option value="cost_name">�ʲ�����</option>
                <option value="cost_model">����ͺ�</option>
                <option value="position">���õص�</option>
                <option value="mark">��ע��Ϣ</option>
              </select>            </td>
            <td width="31%" align="center">
              <input type="text" name="coun" id="coun" />            </td>
            <td width="33%" align="center">
            <input type="submit" name="button" id="button" value="��ѯ" onClick="return q_cont();" />            </td>
          </tr>
        </table>
    </form></td>  
  </table>
</td>
  </tr>
</table>
<table width="799" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC" class="table" >
      
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
	$pagesize=10;
	$sql = "select * from cost where ".$_POST[seltype]." like ('%".$_POST[coun]."%')";
	$rs=mysql_query($sql) or die("�������ѯ����!!!");
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
	$sql="select * from cost where ".$_POST[seltype]." like ('%".$_POST[coun]."%') order by id desc limit $startno,$pagesize";
	$rs=mysql_query($sql);
?>
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
<a href="fixed_update.php?id=<?php echo $rows[id] ?>" class="trlink">�޸�</a></td>
</tr>
	<?php
	}
?>
	    <tr>
      <th height="25" colspan="6" align="center" class="bg_tr">
    <?php
	if($pageno==1)
	{
	?>
	��ҳ | ��һҳ | <a href="?pageno=<?php echo $pageno+1?>">��һҳ</a> | <a href="?pageno=<?php echo $_POST[seltype]?>">ĩҳ</a>
	<?php
	}
	else if($pageno==$pagecount)
	{
	?>
	<a href="?pageno=1">��ҳ</a> | <a href="?pageno=<?php echo $pageno-1?>">��һҳ</a> | ��һҳ | ĩҳ
	<?php
	}
	else
	{
	?>
	<a href="?pageno=1">��ҳ</a> | <a href="?pageno=<?php echo $pageno-1?>">��һҳ</a> | <a href="?pageno=<?php echo $pageno+1?>" class="forumRowHighlight">��һҳ</a> | <a href="?pageno=<?php echo $pagecount?>">ĩҳ</a>
	<?php
	}
?>
	&nbsp;ҳ�Σ�<?php echo $pageno ?>/<?php echo $pagecount ?>ҳ&nbsp;����<?php echo $recordcount?>����Ϣ </th>
	  </tr>
</table>
</body>
</html>