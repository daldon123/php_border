<?php

	include('db/db.php');
    class BoardJson {

        public function write() {

            try{

                global $db;

                ## 제목
                $title   = isset($_POST['title'])? $_POST['title'] : '';
                if(empty($title) == true) {
                    throw new exception('제목이 없습니다.');
                }

                ## 작성자
                $name    = isset($_POST['name'])? $_POST['name'] : '';
                if(empty($name) == true) {
                    throw new exception('작성자가 없습니다.');
                }

                ## 내용
                $content = isset($_POST['content'])? $_POST['content'] : '';
                if(empty($content) == true) {
                    throw new exception('내용이 없습니다.');
                }
                
                ## 첨부파일
                $file    = $_FILES['image']['name'];
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
                                                                                                                    
                ## 글쓰기 등록
                $query = "
                    insert into table01 ( 
                        title, 
                        content, 
                        time, 
                        name, 
                        image
                    ) values( 
                        '{$title}', 
                        '{$content}', 
                        now(), 
                        '{$name}',
                        '{$newImage}'
                    )
                ";
                $re = $db->query($query)->affectedRows();
                if($re != 1) {
                    throw new exception('글 작성중에 오류가 발생했습니다.');
                }
                
                ## 처리후 경로 이동
                Header("Location:index.php");

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

                ## 인덱스
                $id       = isset($_GET['id'])? $_GET['id'] : '';
                if(empty($id) == true) {
                    throw new Exception('잘못된 정보입니다');
                }
                
                ## 제목
                $title    = isset($_POST['title'])? $_POST['title'] : '';
                if(empty($title) == true) {
                    throw new Exception('제목이 없습니다');
                }

                ## 작성자
                $name     = isset($_POST['name'])? $_POST['name'] : '';
                if(empty($name) == true) {
                    throw new Exception('작성자가 없습니다');
                }

                ## 내용
                $content  = isset($_POST['content'])? $_POST['content'] : '';
                if(empty($content) == true) {
                    throw new Exception('내용이 없습니다');
                }

                ## 첨부파일
                $query ="
                select 
                    image 
                from table01 where 
                    id={$id}
                ";
                $image = $db->query($query)->fetchArray();
                $img = isset($image['image']) ? $image['image'] : '';

            
                if($_FILES['image']['name']){
                    ## 새 이미지파일이 전달된 경우
                    $imageFullName  = strtolower($_FILES['image']['name']);
                    $imageNameSlice = explode(".",$imageFullName);
                    $imageType      = $imageNameSlice[1];
                    $dates          = date("mdhis",time());
                    $newImage       = chr(rand(97,122)).chr(rand(97,122)).$dates.rand(1,9).".".$imageType;
                    $dir            = "image/";
                    move_uploaded_file($_FILES['image']['tmp_name'],$dir.$newImage);
                    chmod($dir.$newImage,0777);
                    
                    ## 글쓰기 수정
                    $query ="
                        update table01 set 
                            title='{$title}',
                            name='{$name}', 
                            content='{$content}', 
                            image='{$newImage}' 
                            where id={$id}
                    ";
                    $re = $db->query($query)->affectedRows();
                    if($re != 1) {
                        throw new exception('글 수정중에 오류가 발생했습니다.');
                    }

                    ## 기존 이미지 삭제
                    if(empty($img) == false) {
                        @unlink("C:/git/domebon/public_html/php_border/image/{$img}");
                    }

                    ## 처리후 주소 이동
                    Header("Location:show.php?id={$id}");
        
                }else{
                    ## 이미지 파일을 그대로 사용할 경우, 글쓰기 수정
                    $query ="
                        update table01 set 
                            title='{$title}',
                            name='{$name}', 
                            content='{$content}', 
                            image='{$img}' 
                            where id={$id}
                    ";
                    $re = $db->query($query)->affectedRows();
                    if($re != 1) {
                        throw new exception('글 수정중에 오류가 발생했습니다.');
                    }

                    ## 처리후 주소 이동
                    Header("Location:show.php?id={$id}");
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
                
                ##삭제할 데이터 인덱스
                $id     = isset($_GET['id'])? $_GET['id'] : '';
                if(empty($id) == true) {
                    throw new Exception('잘못된 정보입니다');
                }

                ## 데이터확인
                $query = "
                select 
                    * 
                from table01 
                where id={$id}
                ";
                $tRow = $db->query($query)->fetchArray();
                if(empty($tRow) == true) {
                    throw new exception('삭제할 데이터를 찾을 수 없습니다.');
                }

                ## 글 삭제
                $query  ="
                    delete from table01 where id={$id}
                ";
                $re = $db->query($query)->affectedRows();
                if($re != 1) {
                    throw new exception('글 삭제중에 오류가 발생했습니다.');
                }
                
                ## 이미지파일 삭제
                $img = isset($tRow['image']) ? $tRow['image'] : '';
                if(empty($img) == false) {
                    @unlink("C:/git/domebon/public_html/php_border/image/{$img}");
                }

                ## 처리후 주소 이동
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

    $objBoardJson = new BoardJson();
    
    ## mode 실행 함수
    if($mode == 'write'){
        $objBoardJson->write();
    }
    if($mode == 'modify'){
        $objBoardJson->modify();
    }
    if($mode == 'del'){
        $objBoardJson->del();
    }


