<?php
	$title = '수정하기';
	include('inc/header.php');
	require('./update_sql01.php')
		
?>
	<div class='writebox'>
		<form action="update_sql02.php?id=<?php echo $id ?>" method='post' class='writeFormbox' enctype="multipart/form-data">
			<label for='title'>제목</label>
			<input type='text' id='title' name='title' placeholder='제목을 입력하세요' class='writeinput' value='<?php echo $r_title ?>' required/>
			<label for='name'>닉네임</label>
			<input type='text' id='name' name='name' placeholder='닉네임을 입력하세요' class='writeinput' value='<?php echo $r_name ?>' required/>
			<div  placeholder='내용을 입력해주세요' style='width:100%; height:300px; margin-top:20px; display:flex; flex-direction:column; align-items:center; border:1px solid black;' contentEditable="true" required>
				<?php
					if($r_image){
						echo "<div style='width:40%'>";
						echo "<img style='width:100%' src='image/{$r_image}'></img>";
						echo "</div>";
					}
				?>
				<textarea class='updatetext' name='content' placeholder='내용을 입력해주세요' style='width:60%; height:300px; margin-top:20px; display:flex; flex-direction:column; align-items:center; border:none; resize:none;' required><?php echo $r_content ?></textarea>
			</div>
			<input type='file' name='image' style='margin:10px 0px;' />
			
			<div style='display:flex; justify-content: space-between; width:100%; '>
				<input type='submit' value='수정하기' >
				<input type='button' value='목록으로 돌아가기' onclick="window.location.href='index.php'">
			</div>
		</form>
	</div>
<?php
	include('inc/footer.php');
	// require('./update_sql02.php')
?>