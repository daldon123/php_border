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
	<div class="update_box_form">
		<label for="title">제목</label>
		<input type="text" id="title" name="title" placeholder="제목을 입력하세요" class="update_input" value='<?php echo $data['title']; // 전 제목 ?>' oninvalid="this.setCustomValidity('제목을 입력해주세요')" required />
		<label for="name">닉네임</label>
		<input type="text" id="name" name="name" placeholder="닉네임을 입력하세요" class="update_input" value='<?php echo $data['name']; // 전 작성자 ?>' oninvalid="this.setCustomValidity('이름을 입력해주세요')" required />
		<div class="update_content" contentEditable="true">
			<textarea id="content" class="update_text" name="content" placeholder="내용을 입력해주세요" oninvalid="this.setCustomValidity('내용을 입력해주세요')" required><?php echo $data['content']; //이전 본문 내용 ?></textarea>
		</div>
	</div>
	<div class="update_bottom">
			<div class="update_image">
				<?php if ($data['image']) : ?>
					<img id="update_file01" src='<?php echo $data['image']; ?>'></img>
					<button id="del_file01" class="update_image_text">파일삭제</button>
				<?php endif; ?>
			</div>
			<div class="update_btn">
				<form id="send_file" class="send_file" method="post" enctype="multipart/form-data">
					<div class="filebox">
						<label for="ex_file">파일</label>
						<input type="file" name="image" id="ex_file"> 
					</div>
				</form>
				<input id="submit_btn" type="submit" value="수정하기">
				<input id="prev_page" type="button" value="목록으로 돌아가기" onclick="window.location.href='index.php'">
			</div>
	</div>
</div>
<script>
	// 이미지만 삭제
	$("#del_file01").click(function() {
		if(confirm("파일을 삭제하시겠습니까?")){
			$("#update_file01").attr("src","");
		}else{
			return;
		}
	})

	// 수정하기
	$("#submit_btn").click(function(event) {
		event.preventDefault();

		let title 	= $("#title").val();
		let name 	= $("#name").val();
		let content = $("#content").val();
		let x_file 	= $("#update_file01").attr("src");
		if(x_file == undefined){
			x_file = '';
		}
		let form = $("#send_file")[0];
		let formData = new FormData(form);
		formData.append('title'	 ,title);
		formData.append('name'	 ,name);
		formData.append('content',content);
		formData.append('x_file'   ,x_file);

		if(confirm("수정 하시겠습니까?")){
			$.ajax({
				type: "POST",
				url: "json.php?mode=modify&&id=<?php echo $id; //글수정 주소 ?>",
				data: formData,
				dataType: 'json',
				processData: false,
				contentType: false,
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