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
    
    'testw345345' 

];  

$result = $App->find_report_push_task_group($inputdata );
// var_dump( $result);  
// exit();
echo json_encode    ($result , JSON_UNESCAPED_UNICODE);  

// 使用方法  cd /ocr/code/demo   &&  php82 test.php 

//  php82 find_report_push_task_group.php   