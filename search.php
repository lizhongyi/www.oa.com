<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<!--<head>-->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>无标题文档</title>
</head>

<body>
<?
 include('./includes/Page.class1.php');

$conn=@mysql_connect("localhost","root","lizhongyi-009");
if($conn)
echo "成功";
mysql_select_db("erpking",$conn);
mysql_query("SET NAMES UTF8"); 
                            
							
							$where="";
							
							$id=$_GET['id'];
							
							
							$id && $where="and id =$id";
							
							
							$pageCount = mysql_query('select count(*) from eking_works ');
                            $listRows = empty($listRows) ? 10 : $listRows;
							$orderd = empty($orders) ? 'id DESC' : $orders;
							$paged = new page($pageCount, $listRows);

$sql="select * from eking_works where 1=1 $where limit ".$paged->firstRow.",".$paged->listRows."";
$query=mysql_query($sql,$conn);

 while($row=@mysql_fetch_array($query,MYSQL_ASSOC)){
			 
			  $arr[]=$row;
			 
			}
			
			
$pageContentBar = $paged->show();

?>




<form action="" method="get">
关键字：<input name="id" type="text">
<input type="submit" name="sub" value="全站搜索" />

</form>



<h1>结果</h1>
<table border="1">
<tr>
<td width="76">aid</td>
<td width="161">行业</td>
<td width="180">&nbsp;</td>
</tr>

<?php

foreach($arr as $k=>$v){

?>

<tr>
  <td><?php echo $v['id']?></td>
  <td></td>
  <td>&nbsp;</td>
</tr>
<tr>

<?php

}

?>
  <td colspan="3"><?php echo $pageContentBar ;?></td>
  </tr>

</table>

</body>
</html>
