<?php

    include('db/db.php');

    class Board {

        public function lists() {

            try {
                
                global $db;

                ## 페이지
                $page       = isset($_GET['page'])? $_GET['page'] : 1;
                $pageSize   = 10;
                $limitSt    = ($page - 1) * $pageSize;
                $limit      = "limit {$limitSt}, {$pageSize}";

                ## 검색
                $where      ='where 1';
                $search     = isset($_GET['search']) ? $_GET['search'] : '';
                if(empty($search) == false) {
                    $where .= " and title like ('%{$search}%')";
                }

                ## 데이터불러오기
                $query = "
                    select 
                        * 
                    from table01 
                        {$where}
                    order by id desc
                        {$limit}
                ";
                $data   = $db->query($query)->fetchAll();
                if($data == false) {
                    throw new exception('데이터를 가져오는중에 오류가 발생했습니다.');
                }

                
                ## 총개수
                $query = "
                    select
                        id
                    from table01
                        {$where}
                ";
                $total  = $db->query($query)->numRows();


                ## 페이징
                $blockSize      = 20;
                $total_page     = ceil($total / $pageSize);
                $total_block    = ceil($total_page / $blockSize);
                $now_block      = ceil($page / $blockSize);
                $s_pageNum      = ($now_block - 1) * 20 + 1; 
                $s_pageNum      = ($s_pageNum > 0) ? $s_pageNum : 1;
                $e_pageNum      = $now_block * $blockSize;
                $e_pageNum      = ($e_pageNum >= $total_page) ? $e_pageNum : $total_page;


                ## 마무리
                $result = [
                    'data'          => $data,
                    'total_page'    => $total_page,
                ];
                

            } catch(exception $e) {
                
                echo "<div class='exception'>";
                echo $e;
                echo "</div>";
            
            } finally {

                return $result;

            }
        }
        public function view() {

            try{

                global $db;

                ##데이터의 id값
                $id = isset($_GET['id'])? $_GET['id'] : '';
                if(!$id){
                    throw new Exception('id값이 없습니다');
                }
                
                ## 데이터 가져옴
                $query = "
                    select 
                        * 
                    from table01 where 
                        id={$id}
                ";
                $data = $db->query($query)->fetchArray();
                if($data == false) {
                    throw new exception('글 내용을 가져오는중에 오류가 발생했습니다.');
                }


                ## 마무리
                 $result = [
                     'view'    => $data,
                     'id'      => $id
                 ];

            } catch(Exception $e) {

                echo "<div class='exception'>";
                echo $e;
                echo "</div>";

            } finally {

                return $result;

            }

        }

        public function modify() {

            try{
                
                global $db;

                ##인덱스값
                $id = isset($_GET['id'])? $_GET['id'] : '';
                if(!$id){
                    throw new Exception('id값이 없습니다');
                }
                
                ##이전 데이터
                $query    = "select * from table01 where id={$id}";
                $data     = $db->query($query)->fetchArray();
                if($data == false) {
                    throw new exception('내용을 가져오는중에 오류가 발생했습니다.');
                }

                ## 마무리
                $result = [
                    'data' => $data,
                    'id'   => $id,
                ];
                
                
            } catch(exception $e) {

                echo "<div class='exception'>";
                echo $e;
                echo "</div>";

            } finally {

                return $result;

            }

        }


    }

