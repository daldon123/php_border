<?php
	$title = '삭제하기';
	include('inc/header.php');
	require('inc/function.php');
	require('./del_sql.php');
?>
<script>
	alert('삭제되었습니다');
	location.href='index.php';
</script>
<?php
	include('inc/footer.php');
?>