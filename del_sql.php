<?php
	require('inc/function.php');

	$del = "delete from table01 where id={$id}";
	mysqli_query($db,$del);

	Header("Location:del.php");
?>
