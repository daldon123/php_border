<?php
$title = '수정하기';
include('helper.php');
include('inc/header.php');

##수정하기 전 데이터
$board 			= new Board();
$re 			= $board->view();
$data 			= isset($re['view']) ? $re['view'] : [];
$id				= isset($re['id']) ? $re['id'] : '';

?>
<div class="update_box">
	<form id="formbox" method="post" class="update_box_form" enctype="multipart/form-data">
		<label for="title">제목</label>
		<input type="text" id="title" name="title" placeholder="제목을 입력하세요" class="update_input" value='<?php echo $data['title']; // 전 제목 ?>' oninvalid="this.setCustomValidity('제목을 입력해주세요')" required />
		<label for="name">닉네임</label>
		<input type="text" id="name" name="name" placeholder="닉네임을 입력하세요" class="update_input" value='<?php echo $data['name']; // 전 작성자 ?>' oninvalid="this.setCustomValidity('이름을 입력해주세요')" required />
		<div class="update_content" contentEditable="true">
			<?php if ($data['image']) : ?>
				<div class="update_image">
					<img src='<?php echo $data['image']; ?>'></img>
				</div>
			<?php endif; ?>
			<textarea class="update_text" name="content" placeholder="내용을 입력해주세요" oninvalid="this.setCustomValidity('내용을 입력해주세요')" required><?php echo $data['content']; //이전 본문 내용 ?></textarea>
		</div>
		<input type="file" name="image" style="margin:10px 0px;" />
		<div class="update_btn">
			<input id="submit_btn" type="submit" value="수정하기">
			<input id="prev_page" type="button" value="목록으로 돌아가기" onclick="window.location.href='index.php'">
		</div>
	</form>
</div>
<script>
	// 수정하기
	$("#submit_btn").click(function(event) {
		event.preventDefault();
		let form = $("#formbox")[0];
		let data = new FormData(form);

		if(confirm("수정 하시겠습니까?")){
			$.ajax({
			type: "POST",
			url: "json.php?mode=modify&&id=<?php echo $id; //글수정 주소 ?>",
			data: data,
			dataType: "json",
			contentType: false,
			processData: false,
			success: function(result) {
				// 실패
				if (result.success == false) {
					alert(result.msg);
					return;
				}
				alert(result.msg);
				location.href = 'show.php?id=<?php echo $id ?>';
			}
			});
		}else{
			return;
		}
		

		
	});

	// 뒤로가기
	$("#prev_page").click(function() {
		location.href = 'index.php';
	});
</script>
<?php
include('inc/footer.php');
?>