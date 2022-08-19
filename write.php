<?php
	$title = '글쓰기';
	include('inc/header.php');
	require('inc/function.php');
?>
	<div class='writebox'>
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

	$insert_sql = "insert into table01(title, content, time, name, image) values( '{$title}', '{$content}' , now() , '{$name}' ,'{$newImage}')";
	if($title == true && $name == true && $content == true){
		mysqli_query($db, $insert_sql);
		Header("Location:./index.php");
	}

	include('inc/footer.php');
?>