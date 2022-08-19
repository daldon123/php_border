<?php
	$title = '수정하기';
	include('inc/header.php');
	require('inc/function.php');
?>
	<div class='writebox'>
		<form action="" method='post' class='writeFormbox' enctype="multipart/form-data">
			<label for='title'>제목</label>
			<input type='text' id='title' name='title' placeholder='제목을 입력하세요' class='writeinput' value='<?php echo $r_title ?>' required/>
			<label for='name'>닉네임</label>
			<input type='text' id='name' name='name' placeholder='닉네임을 입력하세요' class='writeinput' value='<?php echo $r_name ?>' required/>
			<textarea name='content' placeholder='내용을 입력해주세요' style='width:100%; height:300px; margin-top:20px;' required><?php echo $r_content ?></textarea>
			<input type='file' name='image' style='margin:10px 0px;' />
			
			<div style='display:flex; justify-content: space-between; width:100%; '>
				<input type='submit' value='글쓰기' >
				<input type='button' value='목록으로 돌아가기' onclick="window.location.href='index.php'">
			</div>
		</form>
	</div>
<?php
	include('inc/footer.php');
?>