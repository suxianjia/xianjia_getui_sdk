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
            'group_name' =>'task_se' . uniqid(),
            'settings' => [
                'ttl' =>  7200000, 
            ], 
            'push_message' => [
                'notification' => [
                    'title' => '测试标题',
                    'body' => '测试内容',
                    'click_type' => 'url',
                    'url' => 'https://www.baidu.com/'
                ]
                ],

                    
                //   'push_channel' =>  [  'android' ], 
                        //  'push_channel' =>  [ 'ios' ,'android','mp','harmony' ], 
        ]; 
$result = $App->create_task_push_list_message($inputdata); //执行cid单推 https://docs.getui.com/getui/server/rest_v2/push/
echo json_encode    ($result , JSON_UNESCAPED_UNICODE );  

// 使用方法  cd  /code/demo   &&  php82 test.php 
// yx-dev@yx-devdeMacBook-Air xianjia_getui_sdk_code % php82 demo/create_task_push_list_message.php 
 