<?php
	$title = '수정하기';
	include('db/db.php');
	include('inc/helper.php');
	include('inc/header.php');
	
	##수정하기 전 데이터
	$up_Board 		= new Board();
	$re 			= $up_Board->modify();
	$id 			= isset($re['id'])? $re['id'] : false;
	$title 			= isset($re['title'])? $re['title'] : false;
	$name 			= isset($re['name'])? $re['name'] : false;
	$content 		= isset($re['content'])? $re['content'] : false;
	$image 			= isset($re['image'])? $re['image'] : false;
?>
	<div class="update_box">
		<form action="json.php?mode=modify&&id=<?php echo $id ?>" method="post" class="update_box_form" enctype="multipart/form-data">
			<label for="title">제목</label>
			<input type="text" id="title" name="title" placeholder="제목을 입력하세요" class="update_input" value='<?php echo $title ?>' oninvalid="this.setCustomValidity('제목을 입력해주세요')" required/>
			<label for="name">닉네임</label>
			<input type="text" id="name" name="name" placeholder="닉네임을 입력하세요" class="update_input" value='<?php echo $name ?>' oninvalid="this.setCustomValidity('이름을 입력해주세요')" required/>
			<div class="update_content" contentEditable="true">
				<?php if($image): ?>
					<div class="update_image">
						<img src='<?php echo "image/{$image}"; ?>'></img>
					</div>
				<?php endif; ?>
				<textarea class="update_text" name="content" placeholder="내용을 입력해주세요" oninvalid="this.setCustomValidity('내용을 입력해주세요')" required><?php echo $content; //이전 본문 내용 ?></textarea>
			</div>
			<input type="file" name="image" style="margin:10px 0px;" />
			<input type="hidden" name="img" value='<?php echo $image; //이전 본문 이미지 파일 ?>' />
			<div class="update_btn">
				<input type="submit" value="수정하기" >
				<input type="button" value="목록으로 돌아가기" onclick="window.location.href='index.php'">
			</div>
		</form>
	</div>
<?php
	include('inc/footer.php');
?>