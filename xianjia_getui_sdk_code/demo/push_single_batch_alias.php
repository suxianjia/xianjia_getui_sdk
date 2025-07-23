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
            "is_async"  =>   true,  //is_async	boolean	否	false	是否异步推送，true是异步，false同步。异步推送不会返回data详情
            "msg_list" => [
                                    [
                                                        'request_id' => uniqid(),
                                                        'settings' => [
                                                            'ttl' =>  7200000, 
                                                        ],
                                                        'audience' => [
                                                            'alias' => [
                                                                'su-dev-android-app'
                                                            ]
                                                        ],
                                                        'push_message' => [
                                                            'notification' => [
                                                                'title' => '测试标题 batch alias',
                                                                'body' => '测试内容 BaseUrl/push/single/batch/alias',
                                                                'click_type' => 'url',
                                                                'url' => 'https://www.baidu.com/'
                                                            ]
                                                        ]
                                    
                                    ] ,
            ]
        ]; 

        // 接口地址: BaseUrl/push/single/batch/cid
$result = $App->push_single_batch_alias($inputdata); //执行cid单推 https://docs.getui.com/getui/server/rest_v2/push/
echo json_encode    ($result);  

// 使用方法  cd  /code/demo   &&  php82 test.php 
// yx-dev@yx-devdeMacBook-Air xianjia_getui_sdk_code % php82 ./demo/push_single_batch_alias.php
// {"code":0,"network_status":200,"msg":"success","data":[]}%                                                                                                        
// yx-dev@yx-devdeMacBook-Air xianjia_getui_sdk_code % 