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
$key_value = [
        [
      "key" => "phone_type",
      "values" => [
        "android"
      ],
       "opt_type"=> "and"
    ]
  
        ]; 
$result = $App->find_user_count($key_value);
echo json_encode    ($result);  

// 使用方法  cd /ocr/code/demo   &&  php82 test.php 
 
// yx-dev@Mac demo % php82 find_user_count.php
// {"code":0,"network_status":200,"msg":"success","data":{"user_count":7}}%                                                                                   
// yx-dev@Mac demo % 