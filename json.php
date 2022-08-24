<?php

    class BoardJson {

        public function write() {

            try{

                global $db;

                ## 데이터
                $title   = isset($_POST['title'])? $_POST['title'] : false;
                $name    = isset($_POST['name'])? $_POST['name'] : '';
                $content = isset($_POST['content'])? $_POST['content'] : '';
                $file    = $_FILES['image']['name'];

                ##예외처리
                if(!$title && !$name && !$content){

                    throw new Exception('내용이 없습니다');

                }


                ## img파일
                if($file){

                    $imageFullName   = strtolower($_FILES['image']['name']);
                    $imageNameSlice  = explode(".",$imageFullName);
                    $imageType       = $imageNameSlice[1];
                    $dates           = date("mdhis",time());
                    $newImage        = chr(rand(97,122)).chr(rand(97,122)).$dates.rand(1,9).".".$imageType;
                    $dir             = "image/";
                    move_uploaded_file($_FILES['image']['tmp_name'],$dir.$newImage);
                    chmod($dir.$newImage,0777);

                }
                                                                                                                    
                if($title && $name && $content){

                    $query = "
                    insert into
                    table01(title, content, time, name, image)
                    values( '{$title}', '{$content}' , now() , '{$name}' ,'{$newImage}')
                    ";

                    $db->query($query)->affectedRows();

                    Header("Location:index.php");

                }

            } catch(Exception $e) {
                
                echo "<div class='exception'>";
                echo $e;
                echo "</div>";

            } finally {

            }

        }

        public function modify() {

            try{

                global $db;

                ##데이터
                $id       = isset($_GET['id'])? $_GET['id'] : '';
                $title    = isset($_POST['title'])? $_POST['title'] : '';
                $name     = isset($_POST['name'])? $_POST['name'] : '';
                $content  = isset($_POST['content'])? $_POST['content'] : '';
                $image    = isset($_POST['img'])? $_POST['img'] : '';
            
                ##예외처리
                if(!$title && !$name && !$content){

                    throw new Exception('내용이 없습니다');

                }
            
                ##저장할 데이터와 이미지 파일의 유무
                if($_POST['title'] && $_POST['name'] && $_POST['content']){
            
                    
                    if($_FILES['image']['name']){
                        //새 이미지파일이 전달된 경우
                        $imageFullName  = strtolower($_FILES['image']['name']);
                        $imageNameSlice = explode(".",$imageFullName);
                        $imageType      = $imageNameSlice[1];
                        $dates          = date("mdhis",time());
                        $newImage       = chr(rand(97,122)).chr(rand(97,122)).$dates.rand(1,9).".".$imageType;
                        //저장된 파일명
                        $dir            = "image/";
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
                        Header("Location:show.php?id={$id}");
            
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
                        Header("Location:show.php?id={$id}");
                    }

                }
                
            } catch(exception $e) {

                echo "<div class='exception'>";
                echo $e;
                echo "</div>";

            } finally {

            }

        }

        public function del() {

            try {

                global $db;

                ##삭제할 데이터
                $id     = isset($_GET['id'])? $_GET['id'] : '';
                $image  = isset($_POST['img'])? $_POST['img'] : '';

                ##예외처리
                if(!$id){
                    throw new Exception('본문내용이 잘못되었습니다');
                }                

                $query  ="
                delete from table01 where id={$id}
                ";
                $db->query($query)->affectedRows();;

                @unlink("./image/{$image}");
                Header("Location:del.php");

            } catch(Exception $e) {

                echo "<div class='exception'>";
                echo $e;
                echo "</div>";

            } finally {

            }
        }


    }

    $mode = $_GET['mode'] ?? '';
    if(empty($mode) == true) {
        die('잘못된 접속방식');        
    }

	include('db/db.php');
    $objBoardJson = new BoardJson();
    
    if($mode == 'write'){
        $objBoardJson->write();
    }
    if($mode == 'modify'){
        $objBoardJson->modify();
    }
    if($mode == 'del'){
        $objBoardJson->del();
    }


