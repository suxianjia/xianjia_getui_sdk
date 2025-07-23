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
$sub_task_ids = [
          "EfMYBRwVJw9tfcjUL1hYC4", 
        ]; 
 
$result = $App->smart_crowd_task_list($sub_task_ids);
echo json_encode    ($result);  

// 使用方法  cd /ocr/code/demo   &&  php82 test.php 
// yx-dev@Mac demo % php82 smart_crowd_task_list.php
// {"code":20001,"network_status":400,"msg":"brand_list cannot be null ","data":[]}%                                                                          
// yx-dev@Mac demo % 