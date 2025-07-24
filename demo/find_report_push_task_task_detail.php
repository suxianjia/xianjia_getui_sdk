<?php
 include_once __DIR__."/../vendor/autoload.php";
use Suxianjia\xianjia_getui_sdk\myConfig;
use Suxianjia\xianjia_getui_sdk\myApp;
 
 



 
// Example usage
// cms_article_base
define("myAPP_VERSION" , "1.0.0") ;
define("myAPP_ENV" , "dev")  ;
define("myAPP_DEBUG" , true )  ;
define("myAPP_PATH", __DIR__."/");
define("myAPP_RUNRIMT_PATH", __DIR__."/runtime/");

 
 

 
$config = myConfig::getInstance()::getAllConfig(); 
$App =   myApp::getInstance($config);    
$inputdata =   [
    "taskid" => "RASA_0723_10c9bf8bcf2d5554ee54fd6e06f17b16"
]; 
$result = $App->find_report_push_task_task_detail($inputdata);
// var_dump( $result);  
// exit();
echo json_encode    ($result);  

// 使用方法  cd /ocr/code/demo   &&  php82 test.php 

//  php82 find_schedule_task.php  
// yx-dev@Mac demo % php82 find_report_push_task_task_detail.php
//  yx-dev@yx-devdeMacBook-Air demo %  php82 find_report_push_task_task_detail.php
// {"code":30017,"network_status":403,"msg":"permission denied of querying real_time_report","data":[]}%                                               
// yx-dev@yx-devdeMacBook-Air demo % 