<?php
	// require('inc/function.php');

	$id = $_GET['id']; // 데이터 id값
	include('./db/db.php');

	$title = $_POST['title'];
	$name = $_POST['name'];
	$content = $_POST['content'];


				
	if($title == true && $name == true && $content == true){
		if($_FILES['image']['name']){
		   $imageFullName = strtolower($_FILES['image']['name']);
		   $imageNameSlice = explode(".",$imageFullName);
		   $imageName = $imageNameSlice[0];
		   $imageType = $imageNameSlice[1];
		   $image_ext = array('jpg','jpeg','gif','png');
		   $dates = date("mdhis",time());
		   $newImage = chr(rand(97,122)).chr(rand(97,122)).$dates.rand(1,9).".".$imageType;
		   $dir = "image/";
		   move_uploaded_file($_FILES['image']['tmp_name'],$dir.$newImage);
		   chmod($dir.$newImage,0777);

			$sqls = $db->query("update table01 set title='{$title}', name='{$name}', content='{$content}', image='{$newImage}' where id={$id})");
			
			if($title == true && $name == true && $content == true){
				echo $sqls->affectedRows();
				// mysqli_query($db, $update_sql1);
				@unlink("./image/{$r_image}");
				Header("Location:./show.php?id={$id}");
			}
		}else{
			// $update_sql2 = "update table01 set title='{$title}', name='{$name}', content='{$content}', image='{$r_image}' where id={$id}";
			$sqls = $db->query("update table01 set title='{$title}', name='{$name}', content='{$content}', image='{$r_image}' where id={$id}");
			echo $sqls->affectedRows();
			// mysqli_query($db, $update_sql2);
			Header("Location:./show.php?id={$id}");
		}

	}
?>