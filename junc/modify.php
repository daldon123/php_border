<?php
    include('../db/db.php');

    global $db;

    ##데이터
    $id = $_GET['id'];
    $title    = isset($_POST['title'])? $_POST['title'] : false;
    $name     = isset($_POST['name'])? $_POST['name'] : false;
    $content  = isset($_POST['content'])? $_POST['content'] : false;
    $image    = isset($_POST['img'])? $_POST['img'] : false;


    ##저장할 데이터와 이미지 파일의 유무
    if($_POST['title'] && $_POST['name'] && $_POST['content']){

        
        if($_FILES['image']['name']){
            //새 이미지파일이 전달된 경우
            $imageFullName = strtolower($_FILES['image']['name']);
            $imageNameSlice = explode(".",$imageFullName);
            $imageType = $imageNameSlice[1];
            $image_ext = array('jpg','jpeg','gif','png');
            if(array_search($imageType,$image_ext) === false){
                $errMsg='jpg, jpeg, gif, png 확장자만 가능합니다.';
            }
            $dates = date("mdhis",time());
            $newImage = chr(rand(97,122)).chr(rand(97,122)).$dates.rand(1,9).".".$imageType;
            //저장된 파일명
            $dir = "../image/";
            move_uploaded_file($_FILES['image']['tmp_name'],$dir.$newImage);
            chmod($dir.$newImage,0777);
                    
            $query ="
            update table01 set 
            title='{$title}',
            name='{$name}', 
            content='{$content}', 
            image='{$newImage}' 
            where id={$id}
            ";
            $db->query($query)->affectedRows();

            @unlink("./image/{$image}");
            Header("Location:../show.php?id={$id}");


        }else{
            $query ="
            update table01 set 
            title='{$title}',
            name='{$name}', 
            content='{$content}', 
            image='{$image}' 
            where id={$id}
            ";
            $db->query($query)->affectedRows();
            Header("Location:../show.php?id={$id}");
        }
    }