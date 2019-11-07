ex-MVC-board
===

## Table of Contents
- [ex-MVC-board](#ex-MVC-board)
  * [Beginners Guide](#beginners-guide)

## Beginners Guide

center88留言板 with MVC  
* 2019/11/06  
    * 利用[範例](https://www.itread01.com/p/962428.html)完成list, search部分  
* 2019/11/07  
    * 修改css id→class  
    * 完成list, search部分  
    * 將原本放在controller的pageArray function移到model  
    * 將view的View大父類別去掉, 由search繼承list(因為輸出大都一樣)  
    * 加入新增留言(post)的功能，使用isset確認是否有$_POST的資料進來(是否第一次進到新增頁面)  
    * "新增完成"按鈕按下後isset通過，用!empty確認是否都有值，若有空值則回到原本畫面並在欄位輸出"請輸入xxx"的提醒文字
    * 若!empty通過則進入sql,query，query成功顯示"新增成功"字樣，3秒後跳回首頁。
    *  
    
    

