<?php 
namespace Suxianjia\xianjia_getui_sdk\Core;
 
use \Exception;
use \InvalidArgumentException;
use \RuntimeException;
class HttpClient {

//-----------------------------------------------------------
//              output
//-----------------------------------------------------------    
    private   function output ($decoded = [],$httpCode = 500 ): array|string {



        //  if ($httpCode >= 400) {
        //     $msg = $decoded['msg'] ?? 'Unknown error';
        //     // error_log("[HttpClient] API Error: HTTP $httpCode, Msg: $msg");
        //     // throw match ($httpCode) {
        //     //     400 => new InvalidArgumentException("参数错误: $msg"),
        //     //     401 => new RuntimeException("认证失效: $msg"),
        //     //     403 => new RuntimeException("认证失效: $msg"),
        //     //     default => new Exception("API Error [$httpCode]: $msg")
        //     // };
        // }

            $network_status = $httpCode  ;
        $code =  $decoded['code']  ;
        $data = $decoded['data'] ??  [];
        $msg = $decoded['msg'] ?? 'Failed';
      return ['code' => $code, 'network_status' => $network_status, 'msg' => $msg, 'data' => $data];
        // return $res; // 输出 UTF 8 编码的 JSON 字符串
        // 可选：将结果编码为UTF-8 JSON字符串返回
        // return json_encode($res, JSON_UNESCAPED_UNICODE);

    }

    //-----------------------------------------------------------
//              post
//  curl https://ido.getui.com/openapi/M9vbNu1awUARfJa0AqTvN8/auth -X POST -H "Content-Type: application/json;charset=utf-8" -d '{"sign": "273df9d1128b7bc463173bab08c44cd5b91c61961bf1756da08c81dad60ee71c","timestamp": "1752821563000","appkey": "91LnMVq9Uk7WYzaaIsgNH2"}'
//  curl $BaseUrl/push/single/cid -X POST -H "Content-Type: application/json;charset=utf-8" -H "token: $token" -d '{ }'
//-----------------------------------------------------------
public function post(string $uri, array $query = [], array $body = [], array $header = []): array|string {
    $ch = curl_init(); 
    $header_default = [
        'Content-Type: application/json;charset=utf-8',
        'Accept: application/json'
    ]; 
    $headers = array_merge( $header_default, $header); 
          // 构建带查询参数的URL
        $fullUri = $uri;
        if (!empty($query)) {
            $fullUri .= '?' . http_build_query($query);
        }
// var_dump(json_encode($data) );

        // 实现签名生成和请求发送
    curl_setopt_array($ch, [
        CURLOPT_URL => $fullUri, 
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($body), 
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_SSL_VERIFYPEER => true,
        CURLOPT_SSL_VERIFYHOST => 2
    ]); 
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    if ($response === false) {
        $error = curl_error($ch);
        curl_close($ch);
        throw new Exception("CURL Error: $error");
    } 
    curl_close($ch); 
    $decoded = json_decode($response, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception("Invalid JSON: $response");
    }
       
        return $this->output($decoded, $httpCode);
    }
//-----------------------------------------------------------
//                  $client->get
//-----------------------------------------------------------
    public function get(string $uri, array $query = [],    array $header = []): array|string 
    {
        // 实现签名生成和请求发送
        $ch = curl_init(); 
        $header_default = [
            'Content-Type: application/json;charset=utf-8',
            'Accept: application/json'
        ]; 
        $headers = array_merge( $header_default, $header); 

        // 构建带查询参数的URL
        // echo "URL".$uri;
        $fullUri = $uri;
        if (!empty($query)) {
            $fullUri .= '?' . http_build_query($query);
        }
//  var_dump($fullUri);

        // 实现签名生成和请求发送
        curl_setopt_array($ch, [
            CURLOPT_URL => $fullUri,
                        // CURLOPT_URL => $uri,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPGET => true, // 使用GET方法
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_SSL_VERIFYHOST => 2
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $decoded = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception("Invalid JSON: $response");
        }

      
       return  $this->output( $decoded, $httpCode);
    }
//-----------------------------------------------------------
//          delete
//-----------------------------------------------------------
    public function delete(string $uri, array $query = [],   array $body = [],     array $header = []): array|string {
        // 实现签名生成和请求发送
        $ch = curl_init(); 
        $header_default = [
            'Content-Type: application/json;charset=utf-8',
            'Accept: application/json'
        ]; 
        $headers = array_merge($header_default, $header); 

        // 构建带查询参数的URL
        $fullUri = $uri;
        if (!empty($query)) {
            $fullUri .= '?' . http_build_query($query);
        }

        // 实现签名生成和请求发送
        curl_setopt_array($ch, [
            CURLOPT_URL => $fullUri,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "DELETE", // 使用DELETE方法
            CURLOPT_POSTFIELDS => !empty($body) ? json_encode($body) : '',
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_SSL_VERIFYHOST => 2
        ]);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        if ($response === false) {
            $error = curl_error($ch);
            curl_close($ch);
            throw new Exception("CURL Error: $error");
        } 
        curl_close($ch); 
        
        $decoded = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception("Invalid JSON: $response");
        } 
        
    
        
        return $this->output($decoded, $httpCode);
    }  
    
    
//-----------------------------------------------------------
//          put
//-----------------------------------------------------------
    public function put(string $uri,   array $query = [], array $body = [], array $header = []): array|string {
        // 实现签名生成和请求发送
        $ch = curl_init(); 
        $header_default = [
            'Content-Type: application/json;charset=utf-8',
            'Accept: application/json'
        ]; 
        $headers = array_merge($header_default, $header);   
// var_dump( json_encode($data) ) ;
                // 构建带查询参数的URL
        $fullUri = $uri;
        if (!empty($query)) {
            $fullUri .= '?' . http_build_query($query);
        }
    //   var_dump(  $fullUri ) ;
        curl_setopt_array($ch, [
            CURLOPT_URL => $fullUri,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "PUT", // 使用PUT方法
            CURLOPT_POSTFIELDS => !empty($body) ? json_encode($body) : '',
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_SSL_VERIFYHOST => 2
        ]);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        if ($response === false) {
            $error = curl_error($ch);
            curl_close($ch);
            throw new Exception("CURL Error: $error");
        }   


        curl_close($ch);

        $decoded = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception("Invalid JSON: $response");
        }

 
        return $this->output($decoded, $httpCode);
        }


}
