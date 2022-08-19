<?php
	// *글보기 변수* 	

	$show_sql = "select * from table01 where id={$id}";
	$shwo_res = mysqli_query($db, $show_sql);
	$shwo_row = mysqli_fetch_array($shwo_res);

	$x_title = $shwo_row['title'];
	$x_name = $shwo_row['name'];
	$x_image = $shwo_row['image'];
	$x_content = $shwo_row['content'];

?>
