<html>
<head>
<title>Ajax 테스트 ㄱㄱ</title>
<!-- Ajax를 사용하려면 jquery를 사용하면 편합니다. -->
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

<script type="text/javascript">
$( document ).ready(function() {
	//Json을 사용하지 않고 데이터를 가져와 보자.(첫번째 버튼)
	$('#no1').click(function(){
			
		$.ajax({
			url: "test.php",
			type: "post",
			data: $("form").serialize(),
		}).done(function(data){			
			$("#input_data").html(data);	
			console.log(data)	
		});
		
	});

	//Json을 이용해서 데이타를 가져와 보자. (두번째 버튼)
	$('#no2').click(function(){
		
	    $.ajax({
			url: "test.php",
    	  	type: "post",		
   			data: $("form").serialize(),
   			dataType:"json",
		}).done(function(data){
			//json을 통해 가져온 데이타를 input_data tag에 넣어준다.
			var html = "";
			for(var i = 0; i<data.seq.length; i++){
				html += "<tr>";
				html += "<td>Json - "+data.seq[i]+"</td>";
				html += "<td>"+data.name[i]+"</td>";
				html += "<td>"+data.age[i]+"</td>";
				html += "<td>"+data.email[i]+"</td>";
				html += "</tr>";
			}
			
			$("#input_data").html(html);
			console.log('asd')
 		}); 
          
	});

	//tbody 안에 있는 내용  지우기
	$('#no3').click(function(){
	    $("#input_data").empty();
	});
	
});
</script>
</head>
<body>
<table border="1">
    <thead>
        <tr>
          <th>번호</th>
          <th>이름</th>
          <th>나이</th>
          <th>이메일 주소</th>
        </tr>
    </thead>
    
    <!-- Ajax를 이용해 DB에서 가져온 데이타를 이곳에 넣어주자. -->
    <tbody id="input_data">
    </tbody>    
</table>
<hr>
<button id="no1">ajax 데이터 가져와</button>
<button id="no2">ajax json 이용해서 데이터 가져와</button>
<button id="no3">리셋</button>
</body>
</html>
