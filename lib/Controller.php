<?php
//! Controller
/*
 * 控制器將$_GET['action']中不同的引數(list、post、delete)
 * 對應於完成該功能控制的相應子類
 */
class Controller {
    var $model;  // Model 物件
    var $view;   // View  物件
    //! 建構函式
    /*
     * 構造一個Model物件儲存於成員變數$this->model;
     */
    function __construct ($dao) {
        $this->model = new Model($dao);
    }
    
    function getView() {    //獲取View函式
        //返回檢視物件view
        //對應特定功能的Controller子類生成對應的View子類的物件
        //通過該函式返回給外部呼叫者
        return $this->view;
    }
    
}
//用於控制顯示留言列表的子類
class listController extends Controller{   //extends表示繼承
    function __construct ($dao, $page) { //建立model
        parent::__construct($dao);  //繼承其父類的建構函式
        //該行的含義可以簡單理解為:
        //將其父類的建構函式程式碼複製過來
        $page_array = $this->model->pageArray($page);
        $notes = $this->model->listNote($page, $page_array["per"]);
        //執行model裡的listNote function
        //取得全部留言的result
        
        $this->view = new listView($notes);
        $this->view->viewMsgResult($notes);
        $this->view->viewPage("list", $page_array);
        //建立相應的View子類的物件來完成顯示
    }
}
class searchController extends Controller{   //extends表示繼承
    function __construct ($dao, $page, $search) { //建立model
        parent::__construct($dao);  //繼承其父類的建構函式
        //該行的含義可以簡單理解為:
        //將其父類的建構函式程式碼複製過來
        if(empty($search)){
            $this->view = new searchView();
        }
        else{
            $page_array = $this->model->pageArray($page, $search);
            $notes = $this->model->searchNote($page, $page_array["per"], $search);
            $this->view = new searchView($search);
            $this->view->viewMsgResult($notes);
            $this->view->viewPage("search", $page_array, "&input=".$search);
        }
        /*$page_array = $this->pageArray($page);
        $notes = $this->model->listNote($page, $per);
        //執行model裡的listNote function
        //取得全部留言的result
        
        $this->view = new listView($notes, $page_array);*/
        //建立相應的View子類的物件來完成顯示
    }
}
//用於控制新增留言的子類
class postController extends Controller{
    function __construct ($dao) {//連資料庫
        parent::__construct($dao);//建立model
        if ($this->model->postNote()) $success=1;
        else $success=0;
        //$this->view = new postView($success);
    }
}
?>