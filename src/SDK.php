<?php 
namespace Suxianjia\xianjia_getui_sdk;
use Suxianjia\xianjia_getui_sdk\Core\Cache;
use Suxianjia\xianjia_getui_sdk\Core\HttpClient;
use InvalidArgumentException;
class SDK {
    private static $instance = null;
    private $config = [ 
        'getui' =>  [

                'test_cid' =>     '6a789e7bc8fb0ffe24b3a4e08b665ee7' , // 2.0 IOS.  
                //    'test_cid' =>  '528df7effcb4bd85a63bfd16d2f29ba0'    , //  2.0  android

                    //    'test_cid' =>  '015bf81460a8cce1916d45db7fe42c04'    , //  1.0  android
                    'appkey' => '',
                    'appId' => '',    // 其中appId为用户创建应用时生成的应用唯一标识，$为变量符。例如当前的appid值为 aaaaa，则接口前缀(BaseUrl)为: https://restapi.getui.com/v2/aaaaa
                    'sign' => '', 	//String	是	无	鉴权时的签名。
                                        //-----------------生成 sign 值：将 appkey、timestamp、mastersecret 对应的字符串按此固定顺序拼接后，使用 SHA256 算法加密。
                                        //-----------------示例 java 代码格式: String sign = sha256(appkey+timestamp+mastersecret)
                    'timestamp'=> '',	//String	是	无	毫秒时间戳（13位），请使用当前毫秒时间戳，误差太大可能出错 
                    'mastersecret' => '',    //mastersecret 对应的字符串按此固定顺序拼接后
        ]
    ];

