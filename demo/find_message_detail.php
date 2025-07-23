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
$inputdata = [
  'cid' => '1813fd551854b2d459a0b73441ffe08b',
  'taskid' =>  'RASL_0723_8fd902763fdd4412a24b3f64bc3349a2',  
]; 
$result = $App->find_message_detail($inputdata);
echo json_encode    ($result);  

// 使用方法  cd /ocr/code/demo   &&  php82 find_message_detail.php 
  