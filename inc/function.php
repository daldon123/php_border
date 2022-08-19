<?php

	$db = mysqli_connect("localhost", "root", "123456", "test01");
	// db connect

	// *페이징 변수*
	$page_sql = "select count(id) from table01"; //페이지 데이터의 갯수를 가져오는 쿼리문
	$page_res = mysqli_query($db, $page_sql);
	$total = mysqli_fetch_array($page_res);
	$num = $total['count(id)']; // 전체 데이터 수
	// $list_num = 20;  // 한페이지에 보여줄 데이터 수
	// $page_num = 20;   // 한블럭당 페이지 수

	$page = isset($_GET['page'])? $_GET['page'] : 1; // 현재 페이지 번호

	$total_page = ceil($num / 20);  //  총 페이지 수 = 전체 데이터 수 / 페이지당 데이터 수
	$total_block = ceil($total_page / 20); // 총 블럭 수 = 페이지 수 / 블럭 당 페이지 수

	$now_block = ceil($page / 20);  // 현재 블럭 번호 = 현재 페이지 번호 / 블럭당 페이지 수

	$s_pageNum = ($now_block - 1) * 20 + 1; // 블럭당 시작페이지 번호 = ( 해당 글의 블럭 번호 - 1 ) * 블럭당 페이지수 + 1
	if($s_pageNum <= 0){
		$s_pageNum = 1;
	};// 데이터가 0개인 경우

	$e_pageNum = $now_block * 20; // 블럭당 마지막 페이지 번호 = 현재 블럭 번호 * 블럭당 페이지 수
	if($e_pageNum > $total_page){
		$e_pageNum = $total_page;
	};//마지막 번호가 전체 페이지수를 넘지 않는다

	// 변수 출력
	$start  = ($page - 1) * 20; //시작번호 =( 현 페이지 번호 -1) * 페이지당 보여질 데이터 수
	$cnt = $start + 1; // 글번호


	// *글쓰기 변수*
	if($_FILES['image']['name']){
		   $imageFullName = strtolower($_FILES['image']['name']);
		   $imageNameSlice = explode(".",$imageFullName);
		   $imageName = $imageNameSlice[0];
		   $imageType = $imageNameSlice[1];
		   $image_ext = array('jpg','jpeg','gif','png');
		   if(array_search($imageType,$image_ext) === false){
			   errMsg('jpg, jpeg, gif, png 확장자만 가능합니다.');
		   }
		   $dates = date("mdhis",time());
		   $newImage = chr(rand(97,122)).chr(rand(97,122)).$dates.rand(1,9).".".$imageType;
		   $dir = "image/";
		   move_uploaded_file($_FILES['image']['tmp_name'],$dir.$newImage);
		   chmod($dir.$newImage,0777);
	}

	$title = $_POST['title'];
	$name = $_POST['name'];
	$content = $_POST['content'];



	
	// *글보기 변수* 	
	$id = $_GET['id'];
	$show_sql = "select * from table01 where id={$id}";
	$shwo_res = mysqli_query($db, $show_sql);
	$shwo_row = mysqli_fetch_array($shwo_res);

	$x_title = $shwo_row['title'];
	$x_name = $shwo_row['name'];
	$x_image = $shwo_row['image'];
	$x_content = $shwo_row['content'];


	// *수정하기
	$r_title = $_GET['title'];
	$r_name = $_GET['name'];
	$r_content = $_GET['content'];


?>