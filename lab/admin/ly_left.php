<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>Tenda实验室样机管理系统v0.1</title>
<style type="text/css">
<!--
body {
	margin:0px;
	padding:0px;
	font-size: 12px;
}
#navigation {
	margin:0px;
	padding:0px;
	width:147px;
}
#navigation a.head {
	cursor:pointer;
	background:url(images/main_34.gif) no-repeat scroll;
	display:block;
	font-weight:bold;
	margin:0px;
	padding:5px 0 5px;
	text-align:center;
	font-size:12px;
	text-decoration:none;
}
#navigation ul {
	border-width:0px;
	margin:0px;
	padding:0px;
	text-indent:0px;
}
#navigation li {
	list-style:none; display:inline;
}
#navigation li li a {
	display:block;
	font-size:12px;
	text-decoration: none;
	text-align:center;
	padding:3px;
}
#navigation li li a:hover {
	background:url(images/tab_bg.gif) repeat-x;
		border:solid 1px #adb9c2;
}
-->
</style>
</head>
<body>
<div  style="height:100%;">
  <ul id="navigation">
    <li> <a class="head">系统设置</a>
      <ul>
        <li><a href="ly_pwd.php" target="rightFrame">密码修改</a></li>
      </ul>
    </li>
    <li> <a class="head">资产管理</a>
      <ul>
        <li><a href="fixed_insert.php" target="rightFrame">资产添加</a></li>
        <li><a href="fixed_select.php" target="rightFrame">资产查询</a></li>
        <li><a href="comproducts_insert.php" target="rightFrame">竞品添加</a></li>
        <li><a href="comproducts_select.php" target="rightFrame">竞品查询</a></li>
      </ul>
    </li>
	 <li><a class="head">借机管理</a>
       <ul>
		<li><a href="add.php" target="rightFrame">借机登记</a></li>
        <li><a href="select.php" target="rightFrame">还机登记</a></li>
      </ul>
    </li>
    <li> <a class="head">版本信息</a>
      <ul>
        <li>
          <div align="center">V0.1</div>
        </li>
      </ul>
    </li>
  </ul>
</div>
</body>
</html>