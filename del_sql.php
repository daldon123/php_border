<?php
	// require('inc/function.php');
	$id = $_GET['id']; // 데이터 id값
	include('./db/db.php');
	$sqls = $db->query("delete from table01 where id={$id}");
	echo $sqls->affectedRows();

	
	// $del = "delete from table01 where id={$id}";
	// mysqli_query($db,$del);

	Header("Location:del.php");
?>
