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
$inputdata =  'su-dev-android-app'; 
$result = $App->delete_all_alias($inputdata);
echo json_encode    ($result);  

// 使用方法  cd /ocr/code/demo   &&  php82 test.php 

//  php82 delete_all_alias.php 
// yx-dev@yx-devdeMacBook-Air xianjia_getui_sdk_code % php82 ./demo/delete_all_alias.php 
//  yx-dev@Mac xianjia_getui_sdk % php82 ./xianjia_getui_sdk_code/demo/delete_all_alias.php 
 