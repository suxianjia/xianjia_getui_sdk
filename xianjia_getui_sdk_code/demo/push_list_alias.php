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
            'taskid' => "RASL_0723_8fd902763fdd4412a24b3f64bc3349a2" ,
            "is_async" => true,
            'audience' => [
                'alias' => [
                    'su-dev-android-app'
                ]
            ], 
        ]; 
$result = $App->push_list_alias($inputdata); //执行cid单推 https://docs.getui.com/getui/server/rest_v2/push/
echo json_encode    ($result);  

// 使用方法  cd  /code/demo   &&  php82 test.php 
                                                                                             
// yx-dev@Mac demo % php82 push_list_alias.php 
// {"code":0,"network_status":200,"msg":"success","data":[]}%                                                                                                 
// yx-dev@Mac demo % 