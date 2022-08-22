<?php
	// require('inc/function.php');

	$id = $_GET['id']; // 데이터 id값
	include('./db/db.php');
	


	// *글쓰기 변수*
	if($_FILES['image']['name']){
		   $imageFullName = strtolower($_FILES['image']['name']);
		   $imageNameSlice = explode(".",$imageFullName);
		   $imageName = $imageNameSlice[0];
		   $imageType = $imageNameSlice[1];
		   $image_ext = array('jpg','jpeg','gif','png');
		   if(array_search($imageType,$image_ext) === false){
			   errMsg('jpg, jpeg, gif, png 확장자만 가능합니다.');
		   }
		   $dates = date("mdhis",time());
		   $newImage = chr(rand(97,122)).chr(rand(97,122)).$dates.rand(1,9).".".$imageType;
		   $dir = "image/";
		   move_uploaded_file($_FILES['image']['tmp_name'],$dir.$newImage);
		   chmod($dir.$newImage,0777);
	}

	$title = $_POST['title'];
	$name = $_POST['name'];
	$content = $_POST['content'];
	echo $title;


	$sqls = $db->query("insert into table01(title, content, time, name, image) values( '{$title}', '{$content}' , now() , '{$name}' ,'{$newImage}')");
	echo $sqls->affectedRows();
	//db 컨트롤러
																																	   
	// $insert_sql = "insert into table01(title, content, time, name, image) values( '{$title}', '{$content}' , now() , '{$name}' ,'{$newImage}')";
	if($title == true && $name == true && $content == true){
		mysqli_query($db, $insert_sql);
		Header("Location:./index.php");
	}

?>
