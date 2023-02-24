<?php
namespace App\Libraries;
/**
 * PHP Custom Logger 
 * Write to Redis
 * Create by QTA
 * Date: 2021-07-06 20:50:00
 */
use App\Libraries\Credis;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;

class Clogger
{
    /**
     * Instance of the main Request object.
     *
     * @var IncomingRequest|CLIRequest
     */
    protected $request;

    /**
     * Constructor.
     *
     * @param RequestInterface  $request
     * @param LoggerInterface   $logger
     *
     */
    function __construct(RequestInterface $request)
    {
        $this->request  = $request;
    }

    public function info($module, $action, $messages)
    {

        $this->redis    = new Credis();
        $prefix = date("Y-m-d H:i:s");
        $prefix .= ' '.$this->request->getServer('HTTP_X_FORWARDED_FOR');
        if (is_array($messages)) {
            $messages = json_encode($messages, JSON_UNESCAPED_UNICODE);
        }
        $value['0'] = Array(
            'Date'      => date("Y-m-d"),
            'Module'    => $module,
            'Action'    => $action,
            'Message'   => $prefix.' | '.$messages
        );
        $val[] = json_encode($value, JSON_UNESCAPED_UNICODE);
        $this->redis->rpush('flog', $val);
    }
}
?>