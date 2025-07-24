<?php 
namespace Suxianjia\xianjia_getui_sdk; 
use Exception;
 use Suxianjia\xianjia_getui_sdk\SDK;
 
if (!defined('myAPP_VERSION')) {        exit('myAPP_VERSION is not defined'); }
if (!defined('myAPP_ENV')  ) {          exit ('myAPP_ENV is not defined'); }
if (!defined('myAPP_DEBUG')) {          exit('myAPP_DEBUG is not defined'); }
if (!defined('myAPP_PATH')) {           exit('myAPP_PATH is not defined'); }
if (!defined('myAPP_RUNRIMT_PATH')) {   exit('myAPP_RUNRIMT_PATH is not defined'); }

class myApp {
 
    private static $instance = null; 
 private static $config = [];

    private function __construct($config) { 
       self::$config = $config;
    }
//   
    public static function getInstance($config = []): myApp { 
        if (self::$instance === null) {
            self::init();
            self::$instance = new self($config);
        }
        return self::$instance;
    }

    private static function init () {
 
    }
    //-----------------------------------------------------------
    private static function getAllConfig( ):  array { 
        return self::$config ; 
    }

//-----------------------------------------------------------
// private static function output ($code = 500, $msg = 'Failed', $data = [] ): bool|string {
//      $results = ['code' => $code, 'msg' => $msg , 'data' => $data ];
//      return  json_encode($results, JSON_UNESCAPED_UNICODE)  ;// utf8_encode($results)  ;
//     }

 
//-----------------------------------------------------------
// unipush2.0快速接入指南：https://ask.dcloud.net.cn/article/40283
//  push_single_cid
//-----------------------------------------------------------
    public function push_single_cid(array $inputdata = []): array|string
    {  
        $SDK = SDK::getInstance(  self::getAllConfig( ));   
       return $SDK->push_single_cid ($inputdata );   
    }
//-----------------------------------------------------------
// 接口地址: BaseUrl/push/single/batch/cid
// $result = $App->push_single_batch_cid($inputdata); 
//-----------------------------------------------------------
    public function push_single_batch_cid(array $inputdata = []): array|string
    { 
        $SDK = SDK::getInstance(  self::getAllConfig( ));    
       return  $SDK->push_single_batch_cid ($inputdata );    
    }
//-----------------------------------------------------------
// push_single_batch_alias
//-----------------------------------------------------------
    public function push_single_batch_alias(array $inputdata = []): array|string
    { 
        $SDK = SDK::getInstance(  self::getAllConfig( ));     
       return  $SDK->push_single_batch_alias ($inputdata );    
    }

//-----------------------------------------------------------
//push_single_alias
//-----------------------------------------------------------
        public function push_single_alias(array $inputdata = []): array|string
    { 
        $SDK = SDK::getInstance(  self::getAllConfig( ));    
       return $SDK->push_single_alias ($inputdata );   
    }
//-----------------------------------------------------------
// bind_alias
//-----------------------------------------------------------
    public function bind_alias(array $inputdata = []): array|string
    { 
        $SDK = SDK::getInstance(  self::getAllConfig( ));     
       return $SDK->bind_alias ($inputdata );   
    }
//-----------------------------------------------------------
// find_alias 
//-----------------------------------------------------------
     public function find_alias(string $inputstring =  ''): array|string
    { 
        $SDK = SDK::getInstance(  self::getAllConfig( ));     
        return  $SDK->find_alias ($inputstring );  
    }
//-----------------------------------------------------------
// $result = $App->find_cid($inputdata); //  // 【别名】根据别名查询cid find_cid
//-----------------------------------------------------------
     public function find_cid(string $inputstring =  ''): array|string
    { 
        $SDK = SDK::getInstance(  self::getAllConfig( ));     
        return  $SDK->find_cid ($inputstring );  
    }
//-----------------------------------------------------------
    //  批量解绑别名   delete_batch_alias   :批量解除别名与cid的关系
//-----------------------------------------------------------
    public function delete_batch_alias(array $inputdata =   []): array|string
    { 
        $SDK = SDK::getInstance(  self::getAllConfig( ));     
        return  $SDK->delete_batch_alias ($inputdata );  
    }
//-----------------------------------------------------------
//delete_all_alias  批量解除别名与cid的关系
//-----------------------------------------------------------
    public function delete_all_alias(string $inputdata = '' ): array|string
    { 
        $SDK = SDK::getInstance(  self::getAllConfig( ));     
        return  $SDK->delete_all_alias ($inputdata );  
    }
//-----------------------------------------------------------
//bind_custom_tag
//-----------------------------------------------------------
    public function bind_custom_tag(string $cid = '',array $inputdata =   [] ): array|string
    { 
        $SDK = SDK::getInstance(  self::getAllConfig( ));     
        return  $SDK->bind_custom_tag ($cid ,$inputdata );  
    }
//-----------------------------------------------------------
//bind_custom_tag_batch
//-----------------------------------------------------------
    public function bind_custom_tag_batch(array $cid_list = [],string $custom_tag =  '' ): array|string
    { 
        $SDK = SDK::getInstance(  self::getAllConfig( ));     
        return  $SDK->bind_custom_tag_batch ($cid_list ,$custom_tag );  
    }
//-----------------------------------------------------------
// delete_custom_tag_batch
//-----------------------------------------------------------
  public function delete_custom_tag_batch(array $cid_list = [],string $custom_tag =  '' ): array|string
    { 
        $SDK = SDK::getInstance(  self::getAllConfig( ));     
        return  $SDK->delete_custom_tag_batch ($cid_list ,$custom_tag );  
    }

//-----------------------------------------------------------
    //find_custom_tag
//----------------------------------------------------------- 
 public function find_custom_tag(string $cid =  '' ): array|string
    { 
        $SDK = SDK::getInstance(  self::getAllConfig( ));     
        return  $SDK->find_custom_tag ($cid );  
    }
//-----------------------------------------------------------
//【用户】添加黑名单用户 add_blacklist
//-----------------------------------------------------------
public function add_blacklist(array $cid_list =  [] ): array|string
    { 
        $SDK = SDK::getInstance(  self::getAllConfig( ));     
        return  $SDK->add_blacklist ($cid_list );  
    }
//-----------------------------------------------------------
// delete_blacklist 【用户】移除黑名单用户
//-----------------------------------------------------------
  public function delete_blacklist(array $cid_list =  [] ): array|string
    { 
        $SDK = SDK::getInstance(  self::getAllConfig( ));     
        return  $SDK->delete_blacklist ($cid_list );  
    }
//-----------------------------------------------------------
// find_status   【用户】查询用户状态
//-----------------------------------------------------------
  public function find_user_status(array $cid_list =  [] ): array|string
    { 
        $SDK = SDK::getInstance(  self::getAllConfig( ));     
        return  $SDK->find_user_status ($cid_list );  
    }
//-----------------------------------------------------------    
// 【用户】查询设备状态 find_device_status
//-----------------------------------------------------------
  public function find_device_status(array $cid_list =  [] ): array|string
    { 
        $SDK = SDK::getInstance(  self::getAllConfig( ));     
        return  $SDK->find_device_status ($cid_list );  
    }
//-----------------------------------------------------------
// 【用户】查询用户信息 find_user_detail
//-----------------------------------------------------------
  public function find_user_detail(array $cid_list =  [] ): array|string
    { 
        $SDK = SDK::getInstance(  self::getAllConfig( ));     
        return  $SDK->find_user_detail ($cid_list );  
    }
//-----------------------------------------------------------
//【用户】设置角标(仅支持IOS) badge
// set_badge
// badge	String	是	无	用户应用icon上显示的数字
// +N: 在原有badge上+N
// -N: 在原有badge上-N
// N: 直接设置badge(数字，会覆盖原有的badge值)
//-----------------------------------------------------------
  public function set_badge(array $cid_list =  [],int $badge =   0  ): array|string
    { 
        $SDK = SDK::getInstance(  self::getAllConfig( ));     
        return  $SDK->set_badge ($cid_list ,$badge );  
    }
//-----------------------------------------------------------
//find_user_count
//-----------------------------------------------------------
  public function find_user_count(array $key_value =  []  ): array|string
    { 
        $SDK = SDK::getInstance(  self::getAllConfig( ));     
        return  $SDK->find_user_count ($key_value  );  
    }
 

//-----------------------------------------------------------
//bind_dt
//-----------------------------------------------------------
  public function bind_dt(array $dt_list =  [],string $type =   ''  ): array|string
    { 
        $SDK = SDK::getInstance(  self::getAllConfig( ));     
        return  $SDK->bind_dt ($dt_list,$type  );  
    }
//-----------------------------------------------------------
//create_smart_crowd
//-----------------------------------------------------------
  public function create_smart_crowd( string $name,array $tasks, array $brand_list,int $package_num, int $active_range,int $active_type,bool  $is_overlap   ): array|string
    { 
        $SDK = SDK::getInstance(  self::getAllConfig( ));     
        return  $SDK->create_smart_crowd (  $name,  $tasks,   $brand_list,  $package_num,   $active_range,  $active_type,   $is_overlap );  
    }
//-----------------------------------------------------------
// smart_crowd_task_list
//-----------------------------------------------------------
  public function smart_crowd_task_list( array  $sub_task_ids =  []   ): array|string
    { 
        $SDK = SDK::getInstance(  self::getAllConfig( ));     
        return  $SDK->smart_crowd_task_list (  $sub_task_ids );
    }
//-----------------------------------------------------------
// smart_crowd_model_list
//-----------------------------------------------------------
  public function smart_crowd_model_list( string  $name = '' , int $status  =  0   ): array|string
    { 
        $SDK = SDK::getInstance(  self::getAllConfig( ));     
        return  $SDK->smart_crowd_model_list (  $name  ,   $status );
    }
//-----------------------------------------------------------
// // 【toList】创建消息   create_task_push_list_message
//-----------------------------------------------------------
  public function create_task_push_list_message( array  $data =  []  ): array|string
    { 
        $SDK = SDK::getInstance(  self::getAllConfig( ));     
        return  $SDK->create_task_push_list_message (  $data);
    }
//-----------------------------------------------------------
//push_list_cid
//-----------------------------------------------------------
  public function push_list_cid( array  $data =  []  ): array|string
    { 
        $SDK = SDK::getInstance(  self::getAllConfig( ));     
        return  $SDK->push_list_cid (  $data);
    }
//-----------------------------------------------------------
// push_list_alias
//-----------------------------------------------------------
  public function push_list_alias( array  $data =  []  ): array|string
    { 
        $SDK = SDK::getInstance(  self::getAllConfig( ));     
        return  $SDK->push_list_alias (  $data);
    }



//-----------------------------------------------------------
//  push_all
//-----------------------------------------------------------
  public function push_all( array  $data =  []  ): array|string
    { 
        $SDK = SDK::getInstance(  self::getAllConfig( ));     
        return  $SDK->push_all (  $data);
    }


//-----------------------------------------------------------
// push_tag
//-----------------------------------------------------------
  public function push_tag( array  $data =  []  ): array|string
    { 
        $SDK = SDK::getInstance(  self::getAllConfig( ));     
        return  $SDK->push_tag (  $data);
    }
//-----------------------------------------------------------
//push_fast_custom_tag
//-----------------------------------------------------------
  public function push_fast_custom_tag( array  $data =  []  ): array|string
    { 
        $SDK = SDK::getInstance(  self::getAllConfig( ));     
        return  $SDK->push_fast_custom_tag (  $data);
    }

//-----------------------------------------------------------
//delete_task
//-----------------------------------------------------------
  public function delete_task( array  $data =  []  ): array|string
    { 
        $SDK = SDK::getInstance(  self::getAllConfig( ));     
        return  $SDK->delete_task (  $data);
    }
//-----------------------------------------------------------
//find_schedule_task
//-----------------------------------------------------------
  public function find_schedule_task( array  $data =  []  ): array|string
    { 
        $SDK = SDK::getInstance(  self::getAllConfig( ));     
        return  $SDK->find_schedule_task (  $data);
    }
//-----------------------------------------------------------
    //delete_schedule_task
//-----------------------------------------------------------
  public function delete_schedule_task( array  $data =  []  ): array|string
    { 
        $SDK = SDK::getInstance(  self::getAllConfig( ));     
        return  $SDK->delete_schedule_task (  $data);
    }

//-----------------------------------------------------------
//find_message_detail
//-----------------------------------------------------------
  public function find_message_detail( array  $data =  []  ): array|string
    { 
        $SDK = SDK::getInstance(  self::getAllConfig( ));     
        return  $SDK->find_message_detail (  $data);
    }
//-----------------------------------------------------------
// find_report_push_task
//-----------------------------------------------------------

