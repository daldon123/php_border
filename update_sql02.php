<?php
	require('inc/function.php');

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
		   if(array_search($imageType,$image_ext) === false){
			   errMsg('jpg, jpeg, gif, png 확장자만 가능합니다.');
		   }
		   $dates = date("mdhis",time());
		   $newImage = chr(rand(97,122)).chr(rand(97,122)).$dates.rand(1,9).".".$imageType;
		   $dir = "image/";
		   move_uploaded_file($_FILES['image']['tmp_name'],$dir.$newImage);
		   chmod($dir.$newImage,0777);

			$update_sql1 = "update table01 set title='{$title}', name='{$name}', content='{$content}', image='{$newImage}' where id={$id}";

			echo $update_sql1;
			if($title == true && $name == true && $content == true){
				mysqli_query($db, $update_sql1);
				@unlink("./image/{$r_image}");
				Header("Location:./show.php?id={$id}");
			}
		}else{
			$update_sql2 = "update table01 set title='{$title}', name='{$name}', content='{$content}', image='{$r_image}' where id={$id}";
			echo $update_sql2;
			mysqli_query($db, $update_sql2);
			Header("Location:./show.php?id={$id}");
		}

	}
?>