<?php
$title = '글보기';
include('helper.php');
include('inc/header.php');

$board 		= new Board();
$re 		= $board->view();
$view 		= isset($re['view']) ? $re['view'] : [];
$id   		= isset($re['id']) ? $re['id'] : '';
?>
<div class="showbox">
	<div class="showbox_">
		<div class="title_box">
			<p>제목:</p>
			<p>[ <?php echo $view['title']; //제목 
					?> ]</p>
		</div>
		<div class="name_box">
			<p>작성자:</p>
			<p>[ <?php echo $view['name']; //작성자이름
					?> ]</p>
		</div>
		<div class="content_box">
			<div class="content_box_title">
				<p>본문:</p>
			</div>
			<div class="content_box_content">
				<?php if ($view['image']) : ?>
					<img class="show_img" src='<?php echo $view['image']; //본문 이미지파일 
												?>' />
				<?php endif; ?>
				<?php echo $view['content']; //본문 텍스트 
				?>
			</div>
		</div>
	</div>
	<div class="showbox_btn">
		<a href="update.php?id=<?php echo $id ?>">글수정</a>
		<form id="formbox" method="post" enctype="multipart/form-data">
			<input id="id" type="hidden" value="<?php echo $id ?>" />
			<input class="del_btn" id="del_submit" type="submit" value="글삭제" />
		</form>
		<input class="prev_page_show" id="prev_page" type="button" value="목록으로 돌아가기" />
	</div>
</div>
<script>
	$(document).ready(function() {

		$("#del_submit").click(function(event) {
			event.preventDefault();

			let result = [];
			result[0] = $("#id").val();

			confirm("삭제하시겠습니까?");

			$.ajax({
				type: "POST",
				url: "json.php?mode=del",
				data: {
					id : result
				},
				dataType: "json",
				success: function(result) {
					console.log(result)
					// 실패
					if (result.success == false) {
						alert(result.msg);
						return;
					}
					alert(result.msg);
					location.href = 'index.php';
				}
			});
		})
		$("#prev_page").click(function() {
			location.href = 'index.php';
		});
	})
</script>
<?php
include('inc/footer.php');
?>