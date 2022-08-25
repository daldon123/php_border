<?php
	$title = '글쓰기';
	include('inc/header.php');
?>
	<div class="write_box">
		<form id="formbox" method="post" class="writeFormbox" enctype="multipart/form-data">
			<div class="write_topbox">
				<!-- 제목 -->
				<label for="title">제목</label>
				<input type="text" id="title" name="title" placeholder="제목을 입력하세요" class="writeinput" />
				<!-- 작성자 -->
				<label for="name">작성자</label>
				<input type="text" id="name" name="name" placeholder="닉네임을 입력하세요" class="writeinput" />
			</div>
			<!-- 본문 내용 -->
			<textarea name="content" placeholder="내용을 입력해주세요" class="write_textarea" ></textarea>
			<!-- 첨부파일 -->
			<div class="write_btnbox1">
				<input id="filesasd" type="file" name="image"/>
			</div>
			<div class="write_btnbox2">
				<input id="submit_btn" type="submit" value="글쓰기"/>
				<input id="prev_page" type="button" value="목록으로 돌아가기"/>
			</div>
		</form>
	</div>
	<script>
		$("#submit_btn").click(function(event) {
			event.preventDefault();
			let form = $("#formbox")[0];
			let data = new FormData(form);

			$.ajax({
				type:"POST",
				enctype:"multipart/form-data",
				url: "json.php?mode=write",
				data: data,
				processData: false,
				contentType: false,      
				cache: false,           
				timeout: 600000,       
				success: function (data) { 
					alert("글쓰기 성공");           
					location.href='index.php';   
				},          
				error: function (e) {  
					console.log("ERROR : ", e);     
					alert("글쓰기 실패");      
					location.href='index.php';
				}     
			});
		});

		$("#prev_page").click(function() {
			location.href='index.php';   
		});
	</script>
<?php
	include('inc/footer.php');
?>
