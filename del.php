<?php
	$id = $_GET['id'];
	echo "{$id}";

	$db = mysqli_connect("localhost", "root", "123456", "test01");
	$del = "delete from table01 where id={$id}";
	mysqli_query($db,$del);

	echo "<script>alert('삭제되었습니다');</script>";
	echo ("<script>location.href='index.php';</script>");
	
?>