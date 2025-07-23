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
     "tag"  => [
                            [
                                "key" => "phone_type",
                                "values" => [
                                    "android"
                                ],
                                "opt_type" => "and"
                            ],
    ],
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
$result = $App->push_tag($inputdata); //执行cid单推 https://docs.getui.com/getui/server/rest_v2/push/
echo json_encode    ($result);  

// 使用方法  cd  /code/demo   &&  php82 test.php 
                                                                                             
// yx-dev@Mac demo % php82 push_tag.php 
//  {"code":0,"network_status":200,"msg":"success","data":{"taskid":"RASA_0723_10c9bf8bcf2d5554ee54fd6e06f17b16"}}%                                                                                     
// yx-dev@Mac demo % 