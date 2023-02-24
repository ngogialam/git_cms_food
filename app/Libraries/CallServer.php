<?php
namespace App\Libraries;
/**
 * PHP Rest CURL
 * 
 * 
 */

Class CallServer {
    public static function exec($method, $url, $obj = array(), $headers = array(), $params = array()) {
        // $newUrl = $url;
        $curl = curl_init();
        switch($method) {
            case 'GET':
                if(strrpos($url, "?") === FALSE) {
                    $url .= '?' . http_build_query($obj);
                }else{
                    $url .= http_build_query($obj);
                }
            break;
            case 'POSTJSONUPDATE':
                if(strrpos($url, "?") === FALSE) {
                    $url .= '?' . http_build_query($params);
                }else{
                    $url .= http_build_query($params);
                }
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($obj));
            break;

            case 'POSTJSON': 
                curl_setopt($curl, CURLOPT_POST, TRUE);
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($obj));
            break;

            case 'POSTFORM': 
                curl_setopt($curl, CURLOPT_POST, TRUE);
                curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($obj));
            break;

            case 'PUT':
                curl_setopt($curl, CURLOPT_POST, TRUE);
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT"); // method
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($obj)); // body

            case 'DELETE':
                curl_setopt($curl, CURLOPT_POST, TRUE);
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE"); // method
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($obj)); // body
            default:
                
        }
        // echo $url;die;
        // $url = $newUrl.'/'.$obj[0];
        if(!empty($headers)){
            $headers = $headers;
        }else{
            $headers = array('Accept: application/json', 'Content-Type: application/json');
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers); 
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, TRUE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, TRUE);
        // Exec
        $response = curl_exec($curl);
        $info = curl_getinfo($curl);
        curl_close($curl);

        // Data
        $header = trim(substr($response, 0, $info['header_size']));
        $body = substr($response, $info['header_size']);

        return array('status' => $info['http_code'], 'header' => $header, 'data' => json_decode($body));
    }

    public static function execByte($method, $url, $obj = array(), $headers = array(), $params = array()) {
        // $newUrl = $url;
        $curl = curl_init();
        switch($method) {
            case 'GET':
                if(strrpos($url, "?") === FALSE) {
                    $url .= '?' . http_build_query($obj);
                }else{
                    $url .= http_build_query($obj);
                }
            break;
            case 'POSTJSONUPDATE':
                if(strrpos($url, "?") === FALSE) {
                    $url .= '?' . http_build_query($params);
                }else{
                    $url .= http_build_query($params);
                }
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($obj));
            break;

            case 'POSTJSON': 
                curl_setopt($curl, CURLOPT_POST, TRUE);
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($obj));
            break;

            case 'POSTFORM': 
                curl_setopt($curl, CURLOPT_POST, TRUE);
                curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($obj));
            break;

            case 'PUT':
                curl_setopt($curl, CURLOPT_POST, TRUE);
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT"); // method
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($obj)); // body

            case 'DELETE':
                curl_setopt($curl, CURLOPT_POST, TRUE);
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE"); // method
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($obj)); // body
            default:
                
        }
        // $url = $newUrl.'/'.$obj[0];
        if(!empty($headers)){
            $headers = $headers;
        }else{
            $headers = array('Accept: application/json', 'Content-Type: application/json');
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers); 
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, TRUE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, TRUE);
        // Exec
        $response = curl_exec($curl);
        $info = curl_getinfo($curl);
        curl_close($curl);

        // Data
        $header = trim(substr($response, 0, $info['header_size']));
        $body = substr($response, $info['header_size']);

        return array('status' => $info['http_code'], 'header' => $header, 'data' => $body);
    }

    public static function Get($url, $obj = array(), $headers = array()) {
        return CallServer::exec("GET", $url, $obj, $headers );
    }

    public static function PostJson($url, $obj = array(), $header = array()) {
        return CallServer::exec("POSTJSON", $url, $obj, $header );
    }

    public static function PostForm($url, $obj = array(), $header = array()) {
        return CallServer::exec("POSTFORM", $url, $obj, $header);
    }

    public static function Put($url, $obj = array(), $header = array()) {
        return CallServer::exec("PUT", $url, $obj, $header);
    }

    public static function Delete($url, $obj = array(), $header = array()) {
        return CallServer::exec("DELETE", $url, $obj, $header);
    }
    
    public static function PostJsonUpdate($url, $obj = array(), $header = array(), $params = array()) {
        return CallServer::exec("POSTJSONUPDATE", $url, $obj, $header,$params);
    }

    public static function PostUploadImage($url= '', $params = array(), $fileName = 'test', $token) {
        $curl = curl_init();
        // echo '<pre>';
        // print_r($url);
        // print_r($params);
        // print_r($fileName);
        // print_r($token);die;
        $token = 'eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOiIwOTEyMzQ1Njc4IiwiZXhwIjoxNjQwNDM1MzIyLCJkZXZpY2UtaWQiOiJkZXZpY2UxMjM5OSIsImlhdCI6MTY0MDQxNzMyMn0.tfN59uyqOtf3GZW_1XVs2i2vdcYh0-6k_90bOaTTQmX2dgfCbVyDfcn7GnchJhn6IasAZBR349XXXrhqIgrxCg';

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            // CURLOPT_POSTFIELDS => array('file' => new \CURLFILE($params['file'],'application/octet-stream',$fileName), 'username' =>  $params['username'], 'file_type' => $params['file_type']),
            CURLOPT_POSTFIELDS => array('file' => new \CURLFILE($params['file'], $params['type'], $fileName), 'username' =>  $params['username'], 'file_type' => $params['file_type']),
            // CURLOPT_HTTPHEADER => array(
            //     'Authorization: Bearer eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOiIwOTEyMzQ1Njc4IiwiZXhwIjoxNjQwNDM1MzIyLCJkZXZpY2UtaWQiOiJkZXZpY2UxMjM5OSIsImlhdCI6MTY0MDQxNzMyMn0.tfN59uyqOtf3GZW_1XVs2i2vdcYh0-6k_90bOaTTQmX2dgfCbVyDfcn7GnchJhn6IasAZBR349XXXrhqIgrxCg'
            // ),
        ));
        $response = curl_exec($curl);
        $info = curl_getinfo($curl);
        curl_close($curl);
        // Data
        return array('status' => $info['http_code'], 'data' => json_decode($response));
    }
    
    public static function GetByte($url, $obj = array(), $headers = array()) {
        return CallServer::execByte("GET", $url, $obj, $headers );
    }
    
}