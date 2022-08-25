<?php
	$title = '게시판';

	include('helper.php');
	include('inc/header.php');

	$objBoard = new Board();
	$re 		= $objBoard->lists();
	$data 		= isset($re['data']) ? $re['data'] : [];
	$total_page = isset($re['total_page']) ? $re['total_page'] : [];

?>
	<!-- 게시판 -->
	<div class="index_box">
		<a class="index_write_btn" href='write.php'>글쓰기</a>
		<table class="table">
			<tr>
				<th style="width:5%;">ID</th>
				<th style="width:20%;">Image</th>
				<th style="width:35%;">Title</th>
				<th style="width:10%">Name</th>
				<th style="width:15%;">Time</th>
			</tr>
			<?php foreach($data as $sql): ?>
			<tr>
				<td>
					<?php echo $sql['id']; //id ?>
				</td>
				<td>
					<img style="height: 70px;" src=<?php echo $sql['image'] ? "./image/".$sql['image'] : "./image/asd.jpg" ?> />
					<!-- 썸네일 -->
				</td>
				<td>
					<a class="white_a" href="show.php?id=<?php echo $sql['id']; //view페이지주소 ?>">
						<?php echo $sql['title']; //제목 ?>
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
		</table>	
	</div>
	<!-- /게시판 -->
	<!-- 페이징 -->
	<div class="page_btn">
		<?php if($page - 20 > 0): ?>
		<a href="index.php?page=<?php echo $page-20; ?>">◀</a>
		<?php endif; ?>
		<?php if($page > 1): ?>
		<a href="index.php?page=<?php echo $page-1; ?>">이전</a>
		<?php endif; ?>
		<?php for($print_page = 1; $print_page <= $total_page; $print_page++): ?>
		<a href="index.php?page=<?php echo $print_page; ?>">
			<?php echo $print_page; ?>
		</a>
		<?php endfor; ?>
		<?php if(1 < $page): ?>
		<a href="index.php?page=<?php echo $page+1; ?>">다음</a>
		<?php endif; ?>
		<?php if($page+20 < $total_page): ?>
		<a href="index.php?page=<?php echo $page+20; ?>">▶</a>
		<?php endif; ?>
	</div>
	<!-- /페이징 -->
	<!-- 검색창 -->
	<div class="search_box">
		<form action="index.php" method="get">
			<label for="search">검색</label>
			<input type="text" name="search" placeholder="제목으로검색" />
			<input type="submit" value="검색" />
		</form>
	</div>
	<!-- /검색창 -->
<?php
	include('inc/footer.php');
?>
	



