<?php

include('db/db.php');

class Board
{

    public function lists()
    {

        try {

            global $db;

            ## 페이지
            $page       = isset($_GET['page']) ? $_GET['page'] : 1;
            $pageSize   = isset($_GET['list']) ? $_GET['list'] : 5;
            $limitSt    = ($page - 1) * $pageSize;
            $limit      = "limit {$limitSt}, {$pageSize}";

            ## 검색
            $where      = 'where 1';
            $search     = isset($_GET['search']) ? $_GET['search'] : '';
            if (empty($search) == false) {
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


            ## 총개수
            $query = "
                    select
                        id
                    from table01
                    {$where}
                    ";
            $total  = $db->query($query)->numRows();


            ## 페이징
            $total_page     = ceil($total / $pageSize);
            $now_block      = ceil($page / $pageSize);
            $last_page      = $now_block * $pageSize;
            if($last_page > $total_page){
                $last_page = $total_page;
            }

            ## 마무리
            $result = [
                'data'          => $data,
                'total_page'    => $total_page,
                'page'          => $page,
                'pageSize'      => $pageSize,
                'nblock'        => $now_block,
                'total'         => $total,
                'last_page'     => $last_page,
            ];
            
        } catch (exception $e) {

            echo 'Message: ' . $e->getMessage();
        } finally {

            return $result;
        }
    }
    public function view()
    {

        try {

            global $db;

            ##데이터의 id값
            $id = isset($_GET['id']) ? $_GET['id'] : '';
            if (!$id) {
                throw new Exception('id값이 없습니다');
            }

            ## 데이터 가져옴
            $query = "
                    select 
                        * 
                    from table01 where 
                        id={$id}
                ";
            $view = $db->query($query)->fetchArray();
            if ($view == false) {
                throw new exception('글 내용을 가져오는중에 오류가 발생했습니다.');
            }

            ## 마무리
            $result = [
                'view'    => $view,
                'id'      => $id
            ];
        } catch (Exception $e) {

            echo 'Message: ' . $e->getMessage();
        } finally {

            return $result;
        }
    }
}



$objBoardJson = new Board();

$mode = $_GET['mode'];

if($mode = 'lists') {
    $objBoardJson->lists();
}