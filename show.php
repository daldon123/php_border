<?php
	$title = '글보기';
	include('db/db.php');
	include('inc/header.php');
	include('inc/helper.php');

	$view_Board = new Board();
	$re 		= $view_Board->view();
	$view 		= isset($re['view']) ? $re['view'] : [];
	$id   		= $re['id'];
?>
	<div class="showbox">
		<div class="showbox_">
			<div class="title_box">
				<p>제목:</p>
				<p>[ <?php echo $view['title']; //제목 ?> ]</p> 
			</div>
			<div class="name_box">
				<p>작성자:</p>
				<p>[ <?php echo $view['name']; //작성자이름?> ]</p>
			</div>
			<div class="content_box">
				<div class="content_box_title">
					<p>본문:</p>
				</div>
				<div class="content_box_content">
					<?php if($view['image']): ?>
						<img style='margin-bottom:10px;' src='image/<?php echo $view['image']; //본문 이미지파일 ?>' />
					<?php endif; ?>
					<?php echo $view['content']; //본문 텍스트 ?>
				</div>
			</div>
		</div>
		<div class="showbox_btn">
			<a href="update.php?id=<?php echo $id ?>" >글수정</a>
			<form action="json.php?id=<?php echo $id ?>&&mode=del" method="post" >
				<input type="hidden" name="img" value="<?php echo $view['image']; //삭제할 이미지 파일 ?>" />
				<input type="submit" value="삭제하기" >
			</form>
			<a href='index.php'>목록으로 돌아가기</a>
		</div>
	</div>
<?php
	include('inc/footer.php');
?>