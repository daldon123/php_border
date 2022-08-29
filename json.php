<?php

include('db/db.php');
class BoardJson
{

    public function write()
    {

        try {

            global $db;

            ## 제목
            $title   = isset($_POST['title']) ? $_POST['title'] : '';
            if (empty($title) == true) {
                throw new exception('제목이 없습니다.');
            }

            ## 작성자
            $name    = isset($_POST['name']) ? $_POST['name'] : '';
            if (empty($name) == true) {
                throw new exception('작성자가 없습니다.');
            }

            ## 내용
            $content = isset($_POST['content']) ? $_POST['content'] : '';
            if (empty($content) == true) {
                throw new exception('내용이 없습니다.');
            }

            ## 첨부파일
            $file    = $_FILES['image']['name'];
            if ($file) {
                $imageFullName   = strtolower($_FILES['image']['name']);
                $imageNameSlice  = explode(".", $imageFullName);
                $imageType       = $imageNameSlice[1];
                $dates           = date("mdhis", time());
                $newImage        = chr(rand(97, 122)) . chr(rand(97, 122)) . $dates . rand(1, 9) . "." . $imageType;
                $dir             = "image/";
                move_uploaded_file($_FILES['image']['tmp_name'], $dir . $newImage);
                chmod($dir . $newImage, 0777);
            }
            $thum = "image/thum/thum.jpg"; // 섬네일 경로
            $thumImage = isset($newImage)? $dir.$newImage : $thum;
            $nowImage = $dir.$newImage; // 본문 이미지 경로

            ## 글쓰기 등록
            $query = "
                    insert into table01 ( 
                        title, 
                        content, 
                        time, 
                        name, 
                        image,
                        thum
                    ) values( 
                        '{$title}', 
                        '{$content}', 
                        now(), 
                        '{$name}',
                        '{$nowImage}',
                        '{$thumImage}'
                    )
                ";
            $re = $db->query($query)->affectedRows();
            if ($re != 1) {
                throw new exception('글 작성중에 오류가 발생했습니다.');
            }

            ## 마무리
            $result = [
                "success" => true,
                "msg"     => "글쓰기가 완료되었습니다 .",
            ];
        } catch (Exception $e) {

            $result = [
                "success" => false,
                "msg"     => $e->getMessage(),
            ];
        } finally {

            echo json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }
    }

    public function modify()
    {

        try {

            global $db;

            ## 인덱스
            $id       = isset($_GET['id']) ? $_GET['id'] : '';
            if (empty($id) == true) {
                throw new Exception('잘못된 정보입니다');
            }

            ## 제목
            $title    = isset($_POST['title']) ? $_POST['title'] : '';
            if (empty($title) == true) {
                throw new Exception('제목이 없습니다');
            }

            ## 작성자
            $name     = isset($_POST['name']) ? $_POST['name'] : '';
            if (empty($name) == true) {
                throw new Exception('작성자가 없습니다');
            }

            ## 내용
            $content  = isset($_POST['content']) ? $_POST['content'] : '';
            if (empty($content) == true) {
                throw new Exception('내용이 없습니다');
            }

            ## 이전 첨부파일
            $query = "
                select 
                    image 
                from table01 where 
                    id={$id}
                ";
            $imageRow = $db->query($query)->fetchArray();
            $prev_img = isset($imageRow['image']) ? $imageRow['image'] : '';

            ## 새 이미지파일이 전달된 경우
            $file = $_FILES['image']['name'];
            if ($file) {
                $imageFullName  = strtolower($_FILES['image']['name']);
                $imageNameSlice = explode(".", $imageFullName);
                $imageType      = $imageNameSlice[1];
                $dates          = date("mdhis", time());
                $newImage       = chr(rand(97, 122)) . chr(rand(97, 122)) . $dates . rand(1, 9) . "." . $imageType;
                $dir            = "image/";
                move_uploaded_file($_FILES['image']['tmp_name'], $dir . $newImage);
                chmod($dir . $newImage, 0777);
            }

            ## 이미지 파일 교체
            $nowImage = isset($newImage) ? $dir.$newImage : $dir.$prev_img;


            ## 글쓰기 수정
            $query = "
                    update table01 set 
                        title   ='{$title}',
                        name    ='{$name}', 
                        content ='{$content}', 
                        image   ='{$nowImage}',
                        thum    ='{$nowImage}',
                        modi    =modi+1
                        where id={$id};
                ";
            $re = $db->query($query)->affectedRows();
            if ($re != 1) {
                throw new exception('글 수정중에 오류가 발생했습니다 .');
            }

            ## 기존 이미지 삭제
            if (empty($newImage) == false) {
                @unlink("C:/git/domebon/public_html/php_border/image/{$prev_img}");
            }

            ## 마무리
            $result = [
                "success" => true,
                "msg"     => "성공",
            ];
        } catch (exception $e) {

            $result = [
                "success" => false,
                "msg"     => $e->getMessage(),
            ];
        } finally {

            echo json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }
    }

    public function del()
    {

        try {

            global $db;

            ##삭제할 데이터 인덱스
            $id     = isset($_POST['id']) ? $_POST['id'] : '';
            if (empty($id) == true) {
                throw new Exception('잘못된 인덱스 정보입니다');
            }

            foreach($id as $data) {
                ## 데이터확인
                $query = "
                    select 
                        * 
                    from table01 
                    where id=$data;
                    ";
                $idRow = $db->query($query)->fetchAll();
                if (empty($idRow) == true) {
                    throw new exception('삭제할 데이터를 찾을 수 없습니다.');
                }

                ## 글 삭제
                $query = "
                delete from table01
                where id = $data;
                ";
                $re = $db->query($query)->affectedRows();
                if ($re != 1) {
                    throw new exception('글 삭제중에 오류가 발생했습니다.');
                }
                
                ## 이미지파일 삭제
                $idRow[0]['image'] = isset($idRow[0]['image']) ? $idRow[0]['image'] : '';
                if (empty($idRow[0]['image']) == false) {
    
                    @unlink("C:/git/domebon/public_html/php_border/{$idRow[0]['image']}");
                }

            }

            ## 마무리
            $result = [
                "success" => true,
                "msg"     => "삭제 성공",
            ];

        } catch (Exception $e) {

            $result = [
                "success" => false,
                "msg"     => $e->getMessage(),
            ];
        } finally {

            echo json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }
    }
}


$mode = $_GET['mode'] ?? '';
if (empty($mode) == true) {
    die('잘못된 접속방식');
}

$objBoardJson = new BoardJson();

## mode 실행 함수
if ($mode == 'write') {
    $objBoardJson->write();
}
if ($mode == 'modify') {
    $objBoardJson->modify();
}
if ($mode == 'del') {
    $objBoardJson->del();
}
