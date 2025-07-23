<?php 


return [

   "version" => 'v1.0.0',
   'app_debug' => true,
   'app_env' =>   'dev',//dev,prod
   'app_path' => __DIR__.'/',
   'runtime_path' => __DIR__.'/runtime', //用户输入  路径 

 
  'getui' => [
                'appkey' => ' ',
                'appId' => ' ',  
                'mastersecret' => ' ', 
  ],

// redis配置表 
 'redis' => [
            'host' => '127.0.0.1',
            'port' => 6379,
            'auth' => '654321mm',
            'db_select' => '3',
        ] ,
   
   'cache_type'  => 'redis',// session,redis,mysql

 





];