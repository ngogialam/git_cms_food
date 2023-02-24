<?php
namespace App\Filters;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\App;

class GenerateDeviceID implements FilterInterface
{
    public function before(RequestInterface $request , $arguments = null){
		helper("cookie");
		$deviceId = get_cookie('__dvc');
		if(!$deviceId){
			$keyVariable = implode('-', str_split(substr(strtolower(md5(microtime().rand(1000, 9999))), 0, 30), 6));
			setcookie ("__dvc",$keyVariable,time() + ( 365 * 24 * 60 * 60) , '/');
		}
    }
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {}
} 