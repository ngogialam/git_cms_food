<?php
namespace App\Libraries;
/**
 * PHP Redis Custom
 * 
 * Create by QTA
 * Date: 2021-07-06 20:50:00
 */
use Predis\Client;
class Credis
{
    public function get($key)
    {
        $redis = new Client();
        $value = $redis->get($key);
        $redis->disconnect();
        return $value;
    }

    public function set($key, $value, $seconds = null)
    {
        $redis = new Client();
        $result = $redis->set($key, $value);
        if($seconds > 0 && preg_match("/^[0-9]+$/", $seconds)){
            $result = $redis->expire($key, $seconds);
        }
        $redis->disconnect();
        return $result;
    }

    public function lpush($key, array $values)
    {
        $redis = new Client();
        $result = $redis->lpush($key, $values);
        $redis->disconnect();
        return $result;
    }

    public function lpop($key)
    {
        $redis = new Client();
        $result = $redis->lpop($key);
        $redis->disconnect();
        return $result;
    }

    public function rpush($key, array $values)
    {
        $redis = new Client();
        $result = $redis->rpush($key, $values);
        $redis->disconnect();
        return $result;
    }

    public function rpop($key)
    {
        $redis = new Client();
        $result = $redis->rpop($key);
        $redis->disconnect();
        return $result;
    }

    public function del($key)
    {
        $redis = new Client();
        $result = $redis->del($key);
        $redis->disconnect();
        return $result;
    }
}
?>