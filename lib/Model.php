<?php

//! Model類
/*
 * 它的主要部分是對應於留言本各種資料操作的函式
 * 如:留言資料的顯示、插入、刪除等
 */
class Model {
    
    var $dao; //DataAccess類的一個例項(物件)//conn
    //! 建構函式
    /*
     * 構造一個新的Model物件
     * @param $dao是一個DataAccess物件
     * 該引數以地址傳遞(&;$dao)的形式傳給Model
     * 並儲存在Model的成員變數$this->dao中
     * Model通過呼叫$this->dao的fetch方法執行所需的SQL語句
     */
    function __construct(&$dao) {
        $this->dao=$dao;
    }
    function listNote($page, $per) {    //獲取全部留言
        $start = ($page - 1) * $per; //每一頁開始的資料序號
        $notes = $this->dao->fetchRows("SELECT * 
                                        FROM center88_board 
                                        ORDER BY time DESC 
                                        LIMIT ".$start.", ".$per);
        //執行dataAccess裡的function
        return $notes;
    }
    function searchNote($page, $per, $search) {    //獲取全部留言
        $start = ($page - 1) * $per; //每一頁開始的資料序號
        $notes = $this->dao->fetchRows("SELECT *
                                        FROM center88_board
                                        WHERE msg_title LIKE '%" . $search . "%'
                                        ORDER BY time DESC
                                        LIMIT ".$start.", ".$per);
        //執行dataAccess裡的function
        return $notes;
    }
    function checkAllRows() {
        $data_rows = $this->dao->rowsNum("  SELECT *
                                            FROM center88_board
                                            ORDER BY time DESC");
        //執行dataAccess裡的function
        return $data_rows;
    }
    function checkSearchRows($search) {
        $data_rows = $this->dao->rowsNum("  SELECT *
                                            FROM center88_board
                                            WHERE msg_title LIKE '%" . $search . "%'
                                            ORDER BY time DESC");
        //執行dataAccess裡的function
        return $data_rows;
    }
    function pageArray($page, $search = NULL) {
        
        $page_array["page"] = $page;
        $page_array["per"] = $per = 3;//每頁顯示筆數
        if(empty($search)){
            $page_array["data_rows"] = $this->checkAllRows();//所有頁數
        }else {
            $page_array["data_rows"] = $this->checkSearchRows($search);//所有頁數
        }
        $page_array["allpages"] = ceil($page_array["data_rows"]/$per);
        return $page_array;
    }
    function postNote() {
        $msg_array["id"] = "";
        $msg_array["nickname"] = "";
        $msg_array["msg_title"] = "";
        $msg_array["msg"] = "";
        $msg_array["errname"] = "";
        $msg_array["errtitle"] = "";
        $msg_array["errmsg"] = "";
        if (isset($_POST["nickname"]) && isset($_POST["msg_title"]) && isset($_POST["msg"]))
        {
            if (!empty($_POST["nickname"]) && !empty($_POST["msg_title"]) && !empty($_POST["msg"])){//不允許add送空字串
                $msg_array["nickname"] = $_POST["nickname"];
                $msg_array["msg_title"] = $_POST["msg_title"];
                $msg_array["msg"] = $_POST["msg"];
                $sql = "INSERT INTO center88_board (nickname, msg_title, msg)
                        VALUES ('" . $msg_array["nickname"] . "' , '" . $msg_array["msg_title"] . "' , '" . $msg_array["msg"] . "' )";
                
                if ( $this->dao->query($sql) ){
                    echo "新增成功!!";
                    header("Refresh: 3; URL=index.php");
                }else{
                    echo "新增失敗!!";
                }
            }else{
                $msg_array["nickname"] = empty($_POST["nickname"]) ? "" : $_POST["nickname"];
                $msg_array["msg_title"] = empty($_POST["msg_title"]) ? "" : $_POST["msg_title"];
                $msg_array["msg"] = empty($_POST["msg"]) ? "" : $_POST["msg"];
                if(empty($_POST["nickname"])){
                    $msg_array["errname"] = "請輸入暱稱";
                }
                if(empty($_POST["msg_title"])){
                    $msg_array["errtitle"] = "請輸入標題";
                }
                if(empty($_POST["msg"])){
                    $msg_array["errmsg"] = "請輸入留言";
                }
            }
       }
       return $msg_array;
    }
    
}
?>