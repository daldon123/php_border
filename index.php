<?php
include('helper.php');

$search 	= isset($_GET['search'])	? $_GET['search']	: '';

$objBoard 	= new Board();
$re 		= $objBoard->lists();

$page		= isset($re['page']) 		? $re['page']		: '';
$data 		= isset($re['data']) 		? $re['data'] 		: [];
$total_page = isset($re['total_page'])  ? $re['total_page'] : [];
$pageSize 	= isset($re['pageSize'])	? $re['pageSize']	: '';
$nblock  	= isset($re['nblock'])		? $re['nblock']		: '';
$total		= isset($re['total'])		? $re['total']		: '';
$last_page	= isset($re['last_page'])	? $re['last_page']	: '';
$listNum	= $total - (($page - 1) * $pageSize);

$title 		= '게시판';
include('inc/header.php');
?>

<!-- 게시판 -->
<div class="index_box">
	<div class="index_box_manu">
		<a class="index_write_btn" href='write.php'>글쓰기</a>
		<select id="select_list" class="select_list">
			<option selected>list : <?php echo $pageSize ?></option>
			<option value="5">5개</option>
			<option value="10">10개</option>
			<option value="15">15개</option>
		</select>
		<input type="submit" id="check_btn" class="index_write_btn2" value="선택삭제" />
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
		<?php if (empty($data) == false) : ?>
			<?php foreach ($data as $key => $sql) : ?>
				<tr class="tbody">
					<td>
						<input id="check" class="ckecks" type="checkbox" name="check" value="<?php echo $sql['id']; //id 
																								?>" />
					</td>
					<td>
						<?php echo $listNum-- ?>
					</td>
					<td>
						<?php echo $sql['id']; //id 
						?>
					</td>
					<td>
						<img style="height: 70px;" src=<?php echo $sql['thum']; ?> />
						<!-- 썸네일 -->
					</td>
					<td>
						<a href="show.php?id=<?php echo $sql['id']; //view페이지주소 
												?>">
							<?php echo $sql['title']; //제목 
							?>
						</a>
					</td>
					<td>
						<?php echo $sql['name']; //이름 
						?>
					</td>
					<td>
						<?php echo $sql['time']; //작성시간 
						?>
					</td>
				</tr>
			<?php endforeach; ?>
		<?php else : ?>
			<tr>
				<td colspan="99" style="background-color: white;color:black;">
					데이터 없음
				</td>
			</tr>
		<?php endif; ?>
	</table>
</div>
<!-- /게시판 -->
<!-- 페이징 -->
<div class="page_btn">
	<?php if ($nblock >= 2) : ?>
		<a href="index.php?page=<?php echo 1; ?>">처음</a>
	<?php endif; ?>
	<?php if ($nblock > 1) : ?>
		<a href="index.php?page=<?php echo $page - $pageSize; ?>&&list=<?php echo $pageSize ?>&&search=<?php echo $search; ?>">◀</a>
	<?php endif; ?>
	<?php for ($print_page = ($nblock - 1) * $pageSize + 1; $print_page <= $last_page; $print_page++) : ?>
		<a class="page_btn_color <?php echo $page == $print_page ? "active_color" : ""; ?>" onclick="click_btn(<?php echo $print_page ?>)" href="index.php?page=<?php echo $print_page; ?>&&list=<?php echo $pageSize ?>&&search=<?php echo $search; ?>">
			<?php echo $print_page; ?>
		</a>
	<?php endfor; ?>
	<?php if ($nblock * $pageSize < $total_page) : ?>
		<a href="index.php?page=<?php echo ($nblock * $pageSize) + 1; ?>&&list=<?php echo $pageSize ?>&&search=<?php echo $search; ?>">▶</a>
	<?php endif; ?>
	<?php if ($last_page != $total_page) : ?>
		<a href="index.php?page=<?php echo $total_page; ?>">마지막</a>
	<?php endif; ?>
</div>
<!-- /페이징 -->
<!-- 검색창 -->
<div class="search_box">
	<div style="margin-right:10px;">검색</div>
	<input type="text" name="search" placeholder="제목으로 검색" />
	<input id="search_btn" type="button" value="검색" />
</div>
<!-- /검색창 -->
<script>
	$(document).ready(function() {

		// 선택 삭제
		$('#check_btn').click(function(event) {
			event.preventDefault();

			let result = Array();
			let cks = $("input[type=checkbox][name=check]:checked");

			for (i = 0; i < cks.length; i++) {
				result[i] = cks[i].value;
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
			} else {
				return;
			}


		})

		// 체크박스 전체 선택
		$("#chk_all").click(function() {
			if ($("#chk_all").is(":checked")) {
				$("input[name=check]").prop("checked", true);
			} else {
				$("input[name=check]").prop("checked", false);
			}

			$("#selecteds").text('기본값');
		})

		// list 불러오기
		$("#select_list").on("change", function() {
			let list = $("#select_list").val();
			location.href = 'index.php?list=' + list;
		})

		// 검색창
		$("#search_btn").click(function(event) {
			event.preventDefault();

			let search = $("input[type=text][name=search]").val();
			let page = <?php echo $page; ?>;
			let pageSize = <?php echo $pageSize; ?>

			location.href = 'index.php?search=' + search + '&&page=' + page + '&&list=' + pageSize;
		})



	})
</script>
<?php
include('inc/footer.php');
?>