    // 个推开放平台接口前缀(BaseUrl): https://restapi.getui.com/v2/$appId 
// https://ido.getui.com/openapi/$appId
private $baseUrl = 'https://ido.getui.com/openapi/';
private $push_type = 'toSingle'; 
private $push_type_list  =[
    'toSingle'  , //     toSingle ：简称“单推”，指向单个用户推送消息
    'toList'  ,// toList：简称“批量推”，指向指定的一批用户推送消息
    'toApp'  ,// toApp：简称“群推”，指向APP符合筛选条件的所有用户推送消息，支持定速推送、定时推送，支持条件的交并补功能
] ; 
const DEFAULT_TTL = 7200000; // 默认2小时有效期
const TOKEN_EXPIRE_TIME = 0; // 默认2小时有效期
   private $token = [
    "token" => "",
    "expireTime" => ""  
   ];//  String    是    无    鉴权成功后返回的token，有效期为24小时，过期后需重新鉴权


private $platformMap = [
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

//-----------------------------------------------------------
    /**
     * 私有克隆方法，防止对象被克隆
     * 
     * 此方法通过抛出异常来阻止对当前类的实例进行克隆操作，
     * 确保单例模式的完整性
     */
    private function __clone(): void
    {
        // 阻止克隆
    } 






//-----------------------------------------------------------
//              output
//-----------------------------------------------------------    
    private   function output (string $REQUEST = 'get', string $url =  '',array $query = [] , array $body = []  ): array|string {
        // $body = [     ];
        // $query = [  ]; 
        $client = new HttpClient();
        // 设置请求头 
        $header = [  
        'Content-Type: application/json;charset=utf-8',
        'Accept: application/json',
            'Token: '. $this->getAuth()
        ];  
        $res = match( $REQUEST ) {
            'get' => $client->get( $this->getApiUrl().$url ,  $query,    $header ),
            'post' => $client->post( $this->getApiUrl().$url ,  $query,   $body, $header  ),
            'put' => $client->put( $this->getApiUrl().$url ,  $query,  $body,  $header  ),
            'delete' => $client->delete( $this->getApiUrl().$url ,  $query,  $body,  $header ),
            default => throw new InvalidArgumentException('Invalid auth parameters') 
        };  


        $config = $this->getConfig(null);
        $Cache = Cache::getInstance($config); 

        if ($res['network_status'] == 200) {
                return $res;
        } else if ($res['network_status'] == 401) { 
                /*
                10001	token错误/失效	调用接口重新获取token	401
                10002	appId或ip在黑名单中		401
                10003	每分钟鉴权频率超限	接口调用过于频繁	401
                10004	没有查询消息明细的权限	可以申请权限，若有需要，请点击右侧“技术咨询”了解详情	401
                10005	每分钟调用频率超限
                */
                return match( $res['code'] ) {  
                    10001 => (function () use ($Cache, $REQUEST , $url, $query, $body): array|string {
                            $Cache->delete('auth');  
                            return $this->output($REQUEST, $url, $query, $body);
                        })(), 
                    default =>   $res,
                }; 
        } else if ($res['network_status'] == 404) { 
            $res['msg'] = 'url错误	请检查Http路径是否正确';
            return $res;
            // 404	url错误	请检查Http路径是否正确	404
        } else if ($res['network_status'] == 405) {
            // 405	方法不支持	该接口不支持该方法请求，请查看文档确认请求方式	405
            $res['msg'] = '方法不支持	该接口不支持该方法请求，请查看文档确认请求方式'; 
            return $res;
        }   else { 
            return $res;
        }



        
       
   
    }


//-----------------------------------------------------------
public function setAppId($appId): void { 
        $this->config['getui']['appId'] = $appId;   
} 
//-----------------------------------------------------------
public function getAppId(): string { 
    return $this->config['getui']['appId'];
} 
//-----------------------------------------------------------
//appkey
public function setAppkey($appkey): void {  
     $this->config['getui']['appkey'] = $appkey;  
} 
//-----------------------------------------------------------
public function getAppkey(): string { 
    return $this->config['getui']['appkey'];
}   



//-----------------------------------------------------------
// 'timestamp' => '', //毫秒时间戳（13位），请使用当前毫秒时间戳，误差太大可能出错
public function getTimestamp(): string {
    // /毫秒时间戳（13位），请使用当前毫秒时间戳，误差太大可能出错
    // $timestamp = time()*1000;
     $timestamp = round(microtime(true)*1000);

     if(  strlen($timestamp) != 13) {
        // throw new \InvalidArgumentException('Invalid auth parameters');
    }

    return $timestamp;
}
//-----------------------------------------------------------
// mastersecret mastersecret 对应的字符串按此固定顺序拼接
public function getMasterSecret(): string {   
     return    $this->config['getui']['mastersecret'] ;  
}
 //-----------------------------------------------------------
public function setMasterSecret($mastersecret = ''): void {  
    $this->config['getui']['mastersecret'] = $mastersecret;  
}    

//-----------------------------------------------------------
//php getSign  sign 
public function getSign(): string {  
    $sign = hash('sha256', $this->getAppkey().$this->getTimestamp().$this->getMasterSecret()); 
    return $sign;
}

//-----------------------------------------------------------
    private function validateConfig($config) {
        // 配置校验逻辑
    }
//-----------------------------------------------------------
 public function __construct( $config = [] ) { 
        if (!empty($config)) {
            $currentConfig = $this->config;
            foreach ($config as $key => $value) { 
                if (is_array($value)) {
                    foreach ($value as $key2 => $value2) {
                        $currentConfig[$key][$key2] = $value2;
                    }
                } else {
                    $currentConfig[$key] = $value; 
                }
            }
            $this->config = $currentConfig;
        }
    }
//-----------------------------------------------------------
    public static function getInstance( $config = [] ): SDK { 
        if (self::$instance === null) {
            self::$instance = new self( $config );
        }
        return self::$instance;
    }


//-----------------------------------------------------------
private function generateRequestId(): string {
    return 'gt_'.date('YmdHis').'_'.bin2hex(random_bytes(4));
}

//-----------------------------------------------------------
public function getConfig($key = null): string | array {
    if ( $key == null) {
            return $this->config ;
    }
    return $this->config [$key];
}
//-----------------------------------------------------------
public function setConfig($key, $value): void {
      $this->config[$key] = $value ; 
}
//-----------------------------------------------------------
//private $push_type = 'toSingle'; 
public function getPush_type(): string {
    return $this->push_type;
}
//-----------------------------------------------------------
public function setPush_type($push_type = ''): void {
      $this->push_type = $push_type ;
}
//-----------------------------------------------------------
public function getAuth(): string {
 
    $token ='';
    $config =  $this->getConfig(null);
    $Cache = Cache::getInstance($config);   
    if ($Cache::has('auth')) {
        $token = $Cache::get('auth');
        if (time() < $token['expire_time']) {
            return $token['token'];
        }else{
            $Cache::delete('auth'); 
            return $this->getAuth(); 
        }
    }else{
        $res = $this->auth();
        if(   $res['code'] == 0){
                $token = $res['data']; 
        }else { 
        //   throw new \InvalidArgumentException('Invalid auth parameters');
        }
    }
    $this->token =   $token;
    return $this->token ['token'];
}

// const TOKEN_EXPIRE_TIME = 3600; // 默认2小时有效期
//-----------------------------------------------------------
public function setAuth($token = []): void { 
    $this->token = $token ; 
    $config =  $this->getConfig(null);
    $Cache = Cache::getInstance($config);   
    $Cache ::set('auth', $token, self::TOKEN_EXPIRE_TIME);
}
//-----------------------------------------------------------
private function getBaseUrl(): string {
    return 'https://ido.getui.com/openapi/'.$this->getAppId().'/';
}
//-----------------------------------------------------------
private function getApiUrl(): string {
    return 'https://restapi.getui.com/v2/'.$this->getAppId().'/';
}
 /**
 * -----------------------------------------------------------
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 *  01 鉴权API
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * https://docs.getui.com/getui/server/rest_v2/token/
 * 
 * -----------------------------------------------------------
*/





//-----------------------------------------------------------
// 获取鉴权token 
//              token是个推开放平台全局唯一接口调用凭据，访问所有接口都需要此凭据，开发者需要妥善保管。
//              token的有效期截止时间通过接口返回参数expire_time来标识，目前是接口调用时间+1天的毫秒时间戳。
//              token过期后无法使用，开发者需要定时刷新。为保证高可用，建议开发者在定时刷新的同时做被动刷新，即当调用业务接口返回错误码10001时调用获取token被动刷新
//              curl $BaseUrl/auth -X POST -H "Content-Type: application/json;charset=utf-8" -d '{"sign": "","timestamp": "","appkey": ""}'
//              curl https://ido.getui.com/openapi/M9vbNu1awUARfJa0AqTvN8/auth -X POST -H "Content-Type: application/json;charset=utf-8" -d '{"sign": "273df9d1128b7bc463173bab08c44cd5b91c61961bf1756da08c81dad60ee71c","timestamp": "1752821563000","appkey": "91LnMVq9Uk7WYzaaIsgNH2"}'
//-----------------------------------------------------------
public function auth(): array|string {  
    $query = [  ]; 
    $body = [
        "sign" => $this->getSign(), 
        "timestamp" => $this->getTimestamp(), 
        "appkey" => $this->getAppkey()
    ];
    $client = new HttpClient(); 
    $header = [      ];
    $res = $client->post( $this->getApiUrl().'auth', $query,$body,    $header );  
    if(   $res['network_status'] == 200 &&  $res['code'] == 0){
        $this->setAuth($res['data']);  
    }
    return $res;
} 
//-----------------------------------------------------------
//  删除鉴权token
//                  为防止token被滥用或泄露，开发者可以调用此接口主动使token失效。
//                  curl $BaseUrl/auth/$token -X DELETE
//-----------------------------------------------------------
public function auth_delete() {  
    $query = [  ];  
    $body = [];  
     return $this->output( 'delete',  'auth', $query ,$body ); 
} 

 /**
 * -----------------------------------------------------------
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 *  02 推送API
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * https://docs.getui.com/getui/server/rest_v2/push/
 * 
 * -----------------------------------------------------------
*/

//-----------------------------------------------------------
// 【toSingle】执行cid单推
//              https://docs.getui.com/getui/server/rest_v2/push/ 
//              接口地址: BaseUrl/push/single/alias
//-----------------------------------------------------------
public function push_single_alias(array $inputData = []): array|string {  
    $query = [  ]; 
     // 参数校验
    if (empty($inputData['audience']['alias'])) {
        throw new InvalidArgumentException('alias 不能为空');
    } 
    $notification = $inputData['push_message']['notification'] ?? [];
    if (empty($notification['title']) || empty($notification['body'])) {
        throw new InvalidArgumentException('通知标题和内容必须填写');
    }
// 构建请求数据
    $body = [ 
        'request_id' => $inputData['request_id'] ?? $this->generateRequestId(),
        'settings' => [
            'ttl' => $inputData['settings']['ttl'] ?? self::DEFAULT_TTL,
            'strategy' => [
                'default' => 1
                ]
        ],
        'audience' => [
            'alias' => (array)$inputData['audience']['alias']
        ],
        'push_message' => $inputData['push_message']
    ];
 
    // 发送请求 https://restapi.getui.com/v2/{appId}/
    return $this->output( 'post',  'push/single/alias', $query ,$body  ); 
}
//-----------------------------------------------------------
// 【toSingle】执行别名单推
//-----------------------------------------------------------
public function push_single_cid(array $inputData = []): array|string {  
    $query = [  ]; 
     // 参数校验
    if (empty($inputData['audience']['cid'])) {
        throw new InvalidArgumentException('CID不能为空');
    } 
    $notification = $inputData['push_message']['notification'] ?? [];
    if (empty($notification['title']) || empty($notification['body'])) {
        throw new InvalidArgumentException('通知标题和内容必须填写');
    }
// 构建请求数据 
    $body = [ 
        'request_id' => $inputData['request_id'] ?? $this->generateRequestId(),
        'settings' => [
            'ttl' => $inputData['settings']['ttl'] ?? self::DEFAULT_TTL,
            'strategy' => [
                'default' => 1
                ]
        ],
        'audience' => [
            'cid' => (array)$inputData['audience']['cid']
        ],
        'push_message' => $inputData['push_message']
    ]; 
 
    // 发送请求 https://restapi.getui.com/v2/{appId}/
    return $this->output( 'post',  'push/single/cid', $query,$body ); 
}
//-----------------------------------------------------------
// 【toSingle】执行cid批量单推
//              接口地址: BaseUrl/push/single/batch/cid 
//-----------------------------------------------------------

public function push_single_batch_cid(array $inputData = []): array|string {  
     $query = [  ]; 
     // 参数校验
    if (empty($inputData['msg_list'][0]['audience']['cid'])) {
        throw new InvalidArgumentException('CID不能为空');
    } 
    $notification = $inputData['msg_list'][0]['push_message']['notification'] ?? [];
    if (empty($notification['title']) || empty($notification['body'])) {
        throw new InvalidArgumentException('通知标题和内容必须填写');
    }
// 构建请求数据
    $body = [ 
        "is_async"  =>  $inputData['is_async'] ??  true, //is_async	boolean	否	false	是否异步推送，true是异步，false同步。异步推送不会返回data详情
        "msg_list" => [
        // [
        //     'request_id' => $inputData['msg_list'][0]['request_id'] ?? $this->generateRequestId(),
        //     'settings' => [
        //         'ttl' => $inputData['msg_list'][0]['settings']['ttl'] ?? self::DEFAULT_TTL,
        //         'strategy' => [
        //             'default' => 1
        //             ]
        //             ],
        //             'audience' => [
        //                 'cid' => (array)$inputData['msg_list'][0]['audience']['cid']
        //                 ],
        //                 'push_message' => $inputData['msg_list'][0]['push_message']
        //                 ]
        // ]
        ] 
    ]; 
    foreach ($inputData['msg_list'] as $key => $value) {
        array_push($data['msg_list'], $value); 
    }
  
    // 发送请求 https://restapi.getui.com/v2/{appId}/
    return $this->output( 'post',  '/push/single/batch/cid', $query,$body  ); 
}



//-----------------------------------------------------------
// 【toSingle】执行别名批量单推
//                      执行别名批量单推
//                      批量发送单推消息，在给每个别名用户的推送内容都不同的情况下，可以使用此接口 
//                      接口地址: /push/single/batch/alias
//-----------------------------------------------------------
 
public function push_single_batch_alias(array $inputData = []): array|string {  
    $query = [  ]; 
     // 参数校验
    if (empty($inputData['msg_list'][0]['audience']['alias'])) {
        throw new InvalidArgumentException('alias 不能为空');
    } 
    $notification = $inputData['msg_list'][0]['push_message']['notification'] ?? [];
    if (empty($notification['title']) || empty($notification['body'])) {
        throw new InvalidArgumentException('通知标题和内容必须填写');
    }
// 构建请求数据
    $body = [ 
        "is_async"  =>  $inputData['is_async'] ??  true, //is_async	boolean	否	false	是否异步推送，true是异步，false同步。异步推送不会返回data详情
        "msg_list" => [
        // [
        //     'request_id' => $inputData['msg_list'][0]['request_id'] ?? $this->generateRequestId(),
        //     'settings' => [
        //         'ttl' => $inputData['msg_list'][0]['settings']['ttl'] ?? self::DEFAULT_TTL,
        //         'strategy' => [
        //             'default' => 1
        //             ]
        //             ],
        //             'audience' => [
        //                 'alias' => (array)$inputData['msg_list'][0]['audience']['alias']
        //                 ],
        //                 'push_message' => $inputData['msg_list'][0]['push_message']
        //                 ]
        // ]
        ] 
    ]; 
    foreach ($inputData['msg_list'] as $key => $value) {
        array_push($data['msg_list'], $value); 
    }
 
    return $this->output( 'post',  '/push/single/batch/alias', $query,$body ); 
}
//-----------------------------------------------------------
// 【toList】创建消息   push_list_message
//                          此接口用来创建消息体，并返回taskid，为批量推的前置步骤
//                          注：此接口频次限制200万次/天，申请修改请点击右侧“技术咨询”了解详情。
//                          接口地址: BaseUrl/push/list/message
// 请求方式: POST 
//-----------------------------------------------------------
public function create_task_push_list_message(array $inputData = []): array|string {  
 $query = [  ];  
    $body = [ 
        'group_name' =>   '', //group_name	String	否	无	任务组名（只允许填写数字、字母、横杠、下划线）
        'settings' =>    [] , //settings	 	Json	否	无	推送条件设置
        'push_message' =>  [], //push_message	Json	是	无	个推推送消息参数，详细内容见push_message
        //  'push_channel' =>  [ 'ios' ,'android','mp','harmony' ], //push_channel	Json	否	无	厂商推送消息参数， 包含ios消息参数，android厂商消息参数，详细内容见push_channel
    ]; 

    foreach ( $inputData AS  $key => $value) {
        $body[$key] = $value ;
    } 
     /*
     {
        "group_name":"task_se688081af99b75",
        "settings":{
            "ttl":7200000
        },
        "push_message":{
                "notification":{
                        "title":"\u6d4b\u8bd5\u6807\u9898",
                        "body":"\u6d4b\u8bd5\u5185\u5bb9",
                        "click_type":"url",
                        "url":"https:\/\/www.baidu.com\/"
                }
        },
        "push_channel":[]
     }
     */
        //https://docs.getui.com/getui/server/rest_v2/common_args/?id=doc-title-7
    // echo (  json_encode($body)    );
    // taskid	String	任务编号，用于执行cid批量推和执行别名批量推，此taskid可以多次使用，有效期为用户设置的离线时间
     return $this->output( 'post',  'push/list/message', $query ,$body ); 
 
}



//-----------------------------------------------------------
// 【toList】执行cid批量推
//                              对列表中所有cid进行消息推送。调用此接口前需调用创建消息接口设置消息内容。
//                              接口地址: BaseUrl/push/list/cid
// 请求方式: POST
//-----------------------------------------------------------
public function push_list_cid(array $inputData = []): array|string {  
 $query = [  ];  
    $body = [ 
        'audience' =>    [
            'cid' => []
        ], 
         'taskid' =>    '' , // 
        'is_async' =>  true, // 
    ];  
    foreach ( $inputData AS  $key => $value) {
        $body[$key] = $value ;
    }  
     return $this->output( 'post',  'push/list/cid', $query ,$body ); 
 
}







//-----------------------------------------------------------
// 【toList】执行别名批量推
//                          对列表中所有别名进行消息推送。调用此接口前需调用创建消息接口设置消息内容。
//                          接口地址: BaseUrl/push/list/alias
// 请求方式: POST
//-----------------------------------------------------------
public function push_list_alias(array $inputData = []): array|string {  
 $query = [  ];  
    $body = [ 
        'audience' =>    [
            'alias' => []
        ], 
        'taskid' =>    '' , // 
        'is_async' =>  true, // 
    ];  
    foreach ( $inputData AS  $key => $value) {
        $body[$key] = $value ;
    }  
     return $this->output( 'post',  'push/list/alias', $query ,$body ); 
}

//-----------------------------------------------------------
// 【toApp】执行群推
//                      对指定应用的所有用户群发推送消息。支持定时、定速功能，查询任务推送情况请见接口查询定时任务。
//                      注：此接口频次限制20次/天，每分钟不能超过5次(推送限制和接口根据条件筛选用户推送共享限制)
//                      接口地址: BaseUrl/push/all
// 请求方式: POST
//-----------------------------------------------------------
public function push_all(array $inputData = []): array|string {  
 $query = [  ];  
    $body = [ 
     "request_id" =>  uniqid(),
  "group_name"  => "请填写任务组名",
  "settings"  =>  [
    "ttl"  =>  7200000
  ],
  "audience"  => "all",
  "push_message"  =>  [
    "notification"  =>  [
      "title"  =>  "请填写通知标题",
      "body"  =>  "请填写通知内容",
      "click_type"  =>  "url",
      "url"  =>  "https//:xxx"
    ]
  ]
    ];  
    foreach ( $inputData AS  $key => $value) {
        $body[$key] = $value ;
    }  
     return $this->output( 'post',  'push/all', $query ,$body ); 
}

//-----------------------------------------------------------
// 【toApp】根据条件筛选用户推送
//                              对指定应用的符合筛选条件的用户群发推送消息。支持定时、定速功能。
//                              注：此接口频次限制20次/天，每分钟不能超过5次(推送限制和接口执行群推共享限制)，定时推送功能需要申请开通才可以使用，申请修改请点击右侧“技术咨询”了解详情。
//                              注：个推用户画像中的，单身、已婚、彩票类标签已经下架，请开发者及时关注和处理。
//                              接口地址: BaseUrl/push/tag
// 请求方式: POST
//-----------------------------------------------------------
public function push_tag(array $inputData = []): array|string {  
 $query = [  ];  
    $body = [ 
     "request_id" =>  uniqid(),
  "group_name"  => "请填写任务组名",
  "settings"  =>  [
    "ttl"  =>  7200000
  ],
  "audience"  => [
     "tag"  => [
                            [
                                "key" => "phone_type",
                                "values" => [
                                    "android"
                                ],
                                "opt_type" => "and"
                            ],
    ],
  ],
  "push_message"  =>  [
    "notification"  =>  [
      "title"  =>  "请填写通知标题",
      "body"  =>  "请填写通知内容",
      "click_type"  =>  "url",
      "url"  =>  "https//:xxx"
    ]
  ]
    ];  
    foreach ( $inputData AS  $key => $value) {
        $body[$key] = $value ;
    }  
     return $this->output( 'post',  'push/tag', $query ,$body ); 
}


//-----------------------------------------------------------
// 【toApp】使用标签快速推送
//                          根据标签过滤用户并推送。支持定时、定速功能。
//                          注：该功能需要申请相关套餐，请点击右侧“技术咨询”了解详情 。
//                          接口地址: BaseUrl/push/fast_custom_tag
// 请求方式: POST
//-----------------------------------------------------------
public function push_fast_custom_tag(array $inputData = []): array|string {  
 $query = [  ];  
    $body = [ 
     "request_id" =>  uniqid(),
  "group_name"  => "请填写任务组名",
  "settings"  =>  [
    "ttl"  =>  7200000
  ],
  "audience"  => [
    "fast_custom_tag" => "xxxx",

  ],
  "push_message"  =>  [
    "notification"  =>  [
      "title"  =>  "请填写通知标题",
      "body"  =>  "请填写通知内容",
      "click_type"  =>  "url",
      "url"  =>  "https//:xxx"
    ]
  ]
    ];  
    foreach ( $inputData AS  $key => $value) {
        $body[$key] = $value ;
    }  
     return $this->output( 'post',  'push/fast_custom_tag', $query ,$body ); 
}



//-----------------------------------------------------------
// 【任务】停止任务
//                          对正处于推送状态，或者未接收的消息停止下发（只支持批量推和群推任务）
//                          接口地址: BaseUrl/task/$taskid
// 请求方式: DELETE
//-----------------------------------------------------------
public function delete_task(array $inputData = []): array|string {  
 $query = [  ];  
    $body = [    ];  
    foreach ( $inputData AS  $key => $value) {
        $body[$key] = $value ;
    }  
    $taskid = $inputData['taskid'] ;
     return $this->output( 'delete',  'task/'.$taskid, $query ,$body ); 
}




//-----------------------------------------------------------
// 【任务】查询定时任务
//                          该接口支持在推送完定时任务之后，查看定时任务状态，定时任务是否发送成功。
//                          创建定时任务请见接口执行群推
//                          接口地址: BaseUrl/task/schedule/$taskid
// 请求方式: GET
//-----------------------------------------------------------
public function find_schedule_task(array $inputData = []): array|string {  
 $query = [  ];  
    $body = [    ];  
    foreach ( $inputData AS  $key => $value) {
        $body[$key] = $value ;
    }  
    $taskid = $inputData['taskid'] ;
     return $this->output( 'get',  'task/schedule/'.$taskid, $query ,$body ); 
}

//-----------------------------------------------------------
// 【任务】删除定时任务
//                      用来删除还未下发的任务，删除后定时任务不再触发(距离下发还有一分钟的任务，将无法删除，后续可以调用停止任务接口。)
//                      接口地址: BaseUrl/task/schedule/$taskid
// 请求方式: DELETE
//-----------------------------------------------------------
public function delete_schedule_task(array $inputData = []): array|string {  
 $query = [  ];  
    $body = [    ];  
    foreach ( $inputData AS  $key => $value) {
        $body[$key] = $value ;
    }  
    $taskid = $inputData['taskid'] ;
     return $this->output( 'delete',  'task/schedule/'.$taskid, $query ,$body ); 
}




//-----------------------------------------------------------
// 【推送】查询消息明细
//                          调用此接口可以查询某任务下某cid的具体实时推送路径情况
//                          使用该接口需要申请权限，若有需要，请点击右侧“技术咨询”了解详情
//                          接口地址: BaseUrl/task/detail/${cid}/${taskid}
// 请求方式: GET
//-----------------------------------------------------------
public function find_message_detail(array $inputData = []): array|string {  
 $query = [  ];  
    $body = [    ];  
    foreach ( $inputData AS  $key => $value) {
        $body[$key] = $value ;
    }  
    $cid = $inputData['cid'] ;
    $taskid = $inputData['taskid'] ;
     return $this->output( 'get',  'task/detail/'.$cid.'/'.$taskid, $query ,$body ); 
}
 

/**
 * -----------------------------------------------------------
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 *  04 用户API
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * -----------------------------------------------------------
*/
 

//-----------------------------------------------------------
// 【别名】绑定别名 bind_alias 
// https://docs.getui.com/getui/server/rest_v2/user/?id=doc-title-1 
//-----------------------------------------------------------
public function bind_alias( array $data_list = []): array|string {   
      $query = [  ]; 
// 构建请求数据 	Json Array
    $body = [  
        'data_list' => [
           [  
            'cid' =>  '',
            'alias' =>  ''
           ], 
        ], 
    ];
    foreach($data_list as $key => $value){
        $body['data_list'][$key]['cid'] = $value['cid'];
        $body['data_list'][$key]['alias'] = $value['alias'];
    } 
    return $this->output( 'post',  'user/alias', $query ,$body   ); 
}

//-----------------------------------------------------------
// 【别名】根据cid查询别名
//-----------------------------------------------------------
public function find_alias( string $cid = ''): array|string {    
    $body = [     ];
     $query = [  ];  
    return $this->output( 'get',  'user/alias/cid/'.$cid,  $query  ); 
}
//-----------------------------------------------------------
// 【别名】根据别名查询cid find_cid
//-----------------------------------------------------------
public function find_cid ( string $alias = ''): array|string {    
    $body = [   ];
     $query = [  ];  
    return $this->output( 'get', 'user/cid/alias/'.$alias,  $query  ); 
}
//-----------------------------------------------------------
// 【别名】批量解绑别名
//                  批量解绑别名   delete_batch_alias   :批量解除别名与cid的关系
// {
//       "cid": "",
//       "alias": ""
//     },
//                  接口地址: BaseUrl/user/alias
// 请求方式: DELETE
//-----------------------------------------------------------
public function delete_batch_alias ( array $data_list =  []) {    
    $body = [  
        'data_list' => []
    ];
    foreach($data_list as $key => $value){
        array_push($body['data_list'], $value);   
    }
           $query = [  ]; 
    $client = new HttpClient();
// 设置请求头
    $header = [  
        'Content-Type: application/json;charset=utf-8',
        'Accept: application/json',
         'Token: '. $this->getAuth()
    ];  

       return $this->output( 'delete',  'user/alias', $query ,$body ); 
}


//-----------------------------------------------------------
// 【别名】解绑所有别名    解绑所有与该别名绑定的cid  delete_all_alias   :批量解除别名与cid的关系
//                      接口地址: BaseUrl/user/alias/$alias
// 请求方式: DELETE
//-----------------------------------------------------------
public function delete_all_alias (  string $alias = ''): array|string {    
    $body = [   ];
    $query = [  ]; 
  return $this->output( 'delete',  'user/alias/'.$alias, $query ,$body );  
}

//-----------------------------------------------------------
// 【标签】一个用户绑定一批标签 
// 请求方式: POST      /user/custom_tag/cid/$cid $custom_tag
//-----------------------------------------------------------
public function bind_custom_tag(string  $cid, array $custom_tag = []): array|string {   
// 构建请求数据 	Json Array
    $body = [  
        'custom_tag' => $custom_tag, 
    ];
     $query = [  ];  
    // 发送请求 https://restapi.getui.com/v2/{appId}/   设置tag操作超过接口每日频次限制(每天最多10000次) 
    return $this->output(  'post','user/custom_tag/cid/'.$cid, $query,$body ); 
}
//-----------------------------------------------------------
// 【标签】一批用户绑定一个标签  
//                      接口地址: BaseUrl/user/custom_tag/batch/$custom_tag
// 请求方式: PUT 
//-----------------------------------------------------------
public function bind_custom_tag_batch(array  $cid_list, string $custom_tag =  ''): array|string {   
// 构建请求数据 	Json Array
    $body = [  
        'cid' => [], 
    ];
    foreach ($cid_list as $key => $value){
        array_push( $body['cid'], $value);   
    }
    $query = [  ];  
    // 发送请求 https://restapi.getui.com/v2/{appId}/     
    return $this->output( 'put','user/custom_tag/batch/'.$custom_tag, $query,$body ); 
}

//-----------------------------------------------------------
// 【标签】一批用户解绑一个标签
//-----------------------------------------------------------
public function delete_custom_tag_batch(array  $cid_list, string $custom_tag =  ''): array|string {   
// 构建请求数据 	Json Array
    $body = [  
        'cid' => [], 
    ];
    foreach ($cid_list as $key => $value){
        array_push( $body['cid'], $value);   
    }
    $query = [  ];  
    return $this->output( 'delete','user/custom_tag/batch/'.$custom_tag, $query,$body ); 
}


//-----------------------------------------------------------
// 【标签】查询用户标签    
//                  接口地址: BaseUrl/user/custom_tag/cid/$cid
//-----------------------------------------------------------
public function find_custom_tag( string $cid =  ''): array|string {   
// 构建请求数据 	Json Array
    $body = [ ]; 
    $query = [  ];  
    return $this->output( 'get','user/custom_tag/cid/'.$cid,  $query  ); 
}


 
//-----------------------------------------------------------
// 【用户】添加黑名单用户 add_blacklist
//                          将单个或多个用户加入黑名单，对于黑名单用户在推送过程中会被过滤掉。 
//                          接口地址: BaseUrl/user/black/cid/$cid,$cid.  用户标识，多个以英文逗号隔开，一次最多传200个
// 请求方式: POST
//-----------------------------------------------------------
    public function add_blacklist(array $cid_list = []): array|string
    {
        // 构建请求数据
        $body = [
            'cid' => $cid_list
        ];
        $query = []; 
        return $this->output( 'post','user/black/cid/' . implode(',', $cid_list), $query, $body ) ;
    }



//-----------------------------------------------------------
// 【用户】移除黑名单用户
//                  将单个cid或多个cid用户移出黑名单，对于黑名单用户在推送过程中会被过滤掉的，不会给黑名单用户推送消息 
//                  接口地址: BaseUrl/user/black/cid/$cid,$cid
// 请求方式: DELETE
//-----------------------------------------------------------
public function delete_blacklist(array $cid_list = []): array|string
    {
        // 构建请求数据
        $body = [
            'cid' => $cid_list
        ]; 
        $query = []; 
        return $this->output( 'delete','user/black/cid/' . implode(',', $cid_list), $query, $body );
    }

//-----------------------------------------------------------
// 【用户】查询用户状态
//              查询用户的状态 
//              接口地址: BaseUrl/user/status/$cid,$cid
// 请求方式: GET 
//-----------------------------------------------------------
public function find_user_status(array $cid_list = []): array|string
    {
        // 构建请求数据
        $body = [
            'cid' => $cid_list
        ]; 
        $query = []; 
        return $this->output( 'get','user/status/' . implode(',', $cid_list), $query );
    }

//-----------------------------------------------------------
// 【用户】查询设备状态 find_device_status
//                  接口地址: BaseUrl/user/deviceStatus/$cid,$cid  用户标识，多个以英文逗号隔开，一次最多传100个
// 请求方式: GET
// 注意：
// 1.该接口返回设备在线时，仅表示存在集成了个推SDK的应用在线
// 2.该接口返回设备不在线时，仅表示不存在集成了个推SDK的应用在线
// 3.该接口需要开通权限，如需开通，请联系右侧技术咨询
//-----------------------------------------------------------
public function find_device_status(array $cid_list = []): array|string
    {
        // 构建请求数据
        $body = [
            'cid' => $cid_list
        ]; 
        $query = []; 
        return $this->output( 'get','user/deviceStatus/' . implode(',', $cid_list), $query  );
    }





//-----------------------------------------------------------
// 【用户】查询用户信息 find_user_detail
//                              查询用户的信息  接口地址: BaseUrl/user/detail/$cid,$cid 	用户标识，多个以英文逗号隔开，一次最多传1000个
// 请求方式: GET
//-----------------------------------------------------------
public function find_user_detail(array $cid_list = []): array|string
    {
        // 构建请求数据
        $body = [
            'cid' => $cid_list
        ]; 
        $query = []; 
        return $this->output( 'get','user/detail/' . implode(',', $cid_list), $query ,$body );
    }



//-----------------------------------------------------------
// 【用户】设置角标(仅支持IOS) badge
//                          通过cid通知个推服务器当前iOS设备的角标情况。 
//                          接口地址: BaseUrl/user/badge/cid/$cid,$cid
// 请求方式: POST
// set_badge
// badge	String	是	无	用户应用icon上显示的数字
// +N: 在原有badge上+N
// -N: 在原有badge上-N
// N: 直接设置badge(数字，会覆盖原有的badge值)
//-----------------------------------------------------------
public function set_badge(array $cid_list = [],int $badge =   0): array|string
    {
        // 构建请求数据
        $body = [
            'badge' => $badge,
        ];

        $query = []; 
        return $this->output( 'post','user/badge/cid/' . implode(',', $cid_list), $query,   $body );
    }


//-----------------------------------------------------------
// 【用户】查询用户总量
//                  通过指定查询条件来查询满足条件的用户数量
//                  接口地址: BaseUrl/user/count
// 请求方式: POST
//-----------------------------------------------------------
public function find_user_count(array $key_value = []): array|string
    {
        // 构建请求数据
        $body = [
            'tag' => []// $key_value
        ]; 
        foreach ( $key_value as $key => $value ) {  
            array_push( $body['tag'], $value );
        }   
        $query = []; 
        return  $this->output( 'post','user/count'  , $query,   $body ); 
    }


 


//-----------------------------------------------------------
// 【用户】批量绑定或解绑cid和deviceToken
//              接口地址: BaseUrl/user/bind_dt/$type
// 请求方式: POST
//-----------------------------------------------------------
public function bind_dt(array $dt_list = [],string $type ='' ): array|string
    {
        // 构建请求数据
        //         批量绑定或解绑cid和deviceToken的关系；
        // 默认仅支持小程序通道用户。若有其他厂商通道需要使用，请点击右侧“技术咨询”了解详情。
        // 此接口有全局频控限制，每分钟最多调用1000次。

        $body = [
            'dt_list' => [] // $dt_list // { "cid": "cid1", "device_token": "device_token1" },
                            //             cid	String	是	无	cid，用户标识
                            // device_token	String	是	无	deviceToken（传值表示绑定，不传或传空表示解绑）：
                            // 微信小程序：对应微信小程序用户的openid 
        ]; 
        foreach ( $dt_list as $key => $value ) {  
            array_push( $body['dt_list'], $value );
        }
        $query = []; 
        return  $this->output( 'post','user/bind_dt/'.$type  , $query,   $body ); 
    }



//-----------------------------------------------------------
// 【用户】创建文案圈人模型任务
// 新建文案圈人模型任务
// 说明：文案圈人模型为 SVIP 功能，需升级服务后方可使用。若须申请修改请点击右侧“技术咨询”了解详情。

// 接口地址: BaseUrl/user/smart_crowd/create
// 请求方式: POST
//-----------------------------------------------------------
public function create_smart_crowd(string $name,array $tasks, array $brand_list,int $package_num, int $active_range,int $active_type,bool  $is_overlap  ): array|string
    { 

        $body = [
'name' =>  $name ?? 'test', // 	String	是	无	任务名称，长度不大于10
'tasks' =>      $tasks ?? [], //     Json Array    是    无    不同文案任务列表，数量不大于10	Json Array	是	无	不同文案任务列表，数量不大于10
'brand_list' => $brand_list ?? [], //     String Array    是    无    覆盖的设备品牌列表，hw表示华为；xm表示小米；op表示OPPO,vv表示VIVO,mz表示魅族,other表示其他品牌	String Array	是	无	覆盖的设备机型列表，hw表示华为；xm表示小米；op表示OPPO,vv表示VIVO,mz表示魅族,other表示其他机型
'package_num' => $package_num ?? 1000, //	Number	是	无	每组人群量级上限，范围为1000~5000000
'active_range' => $active_range ?? 1, //	Number	否	无	近 ${active_range} 天活跃/非活跃用户，范围为1~90
'active_type' => $active_type ?? 1, //    Number    否    无    1表示活跃用户；-1表示非活跃户	Number	否	无	1表示活跃用户；-1表示非活跃用户
'is_overlap' => $is_overlap ?? true, //    Boolean    否    false    是否允许各种人群重合：true用表示允许；false表示不允许	Boolean	否	false	是否允许各种人群重合：true表示允许；false表示不允许
        ]; 
  
        $query = []; 
        return  $this->output( 'post','user/smart_crowd/create' , $query,   $body ); 
    }



//-----------------------------------------------------------

// 【用户】查询文案圈人任务列表 
//                  查询文案圈人任务列表
//                  说明：文案圈人模型为 SVIP 功能，需升级服务后方可使用。若须申请修改请点击右侧“技术咨询”了解详情。 
//                  接口地址: BaseUrl/user/smart_crowd/task/list
// 请求方式: POST
//-----------------------------------------------------------
public function smart_crowd_task_list( array $sub_task_ids = []): array|string
    {  
        $body = [
            'sub_task_ids' =>  [], //  sub_task_ids	String Array	是	无	文案圈人任务ID列表，数量不大于10
        ]; 
        $query = []; 
        return  $this->output( 'post','user/smart_crowd/create' , $query,   $body ); 
    }





//-----------------------------------------------------------
// 【用户】查询文案圈人模型列表
//                  查询文案圈人模型列表
//                  说明：文案圈人模型为 SVIP 功能，需升级服务后方可使用。若须申请修改请点击右侧“技术咨询”了解详情。 
//                  接口地址: BaseUrl/user/smart_crowd/model/list
// 请求方式: POST 
//-----------------------------------------------------------
public function smart_crowd_model_list( string $name =  '' , int $status = 0): array|string
    {  
        $body = [
            'name' =>  $name , //  name    String    否    无    模型名称，长度不大于10
            'status' =>  $status , //  status    Number    否    0    模型状态，0表示未发布，1表示已发布
        ]; 
        $query = []; 
        return  $this->output( 'post','user/smart_crowd/model/list' , $query,   $body ); 
    }




/**
 * -----------------------------------------------------------
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 *  03 统计API
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 * 
 *  https://docs.getui.com/getui/server/rest_v2/report/
 * -----------------------------------------------------------
*/


//-----------------------------------------------------------
// 【推送】获取推送结果（不含自定义事件）
//                                  查询推送数据，可查询近 90 天内的数据。返回结果包括：可下发数、下发数，接收数、展示数、点击数等结果。支持单个taskId查询和多个taskId查询。
//                                  此接口调用，仅可以查询toList或toApp的推送结果数据；不能查询toSingle的推送结果数据。
//                                  接口地址: BaseUrl/report/push/task/$taskid,$taskid
// 请求方式: GET
//-----------------------------------------------------------
public function find_report_push_task( array $taskid_list =   []  ): array|string
    {  
        $body = [  ]; 
        $query = []; 
        return  $this->output( 'get','report/push/task/'.  implode(',', $taskid_list) , $query,   $body ); 
    }


//-----------------------------------------------------------
// 【推送】获取推送结果（含自定义事件）
//                                  查询推送数据，可查询近 90 天内的数据。返回结果包括：可下发数、下发数，接收数、展示数、点击数等结果。支持单个taskId查询和多个taskId查询。
//                                  此接口调用，仅可以查询toList或toApp的推送结果数据；不能查询toSingle的推送结果数据。
//                                  接口地址: BaseUrl/report/push/task/$taskid,$taskid?actionIdList=$actionId,$actionId,$actionId
// 请求方式: GET
//-----------------------------------------------------------
public function find_report_push_custom_task( array $taskid_list =   [] ,array $actionId_list =   []  ): array|string
    {  
        $body = [  ]; 
        $query = []; 
        return  $this->output( 'get','report/push/task/'.  implode(',', $taskid_list) .'?actionIdList='.  implode(',', $actionId_list) , $query,   $body ); 
    }



//-----------------------------------------------------------
// 【推送】任务组名查报表
//                              根据任务组名查询推送结果，可查询近 70 天内的数据。返回结果包括：消息可下发数、下发数，接收数、展示数、点击数。
//                              接口地址: BaseUrl/report/push/task_group/$group_name
// 请求方式: GET
//-----------------------------------------------------------
public function find_report_push_task_group( array $data =   []    ): array|string
    {  
        $body = [    ]; 
        $query = [
            'needGetuiByBrand' => $data ['needGetuiByBrand'] ?? false, //	Boolean	否	False	是否需要个推品牌报表
            'startDate'     => $data ['startDate'] ?? '', //	String	否	请求接口当天前移70天日期	查询报表开始日期,格式: yyyy-MM-dd
            'endDate'=> $data ['endDate'] ?? '', //	String	否	请求接口当天日期	查询报表结束日期,格式: yyyy-MM-dd
        ]; 
        $group_name = $data ['group_name'] ?? '';
        return  $this->output( 'get','report/push/task_group/'.  $group_name  , $query,   $body ); 
    }





//-----------------------------------------------------------
// 【推送】获取推送实时结果
//                          获取推送实时结果，可查询消息下发数，接收数、展示数、点击数和消息折损详情等结果。支持单个taskId查询和多个taskId查询。
//                          注意：该接口需要开通权限，如需开通，请联系对应的商务同学开通
//                          接口地址: BaseUrl/report/push/task/${taskid}/detail
// 请求方式: GET
//-----------------------------------------------------------
public function find_report_push_task_task_detail( array $data =   []    ): array|string
    {  
        $body = [    ]; 
        $query = [   ]; 
        $taskid = $data ['taskid'] ?? '';
        return  $this->output( 'get','report/push/task/'. $taskid .'/detail'  , $query,   $body ); 
    }




//-----------------------------------------------------------
// 【推送】获取单日推送数据
//                      调用此接口可以获取某个应用单日的推送数据(推送数据包括：下发数，接收数、展示数、点击数)(目前只支持查询非当天的数据)
//                      接口地址: BaseUrl/report/push/date/$date
// 请求方式: GET
//-----------------------------------------------------------
public function find_report_push_date( array $data =   []    ): array|string
    {  
        $body = [    ]; 
        $query = [   ]; 
        $date = $data ['date'] ?? date('yyyy-MM-dd' ,time() )  ; //日期，格式: yyyy-MM-dd
        return  $this->output( 'get','report/push/date/'. $date , $query,   $body ); 
    }



//-----------------------------------------------------------
// 【推送】查询推送量
//                          查询应用当日可推送量和推送余量
//                          注意：
//                                  1. 部分厂商消息不限制推送量，所以此接口不做返回，例如 hw厂商，op的私信消息，xm的重要级别消息等等
//                                  2.vv返回的是请求量push_num，总限额total_num返回的总的到达量，所以会有请求量push_num超过总限额total_num的情况
//                                  3.该接口做了频控限制，请不要频繁调用
//                          接口地址: BaseUrl/report/push/count
// 请求方式: GET
//-----------------------------------------------------------
public function find_report_push_count( array $data =   []    ): array|string
    {  
        $body = [    ]; 
        $query = [   ];  
        return  $this->output( 'get','report/push/count' , $query,   $body ); 
    }



//-----------------------------------------------------------
// 【用户】获取单日用户数据接口
//                          调用此接口可以获取某个应用单日的用户数据(用户数据包括：新增用户数，累计注册用户总数，在线峰值，日联网用户数)(目前只支持查询非当天的数据)
//                          接口地址: BaseUrl/report/user/date/$date
// 请求方式: GET
//-----------------------------------------------------------
public function find_report_user_date( array $data =   []    ): array|string
    {  
        $body = [    ]; 
        $query = [   ];  
        $date = $data ['date'] ??  date('yyyy-MM-dd' ,time() )  ; //日期，格式: yyyy-MM-dd
        return  $this->output( 'get','report/user/date/'. $date , $query,   $body ); 
    }



//-----------------------------------------------------------
// 【用户】获取24个小时在线用户数
//                              查询当前时间一天内的在线用户数(10分钟一个点，1个小时六个点)
//                              接口地址: BaseUrl/report/online_user
// 请求方式: GET
//-----------------------------------------------------------

public function find_report_online_user( array $data =   []    ): array|string
    {  
        $body = [    ]; 
        $query = [   ];   
        return  $this->output( 'get','report/online_user' , $query,   $body ); 
    }














//-------------------end 
}
