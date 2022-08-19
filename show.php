<?php
	$title = '글보기';
	include('inc/header.php');
	require('./show_sql.php');
?>
	<div class='showbody'>
		<div class='showbox'>
			<div class='showboxs'>
				<p style='width:20%;display:flex;align-items:center;justify-content:center;'>제목:</p>
				<p style= 'width:80%;'>[ <?php echo $shwo_row['title']?> ]</p> 
			</div>
			<div class='showboxs'>
				<p style='width:20%;display:flex;align-items:center;justify-content:center;'>작성자:</p>
				<p style= 'width:80%;'>[ <?php echo $shwo_row['name'] ?> ]</p>
			</div>
			<div class='showboxscontent'>
				<div style='width:20%; border-right:1px solid black; display:flex;align-items:center;justify-content:center;'>
					<p>본문:</p>
				</div>
				<pre style='width:76%; margin:2%; display:flex; flex-direction:column; padding-bottom:30px;'>
				<?php
					if($shwo_row['image']){
						echo "<img style='margin-bottom:10px;' src='image/{$shwo_row['image']}'></img>";
					}
					echo $shwo_row['content'];
				?>
				</pre>
			</div>
		</div>
		<div class='showbox2'>
			<a class='backbtn' href='update.php?id=<?php echo $id ?>&&title=<?php echo $x_title ?>&&name=<?php echo $x_name ?>&&image=<?php echo $x_image ?>&&content=<?php echo $x_content ?>'>글수정</a>
			<a class='backbtn' href='del_sql.php?id=<?php echo $id ?>'>글삭제</a>
			<a class='backbtn' href='index.php'>목록으로 돌아가기</a>
		</div>
	</div>
<?php
	include('inc/footer.php');
?>