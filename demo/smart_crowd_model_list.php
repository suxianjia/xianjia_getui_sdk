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
        "name" => "文案圈人",
  "status" => 4 //任务状态，不传表示查所有状态,0:待开始；1:计算中；2:超时失败；3:失败；4:成功；5:已停止
        ]; 
 
$result = $App->smart_crowd_model_list($inputdata['name'],$inputdata['status']);
echo json_encode    ($result , JSON_UNESCAPED_UNICODE);  

// 使用方法  cd /ocr/code/demo   &&  php82 test.php 
// yx-dev@Mac demo % php82 smart_crowd_model_list.php
//  yx-dev@Mac demo % php82 smart_crowd_model_list.php
// {"code":1,"network_status":200,"msg":"应用或账号未开通相应功能","data":[]}%                                                                                
// yx-dev@Mac demo % 