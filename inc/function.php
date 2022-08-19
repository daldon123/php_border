<?php
	$db = mysqli_connect("localhost", "root", "123456", "test01");
	// db connect
	$id = $_GET['id'];

	// *수정하기
	$r_title = $_GET['title'];
	$r_name = $_GET['name'];
	$r_content = $_GET['content'];
	$r_image = $_GET['image'];
?>