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
$dt_list = [ 
         [  
          "cid" => "1813fd551854b2d459a0b73441ffe08b",
          "device_token"=> "device_token1"
        ],
 ]; 
  $platformMap = [
    'wx' => '微信小程序',
    'hw' => '华为',
    'hwq' => '华为快应用',
    'ho' => '荣耀',
    'xm' => '小米',
    'op' => 'OPPO',
    'opg' => 'OPPO海外',
    'vv' => 'VIVO',
    'mz' => '魅族',
    'fcm' => '谷歌',
    'st' => '坚果',
    'sn' => '索尼',
    'ios' => '苹果',
];

 $type = 'wx'; 
$result = $App->bind_dt($dt_list,$type);
echo json_encode    ($result);  

// 使用方法  cd /ocr/code/demo   &&  php82 test.php 
// yx-dev@Mac demo % php82 bind_dt.php
// {"code":0,"network_status":200,"msg":"success","data":[]}%                                                                                                 
// yx-dev@Mac demo % 
 