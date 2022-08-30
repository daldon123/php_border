<?php
include('helper.php');
$objBoard 	= new Board();
$re 		= $objBoard->lists();

$page		= isset($re['page']) 		? $re['page']		: '';
$data 		= isset($re['data']) 		? $re['data'] 		: [];
$total_page = isset($re['total_page'])  ? $re['total_page'] : [];
$pageSize 	= isset($re['pageSize'])	? $re['pageSize']	: '';
$now_block  = isset($re['now_block'])	? $re['now_block']	: '';
$total		= isset($re['total'])		? $re['total']		: '';
$last_page	= isset($re['last_page'])	? $re['last_page']	: '';
$search 	= isset($re['search'])		? $re['search']		: '';
$listNum	= isset($re['listNum'])		? $re['listNum']	: '';

$title 		= '게시판';
include('inc/header.php');
?>

<!-- 게시판 -->
<div class="index_box">
	<div class="index_box_manu">
		<a class="index_write_btn" href='write.php'>글쓰기</a>
		<select id="pageSize" class="pageSize">
			<option value="5" <?php if($pageSize ==  5){echo 'selected';} ?> >5개</option>
			<option value="10"<?php if($pageSize == 10){echo 'selected';} ?> >10개</option>
			<option value="15"<?php if($pageSize == 15){echo 'selected';} ?> >15개</option>
		</select>
		<input type="submit" id="delete_checkbox" class="delete_checkbox" value="선택삭제" />
	</div>
	<table class="table">
		<tr class="thead">
			<th style="width:3%;"><input id="chk_all" type="checkbox" name="chkAll"></th>
			<th style="width:3%">No</th>
			<th style="width:5%;">ID</th>
			<th style="width:20%;">Image</th>
			<th style="width:35%;">Title</th>
			<th style="width:10%">Name</th>
			<th style="width:15%;">Time</th>
		</tr>
		<?php if (empty($data) == true) : // list 데이터가 없을 ?>
		<tr>
			<td colspan="99" >
				<div class="empty">
					"empty"
				</div>
			</td>
		</tr>
		<?php else : ?>
		<?php foreach ($data as $key => $sql) : ?>
		<tr class="tbody">
			<td>
				<input class="checkbox" type="checkbox" value="<?php echo $sql['id']; //id ?>" />
			</td>
			<td>
				<?php echo $listNum-- ?>
			</td>
			<td>
				<?php echo $sql['id']; //id ?>
				
			</td>
			<td>
				<img style="height: 70px;" src="<?php echo $sql['image']? $sql['image'] : $sql['thum']; // 썸네일 ?>" />
			</td>
			<td>
				<a href="show.php?id=<?php echo $sql['id']; //view페이지주소 ?>">
					<?php echo $sql['title']; //제목?>
				</a>
			</td>
			<td>
				<?php echo $sql['name']; //이름 ?>
			</td>
			<td>
				<?php echo $sql['time']; //작성시간 ?>
			</td>
		</tr>
		<?php endforeach; ?>
		<?php endif; ?>
	</table>
</div>
<!-- /게시판 -->
<!-- 페이징 -->
<div class="paging">
	<?php if ($now_block >= 2) : ?>
	<a href="index.php?page=<?php echo 1; ?>&&pageSize=<?php echo $pageSize ?>">처음</a>
	<?php endif; ?>
	<?php if ($now_block > 1) : ?>
	<a href="index.php?page=<?php echo $page - $pageSize; ?>&&pageSize=<?php echo $pageSize ?>&&search=<?php echo $search; ?>">◀</a>
	<?php endif; ?>
	<?php for ($print_page = ($now_block - 1) * $pageSize + 1; $print_page <= $last_page; $print_page++) : ?>
	<a class="page_btn_color <?php echo $page == $print_page ? "active_color" : ""; ?>" onclick="click_btn(<?php echo $print_page ?>)" href="index.php?page=<?php echo $print_page; ?>&&pageSize=<?php echo $pageSize ?>&&search=<?php echo $search; ?>">
	<?php echo $print_page; ?>
	</a>
	<?php endfor; ?>
	<?php if ($now_block * $pageSize < $total_page) : ?>
	<a href="index.php?page=<?php echo ($now_block * $pageSize) + 1; ?>&&pageSize=<?php echo $pageSize ?>&&search=<?php echo $search; ?>">▶</a>
	<?php endif; ?>
	<?php if ($last_page != $total_page) : ?>
	<a href="index.php?page=<?php echo $total_page; ?>&&pageSize=<?php echo $pageSize ?>">마지막</a>
	<?php endif; ?>
</div>
<!-- /페이징 -->
<!-- 검색창 -->
<div class="search_box">
	<div class="search_text">검색</div>
	<input id="search" 	   type="text"   value="<?php echo $search; ?>" placeholder="제목으로 검색" />
	<input id="reset_btn"  type="button" value="리셋">
	<input id="search_btn" type="button" value="검색" />
</div>
<!-- /검색창 -->
<script>
	$(document).ready(function() {

		// 선택 삭제
		$('#delete_checkbox').click(function(event) {
			event.preventDefault();

			let result = Array();
			let cks = $("input[type=checkbox][name=check]:checked");

			for (i = 0; i < cks.length; i++) {
				result[i] = cks[i].value;
			}

			if(result.length == 0) {
				alert('삭제할 글을 선택해주세요.');
				return;
			}

			if (confirm("삭제하시겠습니까?")) {
				$.ajax({
					type: "POST",
					url: "json.php?mode=del",
					data: {
						id: result
					},
					dataType: "json",
					success: function(result) {
						// 실패
						if (result.success == false) {
							alert(result.msg);
							return;
						}
						alert(result.msg);
						location.reload();
					}
				});
			} else {
				return;
			}


		})

		// 체크박스 전체 선택
		$("#chk_all").click(function() {
			if($("#chk_all").is(":checked")){
				$(".checkbox").prop("checked",true);
			}else{
				$(".checkbox").prop("checked",false);
			}
		})

		//pageSize 불러오기
		$("#pageSize").on("change", function() {

			let search 		= $("input[type=text][name=search]").val();
			let pageSize 	= $("#pageSize").val();
			location.href 	= 'index.php?search=' + search +'&&page=1'+'&&pageSize='+pageSize;
		})

		// 검색창
		$("#search_btn").click(function(event) {
			event.preventDefault();

			let search  	= $("#search").val();
			let pageSize 	= $("#pageSize").val();
			location.href 	= 'index.php?search=' + search + '&&page=1' + '&&pageSize='+pageSize;
		})

		// 검색창 비우기
		$("#reset_btn").click(function() {
			$("input[type=text][name=search]").val("");
		})



	})
</script>
<?php
include('inc/footer.php');
?>