  public function find_report_push_task( array  $data =  []  ): array|string
    { 
        $SDK = SDK::getInstance(  self::getAllConfig( ));     
        return  $SDK->find_report_push_task (  $data);
    }
//-----------------------------------------------------------
//find_report_push_custom_task
//-----------------------------------------------------------
  public function find_report_push_custom_task( array  $data =  [] ,array $actionId_list =   [] ): array|string
    { 
        $SDK = SDK::getInstance(  self::getAllConfig( ));     
        return  $SDK->find_report_push_custom_task (  $data,  $actionId_list  );
    }
//-----------------------------------------------------------
//find_report_push_task_group
//-----------------------------------------------------------

  public function find_report_push_task_group( array  $data =  [] ): array|string
    { 
        $SDK = SDK::getInstance(  self::getAllConfig( ));     
        return  $SDK->find_report_push_task_group (  $data  );
    }
//-----------------------------------------------------------
//find_report_push_task_task_detail
//-----------------------------------------------------------
  public function find_report_push_task_task_detail( array  $data =  [] ): array|string
    { 
        $SDK = SDK::getInstance(  self::getAllConfig( ));     
        return  $SDK->find_report_push_task_task_detail (  $data  );
    }
//-----------------------------------------------------------
//find_report_push_date
//-----------------------------------------------------------
  public function find_report_push_date( array  $data =  [] ): array|string
    { 
        $SDK = SDK::getInstance(  self::getAllConfig( ));     
        return  $SDK->find_report_push_date (  $data  );
    }

//-----------------------------------------------------------
// find_report_push_count
//-----------------------------------------------------------
  public function find_report_push_count( array  $data =  [] ): array|string
    { 
        $SDK = SDK::getInstance(  self::getAllConfig( ));     
        return  $SDK->find_report_push_count (  $data  );
    }

//-----------------------------------------------------------
//find_report_user_date
//-----------------------------------------------------------
  public function find_report_user_date( array  $data =  [] ): array|string
    { 
        $SDK = SDK::getInstance(  self::getAllConfig( ));     
        return  $SDK->find_report_user_date (  $data  );
    }
//-----------------------------------------------------------
//find_report_online_user
//-----------------------------------------------------------


  public function find_report_online_user( array  $data =  [] ): array|string
    { 
        $SDK = SDK::getInstance(  self::getAllConfig( ));     
        return  $SDK->find_report_online_user (  $data  );
    }





    //==========================. end .==========================
}
