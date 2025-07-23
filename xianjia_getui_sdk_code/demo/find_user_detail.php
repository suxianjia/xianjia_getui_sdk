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
$result = $App->find_user_detail($inputdata);
echo json_encode    ($result);  

// 使用方法  cd /ocr/code/demo   &&  php82 test.php 
 
// yx-dev@Mac xianjia_getui_sdk % php82 ./xianjia_getui_sdk_code/demo/find_user_detail.php  
// yx-dev@Mac xianjia_getui_sdk % php82 ./xianjia_getui_sdk_code/demo/find_user_detail.php  
// {"code":0,"network_status":200,"msg":"success","data":{
// "validCids":
// {"1813fd551854b2d459a0b73441ffe08b":
// {"client_app_id":"M9vbNu1awUARfJa0AqTvN8",
// "package_name":"com.upetrol.v1",
// "device_token":"IQAAAACy1L62AADUuxlsLuZ0GKzzVXQOLdgV0PceDERm6hwbQV1rh8aWui3Uq-M0Tr18AwzAZ_ZZHJWs1f-CaKUULjvFaMOqQ1gcO38KNoej9IWUSQ",
// "phone_type":1,
// "phone_model":"HLK-AL00",
// "notification_switch":true,
// "create_time":"2025-07-18 14:36:53",
// "login_freq":2,
// "brand":"hw"}}}}%                     
// yx-dev@Mac xianjia_getui_sdk % 