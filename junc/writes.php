<?php

	include('../db/db.php');
	
	global $db;

	
	## 데이터
	$id = $_GET['id']; 
	$title   = isset($_POST['title'])? $_POST['title'] : false;
	$name    = isset($_POST['name'])? $_POST['name'] : false;
	$content = isset($_POST['content'])? $_POST['content'] : false;
	$file = $_FILES['image']['name'];

	## img파일
	if($file){
		   $imageFullName = strtolower($_FILES['image']['name']);
		   $imageNameSlice = explode(".",$imageFullName);
		   $imageName = $imageNameSlice[0];
		   $imageType = $imageNameSlice[1];
		   $image_ext = array('jpg','jpeg','gif','png');
		   if(array_search($imageType,$image_ext) === false){
			   $errMsg='jpg, jpeg, gif, png 확장자만 가능합니다.';
		   }
		   $dates = date("mdhis",time());
		   $newImage = chr(rand(97,122)).chr(rand(97,122)).$dates.rand(1,9).".".$imageType;
		   $dir = "../image/";
		   move_uploaded_file($_FILES['image']['tmp_name'],$dir.$newImage);
		   chmod($dir.$newImage,0777);
	}

																									   
	if($title && $name && $content == true){
		// mysqli_query($db, $insert_sql);
		$sqls = $db->query("insert into table01(title, content, time, name, image) values( '{$title}', '{$content}' , now() , '{$name}' ,'{$newImage}')");
		echo $sqls->affectedRows();
		//db 컨트롤러
		Header("Location:../index.php");
	}

?>
