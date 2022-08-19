<html>
<link rel=stylesheet href='index.css'>
<head>
	<title>홍영호 php 게시판/글내용</title>
</head>
<body class='showbody'>
	<h1 class='titleh2'>글내용</h1>
	<?php
		$id = $_GET['id'];
	
		// echo $id;
	
		$db = mysqli_connect("localhost", "root", "123456", "test01");
		$sql = "select * from table01 where id={$id}";

	
		$res = mysqli_query($db, $sql);
		
		echo "<div class='showbox'>";
	
		$row = mysqli_fetch_array($res);
			
		echo "<div class='showboxs'>";
		echo "<p style='width:20%;display:flex;align-items:center;justify-content:center;'>제목:</p>";
		echo "<p style= 'width:80%;'>[ {$row['title']} ]</p> </div>";
		echo "<div class='showboxs'><p style='width:20%;display:flex;align-items:center;justify-content:center;'>작성자:</p> <p style= 'width:80%;'>[ {$row['name']} ]</p> </div>";
		echo "<div class='showboxscontent'><p style='width:20%;display:flex;align-items:center;justify-content:center;'>본문:</p>"; 
		echo "<pre style='width:60%; margin-left:10%; margin-right:10%; display:flex; flex-direction:column; '>";
		if($row['image']){
			echo "<img src='image/{$row['image']}'></img>";
		}
		echo "{$row['content']}</pre></div>";
		

		echo "</div>";
	
		$x_title = $row['title'];
		$x_name = $row['name'];
		$x_image = $row['image'];
		$x_content = $row['content'];
	
		echo "<a class='backbtn' href='update.php?id={$id}&&title={$x_title}&&name={$x_name}&&image={$x_image}&&content={$x_content} '>글수정</a>";
		echo "<a class='backbtn' href='del.php?id={$id}'>글삭제</a>";
		echo "<a class='backbtn' href='index.php'>목록으로 돌아가기</a>";
	
	?>

</body>
</html>