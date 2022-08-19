<?php
	$title = '게시판';
	include('inc/header.php');
	require('inc/function.php');
	require('./index_sql.php');
?>
	<!-- 게시판 -->
	<div class='box'>
		<a class='write' href='write.php'>글쓰기</a>
		<table class='table table-dark'>
			<tr>
				<th style='width:10%;'>ID</th>
				<th style='width:50%;'>Title</th>
				<th style='width:10%;'>Name</th>
				<th style='width:20%;'>Content</th>
			</tr>
			<?php
				while($row = mysqli_fetch_array($write_res)){
			?>
			<tr>
				<td><?php echo $row['id'] ?></td>
				<td>
					<a class='titlea' href="show.php?id=<?php echo $row['id'] ?>">
						<?php echo $row['title'] ?>
					</a>
				</td>
				<td><?php echo $row['name'] ?></td>
				<td><?php echo $row['time'] ?></td>
			</tr>
			<?php 
				} 
			?>
		</table>	
	</div>
	<!-- /게시판 -->
	<!-- 페이징 -->
	<div class='box2'>
		<?php if($page - 20 > 0){ ?>
		<a href='index.php?page=<?php echo $page-20; ?>'>◀</a>
		<?php } ?>
		<?php if($page > 1){ ?>
		<a href='index.php?page=<?php echo $page-1; ?>'>이전</a>
		<?php } ?>
		<?php for($print_page = $s_pageNum; $print_page <= $e_pageNum; $print_page++){ ?>
		<a href='index.php?page=<?php echo $print_page; ?>'><?php echo $print_page; ?></a>
		<?php }; ?>
		<?php if($page < $total_page){ ?>
		<a href="index.php?page=<?php echo $page+1; ?>">다음</a>
		<?php } ?>
		<?php if($page+20 < $total_page){ ?>
		<a href="index.php?page=<?php echo $page+20; ?>">▶</a>
		<?php } ?>
	</div>
	<!-- /페이징 -->
	<!-- 검색창 -->
	<div class='formbox'>
		<form action="index.php" method='get'>
			<label for='search'>검색</label>
			<input type='text' name='search' placeholder='제목으로검색' />
			<input type='submit' value='검색' />
		</form>
	</div>
	<!-- /검색창 -->
<?php
	include('inc/footer.php');
?>
	



