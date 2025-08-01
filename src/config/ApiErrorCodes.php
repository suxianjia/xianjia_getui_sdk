
<?php
return [
    'http_codes' => [
        200 => ['description' => '成功', 'solution' => '查看基础返回码'],
        400 => ['description' => '参数错误', 'solution' => '具体异常信息请参考业务返回码'],
        401 => ['description' => '权限相关', 'solution' => '具体异常信息请参考业务返回码'],
        403 => ['description' => '套餐相关', 'solution' => '具体异常信息请参考业务返回码'],
        404 => ['description' => 'url错误', 'solution' => '请检查Http路径是否正确'],
        405 => ['description' => '方法不支持', 'solution' => '该接口不支持该方法请求，请查看文档确认请求方式']
    ],
    'basic_codes' => [
        0 => ['description' => '成功', 'solution' => '-', 'http_code' => 200],
        1 => ['description' => '失败', 'solution' => '接口入参要求是json格式', 'http_code' => 200],
        2 => ['description' => '服务正在启动', 'solution' => '请等待', 'http_code' => 200],
        301 => ['description' => '域名错误', 'solution' => '检查域名是否与appid机房匹配', 'http_code' => 200],
        404 => ['description' => 'url错误', 'solution' => '请检查Http路径是否正确', 'http_code' => 404],
        405 => ['description' => '方法不支持', 'solution' => '查看文档确认请求方式', 'http_code' => 405]
    ],
    'permission_codes' => [
        10001 => ['description' => 'token错误/失效', 'solution' => '重新获取token', 'http_code' => 401],
        10002 => ['description' => 'appId或ip在黑名单中', 'solution' => '', 'http_code' => 401],
        10003 => ['description' => '每分钟鉴权频率超限', 'solution' => '接口调用过于频繁', 'http_code' => 401],
        10004 => ['description' => '没有查询消息明细权限', 'solution' => '申请权限', 'http_code' => 401],
        10005 => ['description' => '每分钟调用频率超限', 'solution' => '', 'http_code' => 401]
    ],
    'param_codes' => [
        20001 => [
            'patterns' => [
                '{param} is invalid' => '参数不合法',
                '{param} can not be empty' => '参数不能为空',
                '{param} type error' => '参数类型错误'
            ],
            'http_code' => 400
        ]
    ],
    'package_codes' => [
        30000 => ['description' => '没有推送fast_custom_tag权限', 'http_code' => 403],
        30001 => ['description' => '没有修改和删除custom_tag权限', 'http_code' => 403]
    ],
    'network_codes' => [
        5000 => ['description' => '内部服务器错误', 'solution' => '检查本地网络配置，检查下本地网络情况，是否设置代理、白名单、防火墙等']
    ]
];
