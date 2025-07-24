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
    "date" => "2025-07-23"
]; 
$result = $App->find_report_push_date($inputdata);
// var_dump( $result);  
// exit();
echo json_encode    ($result);  

// 使用方法  cd /ocr/code/demo   &&  php82 test.php  
// yx-dev@Mac demo % php82 find_report_push_date.php
//  yx-dev@Mac demo %  php82 find_report_push_date.php
// {"code":0,"network_status":200,"msg":"success","data":{"2025-07-23":{"total":{"target_num":8,"receive_num":8,"display_num":3,"click_num":3,"msg_num":55},"gt":{"target_num":8,"receive_num":8,"display_num":3,"click_num":3}}}}%                                                                                  
// yx-dev@Mac demo % 