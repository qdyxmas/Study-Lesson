<?php
include("../config.php");
require_once('ly_check.php');
$sql="delete from lend_record where id=".$_GET[id];
$arry=mysql_query($sql,$conn);
if($arry){
echo "<script> alert('É¾³ý³É¹¦');location='list.php';</script>";
}
else
echo "É¾³ýÊ§°Ü";
?>