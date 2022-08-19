<?php
	$title = '글보기';
	include('inc/header.php');
	require('inc/function.php');
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
				<p style='width:20%;display:flex;align-items:center;justify-content:center;'>본문:</p>
				<pre style='width:60%; margin-left:10%; margin-right:10%; display:flex; flex-direction:column;'>
				<?php
					if($shwo_row['image']){
						echo "<img src='image/{$shwo_row['image']}'></img>";
					}
					echo $shwo_row['content'];
				?>
				</pre>
			</div>
		</div>
		<div class='showbox2'>
			<a class='backbtn' href='update.php?id=<?php echo $id ?>&&title=<?php echo $x_title ?>&&name=<?php echo $x_name ?>&&image=<?php echo $x_image ?>&&content=<?php echo $x_content ?>'>글수정</a>
			<a class='backbtn' href='del.php?id=<?php echo $id ?>'>글삭제</a>
			<a class='backbtn' href='index.php'>목록으로 돌아가기</a>
		</div>
	</div>
<?php
	include('inc/footer.php');
?>