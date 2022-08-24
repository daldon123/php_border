<?php
	// require('inc/function.php');
	$id = $_GET['id']; // 데이터 id값
	include('./db/db.php');
	$sqls = $db->query("select * from table01 where id={$id}")->fetchArray();

	// *글보기 변수* 	
	// $show_sql = "select * from table01 where id={$id}";
	
	// $shwo_res = mysqli_query($db, $show_sql);
	// $shwo_row = mysqli_fetch_array($shwo_res);

	// 수정 시 수정하기 페이지에 넘겨줄 정보
	$x_title = $shwo_row['title'];
	$x_name = $shwo_row['name'];
	$x_image = $shwo_row['image'];
	$x_content = $shwo_row['content'];

?>
