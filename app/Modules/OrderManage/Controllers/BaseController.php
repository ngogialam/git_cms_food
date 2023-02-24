<?php
namespace App\Modules\OrderManage\Controllers;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 *
 * @package CodeIgniter
 */

use CodeIgniter\Controller;
use App\Libraries\CallServer; 
use App\Libraries\Credis;
use App\Libraries\Clogger;
use App\Libraries\AuthenticatorUser;
use App\Libraries\PermissionUser;
use App\Modules\Users\Models\UsersModels as UsersModels;
use App\Modules\News\Models\NewsModels as NewsModels;
use App\Modules\Products\Models\ProductsModels as ProductsModels;
use App\Modules\OrderManage\Models\OrderManageModels as OrderManageModels;
use App\Libraries\ConvertString;

class BaseController extends Controller

{
	
	/**
	 * An array of helpers to be loaded automatically upon
	 * class instantiation. These helpers will be available
	 * to all other controllers that extend BaseController.
	 *
	 * @var array
	 */
	protected $helpers = [];

	/**
	 * Constructor.
	 */
	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
	{
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);

		//--------------------------------------------------------------------
		// Preload any models, libraries, etc, here.
		//--------------------------------------------------------------------
		// E.g.:
		helper("cookie");

		$this->validation 				=  \Config\Services::validation();
		$this->callServer    			= new CallServer();
		$this->clog = new Clogger(\Config\Services::request());
		$this->authenticatorUser = new AuthenticatorUser();
		$this->authenticatorUser->redirectPage();
		$this->permissionUser = new PermissionUser($logger);
		//--------------------------------------------------------------------

		$this->redis = new Credis();

		$this->dataUserAuthen = $this->authenticatorUser->getAuthenticator();
		$this->usersModels = new UsersModels($logger);
		$this->newsModels = new NewsModels($logger);
		$this->productModels = new ProductsModels($logger);
		$this->orderManageModels = new OrderManageModels($logger);
		$this->convertString = new ConvertString();
		// E.g.:
		$role = $this->dataUserAuthen->role;
		$arrRole = explode('_', $role);
		if ($role == 'FOOD_SALER' && in_array('SALER', $arrRole) && in_array('FOOD', $arrRole)) {
				header("Location: ".base_url('/trang-trai/in-tem-san-pham-moi'));
				die;
		}
		//Pagination
		$this->pager 					= \Config\Services::pager();
		$this->uri = explode('/', uri_string());
		$this->segment = $this->uri['1'];
		$this->page = $this->uri['2'];
		$this->arrStatus = [
			'100' => 'Đang chuẩn bị hàng',
			'1002' => 'Chờ xác nhận đơn hàng',
			'1003' => 'Đã xác nhận đơn hàng',
			'101' => 'Đã chuẩn bị xong hàng',
			'200' => 'Đã chuyển đơn vị giao hàng',
			'501' => 'Giao hàng thành công',
			'511' => 'Giao hàng thất bại',
			'924' => 'Đơn đã hủy bởi người nhận',
			'902' => 'Đơn đã hủy bởi quản trị viên',
			'107' => 'Đơn đã hủy bởi đơn vị vận chuyển',
		];
		if(isset($get['page'])){
			$this->page = $get['page'];
		}
		
	}
}