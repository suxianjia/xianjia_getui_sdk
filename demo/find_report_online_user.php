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
$inputdata =   [ 
]; 
$result = $App->find_report_online_user($inputdata);
// var_dump( $result);  
// exit();
echo json_encode    ($result);  

// 使用方法  cd /ocr/code/demo   &&  php82 test.php  
// yx-dev@Mac demo % php82 find_report_online_user.php 
// yx-dev@Mac demo % php82 find_report_online_user.php 
// {"code":0,"network_status":200,"msg":"success","data":{"online_statics":{"1753262700015":1,"1753259100014":1,"1753255500016":1,"1753263300019":1,"1753319100012":1,"1753316700015":1,"1753262100014":1,"1753256100017":1,"1753322700019":2,"1753263900016":1,"1753256700017":1,"1753322100014":2,"1753323300012":1,"1753319700017":1,"1753323900019":2,"1753259700017":1,"1753321500018":1,"1753320900013":1,"1753260900018":1,"1753257900016":1,"1753264500019":1,"1753318500017":1,"1753325100014":1,"1753253700011":1,"1753260300018":1,"1753254300011":1,"1753320300017":1,"1753261500014":1,"1753258500010":1,"1753324500015":1,"1753317900017":1,"1753254900012":1,"1753257300014":1,"1753317300011":1}}}%                                                                             
// yx-dev@Mac demo % 