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
          '1813fd551854b2d459a0b73441ffe08b',  
        ];  
//  string 
 $name ='test';// ,
//  array 
$tasks = [
     [ 
      "content" =>  "内容1",
      "topic" => "标题1"
    ],
];  
//  array 
$brand_list = [
   "xm",
    "vv",
    "hw"
];  
//  int 
$package_num = 1000;  
//  int 
$active_range = 15;  
//  int 
$active_type = 1;  
//  bool 
$is_overlap = true;  
 
 
$result = $App->create_smart_crowd( $name,  $tasks,   $brand_list,  $package_num,   $active_range,  $active_type,   $is_overlap);
// echo json_encode    ($result);  
  echo json_encode($result, JSON_UNESCAPED_UNICODE);

// 使用方法  cd /ocr/code/demo   &&  php82 test.php 
// yx-dev@Mac demo % php82 create_smart_crowd.php
// {"code":1,"network_status":200,"msg":"应用或账号未开通相应功能","data":[]}%                                                                                
// yx-dev@Mac demo % 