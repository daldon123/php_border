<html>
<head>
	<link href="index.css" rel="stylesheet" type="text/css">
	<title>홍영호 php 게시판/글쓰기</title>
</head>
<body>
	<h1 class='titleh2'>글쓰기</h1>
	<?php
		
	?>
	<div class='writebox'>
		<!-- index.php -->
		<form action="" method='post' class='writeFormbox' enctype="multipart/form-data">
			<label for='title'>제목</label>
			<input type='text' id='title' name='title' placeholder='제목을 입력하세요' class='writeinput' required/>
			<label for='name'>닉네임</label>
			<input type='text' id='name' name='name' placeholder='닉네임을 입력하세요' class='writeinput' required/>
			<textarea name='content' placeholder='내용을 입력해주세요' style='width:100%; height:300px; margin-top:20px;' required></textarea>
			<input type='file' name='image' style="margin:10px 0px;" />
			<div style='display:flex; justify-content: space-between; width:100%; '>
				<input type='submit' value='글쓰기' >
				<input type='button' value='목록으로 돌아가기' onclick="window.location.href='index.php'">
			</div>
		</form>
	</div>

	<?php
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
			
		echo "이미지파일:".$newImage."<br/>";
			
	
		$title = $_POST['title'];
		$name = $_POST['name'];
		$content = $_POST['content'];
		
		echo "방금쓴 제목:".$title."<br/>";
		echo "방금쓴 이름:".$name."<br/>";
		echo "방금쓴 글내용:".$content."<br/>";
	
		$db2 = mysqli_connect("localhost", "root", "123456", "test01");
		$sql2 = "insert into table01(title, content, time, name, image) values( '{$title}', '{$content}' , now() , '{$name}' ,'{$newImage}')";
		echo $sql2;
	
	
		if($title == true && $name == true && $content == true){
			mysqli_query($db2,$sql2);
			

			Header("Location:./index.php");
		}
	
		$dumy = "insert into table01(title, content, time, name) values( 'test', 'test' , now() , 'tester' );";
		

	?>

</body>
</html>