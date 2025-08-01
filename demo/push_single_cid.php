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
            'request_id' => uniqid(),
            'settings' => [
                'ttl' =>  7200000,
                "strategy" => [   
                    "default"  => 1 
                ],
            ],
            'audience' => [
                'cid' => [
                    '1813fd551854b2d459a0b73441ffe08b'
                ]
            ],
            'push_message' => [
                'notification' => [
                    'title' => '测试标题',
                    'body' => '测试内容',
                    'click_type' => 'url',
                    'url' => 'https://www.baidu.com/'
                ]
            ]
        ]; 
$result = $App->push_single_cid($inputdata); //执行cid单推 https://docs.getui.com/getui/server/rest_v2/push/
echo json_encode    ($result);  

// 使用方法  cd  /code/demo   &&  php82 test.php 
// yx-dev@yx-devdeMacBook-Air xianjia_getui_sdk_code % php82 ./demo/push_single_cid.php
// {"code":0,"network_status":200,"msg":"success","data":{"RASS_0721_a683a4e74780dedc19886e0be29089a1":{"1813fd551854b2d459a0b73441ffe08b":"successed_online"}}}%    
  // php82 ./xianjia_getui_sdk_code/demo/push_single_cid.php 
//  {"code":0,"network_status":200,"msg":"success","data":{"RASS_0722_8d956c88cc70e13b91ff0e23bdfc69b7":{"1813fd551854b2d459a0b73441ffe08b":"successed_online"}}}%       
 