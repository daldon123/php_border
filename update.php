<?php
	$title = '수정하기';
	include('helper.php');
	include('inc/header.php');

	##수정하기 전 데이터
	$up_Board 		= new Board();
	$re 			= $up_Board->modify();
	$data 			= isset($re['data']) ? $re['data'] : [];
	$id				= isset($re['id']) ? $re['id'] : '';

?>
	<div class="update_box">
		<form action="json.php?mode=modify&&id=<?php echo $id ?>" method="post" class="update_box_form" enctype="multipart/form-data">
			<label for="title">제목</label>
			<input type="text" id="title" name="title" placeholder="제목을 입력하세요" class="update_input" value='<?php echo $data['title']; // 전 제목 ?>' oninvalid="this.setCustomValidity('제목을 입력해주세요')" required/>
			<label for="name">닉네임</label>
			<input type="text" id="name" name="name" placeholder="닉네임을 입력하세요" class="update_input" value='<?php echo $data['name']; // 전 작성자 ?>' oninvalid="this.setCustomValidity('이름을 입력해주세요')" required/>
			<div class="update_content" contentEditable="true">
				<?php if($data['image']): ?>
					<div class="update_image">
						<img src='<?php echo "image/{$data['image']}"; ?>'></img>
					</div>
				<?php endif; ?>
				<textarea class="update_text" name="content" placeholder="내용을 입력해주세요" oninvalid="this.setCustomValidity('내용을 입력해주세요')" required><?php echo $data['content']; //이전 본문 내용 ?></textarea>
			</div>
			<input type="file" name="image" style="margin:10px 0px;" />
			<div class="update_btn">
				<input type="submit" value="수정하기" >
				<input type="button" value="목록으로 돌아가기" onclick="window.location.href='index.php'">
			</div>
		</form>
	</div>
<script>

	// 수정하기
	$("#submit_btn").click(function(event) {
		event.preventDefault();
		let form = $("#formbox")[0];
		let data = new FormData(form);

		$.ajax({
			type:"POST",
			enctype:"multipart/form-data",
			url: "json.php?mode=modify&&id=<?php echo $id; //글수정 주소 ?>",
			data: data,
			processData: false,
			contentType: false,      
			cache: false,           
			timeout: 600000,       
			success: function (data) { 
				alert("글수정 성공");           
				location.href='index.php?id=<?php echo $id; ?>';   
			},          
			error: function (e) {  
				console.log("ERROR : ", e);     
				alert("글수정 실패");      
				location.href='index.php';
			}     
		});
	});

	// 뒤로가기
	$("#prev_page").click(function() {
		location.href='index.php';   
	});	

</script>	
<?php
	include('inc/footer.php');
?>