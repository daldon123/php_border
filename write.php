<?php
	$title = '글쓰기';
	// include('db/db.php');
	include('inc/header.php');
?>
	<div class="write_box">
		<form action="json.php?mode=write" method="post" class="writeFormbox" enctype="multipart/form-data">
			<div class="write_topbox">
				<label for="title">제목</label>
				<input type="text" id="title" name="title" placeholder="제목을 입력하세요" class="writeinput" />
				<label for="name">닉네임</label>
				<input type="text" id="name" name="name" placeholder="닉네임을 입력하세요" class="writeinput" />
			</div>
			<textarea name="content" placeholder="내용을 입력해주세요" class="write_textarea" ></textarea>
			<div class="write_btnbox1">
				<input type="file" name="image"/>
			</div>
			<div class="write_btnbox2">
				<input type="submit" value="글쓰기"/>
				<input type="button" value="목록으로 돌아가기" onclick="window.location.href='index.php'" />
			</div>
		</form>
	</div>
<?php
	include('inc/footer.php');
?>
