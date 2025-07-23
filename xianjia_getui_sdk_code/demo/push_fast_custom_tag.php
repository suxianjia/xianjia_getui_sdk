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
  "audience"  => [
    //  "fast_custom_tag" => "su-dev-android-app-2",
          "fast_custom_tag" => "su-dev-android-app",

  ],
   "push_message"  =>  [
    "notification"  =>  [
      "title"  =>  "请填写通知标题",
      "body"  =>  "请填写通知内容",
      "click_type"  =>  "url",
      "url"  =>  "https//:www.baidu.com", 
    ]
  ]
        ]; 
$result = $App->push_fast_custom_tag($inputdata); //执行cid单推 https://docs.getui.com/getui/server/rest_v2/push/
echo json_encode    ($result);  

// 使用方法  cd  /code/demo   &&  php82 test.php 
                                                                                             
// yx-dev@Mac demo % php82 push_fast_custom_tag.php 
// yx-dev@Mac demo % php82  push_fast_custom_tag.php
// {"code":30000,"network_status":403,"msg":"no permission to push fast_custom_tag","data":[]}
// yx-dev@Mac demo % 