<html>
<link href="index.css" rel="stylesheet" type="text/css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
<meta property="og:type" content="website">
<meta property="og:title" content="홍영호 php 게시판 연습">
<meta property="og:description" content="php 게시판 입니다">
<!-- <meta property="og:image" content="여기는 대표 이미지 URL"> -->
<meta property="og:url" content="https://php-border-uuerk.run.goorm.io/">
<head>
	<title>홍영호 php 게시판</title>
</head>
<body>
	<h1 class='titleh2'>내 게시판</h1>
	<?php
		$db = mysqli_connect("localhost", "root", "123456", "test01");
		// 페이징
	
		$pagesql = "select count(id) from table01";
		
		$pageres = mysqli_query($db, $pagesql);
		$total = mysqli_fetch_array($pageres);
		$num = $total['count(id)']; // 전체 데이터 수
	
		$list_num = 20;  // 한페이지에 보여줄 데이터 수
		$page_num = 20;   // 한블럭당 페이지 수
	
		$page = isset($_GET['page'])? $_GET['page'] : 1; // 현재 페이지 번호
	
		$total_page = ceil($num / $list_num);  //  총 페이지 수 = 전체 데이터 수 / 페이지당 데이터 수
		$total_block = ceil($total_page / $page_num); // 총 블럭 수 = 페이지 수 / 블럭 당 페이지 수
	
		$now_block = ceil($page / $page_num);  // 현재 블럭 번호 = 현재 페이지 번호 / 블럭당 페이지 수
	
		$s_pageNum = ($now_block - 1) * $page_num + 1; // 블럭당 시작페이지 번호 = ( 해당 글의 블럭 번호 - 1 ) * 블럭당 페이지수 + 1
		if($s_pageNum <= 0){
			$s_pageNum = 1;
		};// 데이터가 0개인 경우
	
		$e_pageNum = $now_block * $page_num; // 블럭당 마지막 페이지 번호 = 현재 블럭 번호 * 블럭당 페이지 수
		if($e_pageNum > $total_page){
			$e_pageNum = $total_page;
		};//마지막 번호가 전체 페이지수를 넘지 않는다
	
		// 변수 출력
		$start  = ($page - 1) * $list_num; //시작번호 =( 현 페이지 번호 -1) * 페이지당 보여질 데이터 수
		$cnt = $start + 1; // 글번호
	
		
		
		echo $start;
		echo "<br/>";
		echo $list_num;
		echo "<br/>";
		echo $now_block;
		echo "<br/>";
	
	
	
	?>
	<?php
		// $db = mysqli_connect("localhost", "root", "123456", "test01");
		$sql = "select * from table01 where title like '%".$_GET["search"]."%' order by id desc limit {$start},{$list_num}"; 
		
		echo $sql;
	
		$res = mysqli_query($db, $sql);
	
	
		echo "<div class='box'>";
		echo "<a class='write' href='write.php'>글쓰기</a>";
		echo "<table class='table table-dark'>";
		echo "<tr><th style='width:10%;'>ID</th><th style='width:50%;'>Title</th><th style='width:10%;'>Name</th><th style='width:20%;'>Content</th></tr>";
	
		while($row = mysqli_fetch_array($res)){
			echo "<tr><td>{$row['id']}</td><td><a class='titlea' href='show.php?id={$row['id']}'>{$row['title']}</a></td><td>{$row['name']}</td><td>{$row['time']}</td></tr>";
		}
		
		echo "</table>";
		echo "</div>";
	?>
	<div class='box2'>
	<?php
		if($page - 20 > 0){
	?>
	<a href='index.php?page=<?php echo $page-20; ?>'>◀</a>
	<?php
		}
	?>
	<?php
		if($page > 1){
	?>
	<a href='index.php?page=<?php echo $page-1; ?>'>이전</a>
	<?php
		}
	?>
	
	<?php
		for($print_page = $s_pageNum; $print_page <= $e_pageNum; $print_page++){
	?>
	<a href='index.php?page=<?php echo $print_page; ?>'><?php echo $print_page; ?></a>
	<?php }; ?>
	
	<?php
		if($page < $total_page){
	?>
	<a href="index.php?page=<?php echo $page+1; ?>">다음</a>
	<?php
		}
	?>
	<?php
		if($page+20 < $total_page){
	?>
	<a href="index.php?page=<?php echo $page+20; ?>">▶</a>
	<?php } ?>
	</div>

	<div class='formbox'>
		<form action="index.php" method='get'>
			<label for='search'>검색</label>
			<input type='text' name='search' placeholder='제목으로검색' />
			<input type='submit' value='검색' />
		</form>
	</div>
	<?php 
		echo "<div class='sql'>검색쿼리:{$sql}</div>";
	?>

	



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
</body>
</html>