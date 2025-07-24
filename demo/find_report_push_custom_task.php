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
$inputdata =  [ 
    
    'RASL_0723_30f8edca69a7445384fde0e4c1315292' 

]; 

 $actionId_list =   [


 ];

$result = $App->find_report_push_custom_task($inputdata, $actionId_list);
// var_dump( $result);  
// exit();
echo json_encode    ($result , JSON_UNESCAPED_UNICODE);  

// 使用方法  cd /ocr/code/demo   &&  php82 test.php 

//  php82 find_report_push_custom_task.php  
//  yx-dev@yx-devdeMacBook-Air demo % php82 find_report_push_custom_task.php  
// {"code":0,"network_status":200,"msg":"success","data":[]}%                                                                                          
// yx-dev@yx-devdeMacBook-Air demo % 