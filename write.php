<?php
$title = '글쓰기';
include('inc/header.php');
?>
<div class="write_box">
	<form id="formbox" method="post" class="writeFormbox" enctype="multipart/form-data">
		<div class="write_topbox">
			<!-- 제목 -->
			<label for="title">제목</label>
			<input type="text" id="title" name="title" placeholder="제목을 입력하세요" class="writeinput" oninvalid="this.setCustomValidity('제목을 입력해주세요')" required />
			<!-- 작성자 -->
			<label for="name">작성자</label>
			<input type="text" id="name" name="name" placeholder="닉네임을 입력하세요" class="writeinput" oninvalid="this.setCustomValidity('이름을 입력해주세요')" required />
		</div>
		<!-- 본문 내용 -->
		<textarea name="content" placeholder="내용을 입력해주세요" class="write_textarea" oninvalid="this.setCustomValidity('내용을 입력해주세요')" required></textarea>
		<!-- 첨부파일 -->
		<div class="write_btnbox1">
			<input type="file" name="image" />
		</div>
		<div class="write_btnbox2">
			<input id="submit_btn" type="submit" value="글쓰기" />
			<input id="prev_page" type="button" value="목록으로 돌아가기" />
		</div>
	</form>
</div>
<script>
	$("#submit_btn").click(function(event) {
		event.preventDefault();
		let form = $("#formbox")[0];
		let data = new FormData(form);

		if(confirm("작성 하시겠습니까?")){
			$.ajax({
			type: "POST",
			enctype: "multipart/form-data",
			url: "json.php?mode=write",
			data: data,
			dataType: "json",
			processData: false,
			contentType: false,
			success: function(result) {
				//실패
				if (result.success == false) {
					alert(result.msg);
					return;
				}
				alert(result.msg);
				location.href = 'index.php';
			}
			});
		}else{
			return;
		}

		
	});

	$("#prev_page").click(function() {
		location.href = 'index.php';
	});
</script>
<?php
include('inc/footer.php');
?>