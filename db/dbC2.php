<?php
	include('db.php');

	// $connect = mysqli_connect('localhost', 'root', '123456', 'test01');
	
	// print_r($db);
?>
	<table border=1>
	<tr>
		<th>id</th>	
		<th>title</th>	
		<th>name</th>	
	</tr>		
<?php
	$insert_sql = $db->query("select * from table01 order by id desc limit 0,20")->fetchAll();
	foreach($insert_sql as $insert){
?>
	<tr>
		<td><?=$insert['id']?></td>
		<td>
			<?=
				$insert['title'];				 
			?>
		</td>	
		<td>
			<?=
				$insert['name'];				 
			?>
		</td>	
	</tr>
<?php
								}
?>
	</table>
