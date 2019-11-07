<?php
//! View 類
/*
 * 針對各個功能(list、post、delete)的各種View子類
 * 被Controller呼叫,完成不同功能的網頁顯示
 */
class listView   //顯示所有留言的子類
{
    function __construct()
    {
        
    }
    function viewMsgResult($notes) {
        foreach ($notes as $value)
        {
            ?>
			<table class='cont_tb'>
				<tr>
					<td colspan="2">
						#<?php echo $value["msg_id"] ?>
					</td>
				</tr>
				<tr>
					<td>留言標題：</td>
                    	<td width="450">
                        	<?php echo $value["msg_title"] ?>
                    </td>
                </tr>
                <tr>
					<td>留言內容：</td>
					<td width="450">
					<?php
					$msg = str_replace("\n","<br/>",$value["msg"]);
                        echo $msg;
                    ?>
					</td>
				</tr>
				<tr>
					<td colspan="2" style="text-align: right;">
					<?php echo $value["nickname"] . "&nbsp;發表於&nbsp;" . $value["time"] ?>
					</td>
				</tr>
				<tr>
					<td colspan="2" style="text-align: right;">
						<button type="button" onclick="location.href='delete_complete.php?id=<?php echo $value["msg_id"];?>'">刪除</button>
						<button type="button" onclick="location.href='board-modify.php?id=<?php echo $value["msg_id"];?>'">修改</button>
					</td>
				</tr>
			</table>
			<br/>            
			<?php 
        }
    }
    function viewPage($action, $page_array, $search = NULL) {
        ?>
    
            <p>共<?php echo $page_array["data_rows"] ?>筆-在<?php echo $page_array["page"] ?>頁-共<?php echo $page_array["allpages"] ?>頁</p>
            <p><a href=index.php?action=<?php echo $action; echo $search ?>&page=1>首頁</a>-第
            <?php
            for( $i = 1 ; $i <= $page_array["allpages"] ; $i++ ) 
            {
                if ( $page_array["page"] -3 < $i && $i < $page_array["page"] +3 ) /*前2頁 後兩頁*/
                {?>
                	<a href=index.php?action=<?php echo $action; echo $search ?>&page=<?php echo $i ?> ><?php echo $i ?></a>
                    <?php
                }
            }?>
    		頁-<a href=index.php?action=<?php echo $action; echo $search ?>&page=<?php echo $page_array["allpages"] ?> >末頁</a>
            </p>
        <?php ;
    }
}
class searchView extends listView   //顯示所有留言的子類
{
    function __construct($search = NULL)
    {?>
    	<form action="index.php?action=search&" method="get">
                <table cellpadding="10" width="600" border="1" align="center">
                    <tr>
                        <td>
                        	<input type="hidden" name="action" value="search">
    						搜尋：<input type="text" name="input" size="41" style="font-size:20px" 
                            value="<?php echo $search ?>">
    						<button type="submit">START</button>
    					</td>
    				</tr>
    			</table>
    		</form>
    		<br/>
    <?php   
    }
}
?>
