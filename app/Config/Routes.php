<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes(true);

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */

// $routes->setDefaultNamespace('App\Modules\Frontend\Controllers');
// $routes->setDefaultController('OrderManage');
// $routes->setDefaultMethod('home');
// $routes->setTranslateURIDashes(false);
// $routes->set404Override();
// $routes->setAutoRoute(true);

$routes->setDefaultNamespace('App\Modules\Products\Controllers');
$routes->setDefaultController('Products');
$routes->setDefaultMethod('listProduct');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

// $routes->add('/', 'Products::listProduct',['namespace' => 'App\Modules\Products\Controllers']);
$routes->add('/', 'Authenticator::login', ['namespace' => 'App\Modules\Authenticator\Controllers']);
$routes->add('/dang-xuat', 'Authenticator::logout', ['namespace' => 'App\Modules\Authenticator\Controllers']);
//Quản lý đơn hàng
$routes->add('/don-hang/danh-sach-don-hang', 'OrderManage::listOrders', ['namespace' => 'App\Modules\OrderManage\Controllers']);
$routes->add('/don-hang/danh-sach-don-hang/(:num)', 'OrderManage::listOrders/$1', ['namespace' => 'App\Modules\OrderManage\Controllers']);
$routes->add('/don-hang/danh-sach-don-hang/(:segment)', 'OrderManage::listOrders/$1', ['namespace' => 'App\Modules\OrderManage\Controllers']);
$routes->add('/don-hang/danh-sach-don-hang/(:segment)/(:num)', 'OrderManage::listOrders/$1/$2', ['namespace' => 'App\Modules\OrderManage\Controllers']);
$routes->add('/don-hang/chi-tiet-don-hang/(:num)', 'OrderManage::detailOrders/$1', ['namespace' => 'App\Modules\OrderManage\Controllers']);
$routes->add('/don-hang/changeStatus', 'OrderManage::changeStatus', ['namespace' => 'App\Modules\OrderManage\Controllers']);
$routes->add('/don-hang/confirmNetWeight', 'OrderManage::confirmNetWeight', ['namespace' => 'App\Modules\OrderManage\Controllers']);
$routes->add('/don-hang/cancelOrder', 'OrderManage::cancelOrder', ['namespace' => 'App\Modules\OrderManage\Controllers']);
$routes->add('/don-hang/chuan-bi-don-hang', 'OrderManage::prepareOrder', ['namespace' => 'App\Modules\OrderManage\Controllers']);
$routes->add('/don-hang/prepareOrderWeight', 'OrderManage::prepareOrderWeightAjax', ['namespace' => 'App\Modules\OrderManage\Controllers']);
$routes->add('/don-hang/wrapperOrderQR', 'OrderManage::wrapperOrderQR', ['namespace' => 'App\Modules\OrderManage\Controllers']);
$routes->add('/don-hang/printExportOrder', 'OrderManage::printExportOrder', ['namespace' => 'App\Modules\OrderManage\Controllers']);
$routes->add('/don-hang/searchProduct', 'OrderManage::searchProduct', ['namespace' => 'App\Modules\OrderManage\Controllers']);
$routes->add('/don-hang/getWeightProduct', 'OrderManage::getWeightProduct', ['namespace' => 'App\Modules\OrderManage\Controllers']);
$routes->add('/don-hang/confirmOrder', 'OrderManage::confirmOrder', ['namespace' => 'App\Modules\OrderManage\Controllers']);
$routes->add('/don-hang/addNewProductToOrder', 'OrderManage::addNewProductToOrder', ['namespace' => 'App\Modules\OrderManage\Controllers']);
$routes->add('/don-hang/updateOrder', 'OrderManage::updateOrder', ['namespace' => 'App\Modules\OrderManage\Controllers']);
$routes->add('/don-hang/getPromotion', 'OrderManage::getPromotion', ['namespace' => 'App\Modules\OrderManage\Controllers']);
$routes->add('/ajaxGetDistrictByProvince', 'OrderManage::ajaxGetDistrictByProvince', ['namespace' => 'App\Modules\OrderManage\Controllers']);
$routes->add('/ajaxGetWardsByDistrict', 'OrderManage::ajaxGetWardsByDistrict', ['namespace' => 'App\Modules\OrderManage\Controllers']);
$routes->add('/changeInfoReceiver', 'OrderManage::changeInfoReceiver', ['namespace' => 'App\Modules\OrderManage\Controllers']);
$routes->add('/changeMethodInfo', 'OrderManage::changeMethodInfo', ['namespace' => 'App\Modules\OrderManage\Controllers']);
$routes->add('/getNewPrice', 'OrderManage::getNewPrice', ['namespace' => 'App\Modules\OrderManage\Controllers']);
$routes->add('/printExportOrderWarehouse', 'OrderManage::printExportOrderWarehouse', ['namespace' => 'App\Modules\OrderManage\Controllers']);
$routes->add('/don-hang/exportExcelOrder', 'OrderManage::exportExcelOrder', ['namespace' => 'App\Modules\OrderManage\Controllers']);
$routes->add('/don-hang/exportExcelOrderGet', 'OrderManage::exportExcelOrderGet', ['namespace' => 'App\Modules\OrderManage\Controllers']);
$routes->add('/don-hang/deleteItemInOrder', 'OrderManage::deleteItemInOrder', ['namespace' => 'App\Modules\OrderManage\Controllers']);

//Danh sách quản lý người dùng
$routes->add('/user/danh-sach-nguoi-dung', 'Users::listUsers', ['namespace' => 'App\Modules\Users\Controllers']);
$routes->add('/user/danh-sach-nguoi-dung/(:num)', 'Users::listUsers/$1', ['namespace' => 'App\Modules\Users\Controllers']);
$routes->add('/user/danh-sach-nguoi-dung/(:segment)', 'Users::listUsers/$1', ['namespace' => 'App\Modules\Users\Controllers']);
$routes->add('/user/danh-sach-nguoi-dung/(:segment)/(:num)', 'Users::listUsers/$1/$2', ['namespace' => 'App\Modules\Users\Controllers']);
$routes->add('/user/xoa-nguoi-dung/(:num)', 'Users::deleteUser/$1', ['namespace' => 'App\Modules\Users\Controllers']);
$routes->add('/user/sua-nguoi-dung/(:num)', 'Users::editUser/$1', ['namespace' => 'App\Modules\Users\Controllers']);
// $routes->add('/cai-lai-mat-khau/(:num)','Users::resetPassword/$1',['namespace' => 'App\Modules\Users\Controllers']);
$routes->add('/dat-lai-mat-khau/(:num)/(:num)', 'Users::resetPassword/$1/$2', ['namespace' => 'App\Modules\Users\Controllers']);
$routes->add('/user/doi-mat-khau', 'Users::changePassword', ['namespace' => 'App\Modules\Users\Controllers']);

$routes->add('/user/tao-nguoi-dung', 'Users::addUsers', ['namespace' => 'App\Modules\Users\Controllers']);
$routes->add('/user/tao-nhom-nguoi-dung', 'Users::addGroup', ['namespace' => 'App\Modules\Users\Controllers']);
$routes->add('/checkExistPhone', 'Users::checkExistPhone', ['namespace' => 'App\Modules\Users\Controllers']);

//Quản lý sản phẩm
$routes->add('/san-pham/danh-sach-san-pham', 'Products::listProduct', ['namespace' => 'App\Modules\Products\Controllers']);
$routes->add('/san-pham/danh-sach-san-pham/(:num)', 'Products::listProduct/$1', ['namespace' => 'App\Modules\Products\Controllers']);
$routes->add('/san-pham/tao-san-pham', 'Products::addProduct', ['namespace' => 'App\Modules\Products\Controllers']);
$routes->add('/san-pham/sua-san-pham/(:num)', 'Products::editProduct/$1', ['namespace' => 'App\Modules\Products\Controllers']);
$routes->add('/san-pham/xoa-san-pham', 'Products::removeProduct', ['namespace' => 'App\Modules\Products\Controllers']);
$routes->add('/appendPackProduct', 'Products::appendPackProduct', ['namespace' => 'App\Modules\Products\Controllers']);
$routes->add('/uploadImgs', 'Products::uploadImgs', ['namespace' => 'App\Modules\Products\Controllers']);
$routes->add('/uploadImgsCK', 'Products::uploadImgsCK', ['namespace' => 'App\Modules\Products\Controllers']);
$routes->add('/checkExistProductName', 'Products::checkExistProductName', ['namespace' => 'App\Modules\Products\Controllers']);
$routes->add('/activeProduct', 'Products::activeProduct', ['namespace' => 'App\Modules\Products\Controllers']);
$routes->add('/exportExcelItemsScale', 'Products::exportExcelItemsScale', ['namespace' => 'App\Modules\Products\Controllers']);
$routes->add('/addProductToOrder', 'Products::addProductToOrder', ['namespace' => 'App\Modules\Products\Controllers']);
$routes->add('/removeMultiProducts', 'Products::removeMultiProducts', ['namespace' => 'App\Modules\Products\Controllers']);

//Quản lý set sản phẩm
$routes->add('/set-san-pham/danh-sach-set-san-pham', 'SetProducts::listSetProduct', ['namespace' => 'App\Modules\SetProducts\Controllers']);
$routes->add('/set-san-pham/danh-sach-set-san-pham/(:segment)', 'SetProducts::listSetProduct/$1', ['namespace' => 'App\Modules\SetProducts\Controllers']);
$routes->add('/removeMultiSet', 'SetProducts::removeMultiSet', ['namespace' => 'App\Modules\SetProducts\Controllers']);


$routes->add('/addSetProduct', 'SetProducts::addSetProduct', ['namespace' => 'App\Modules\SetProducts\Controllers']);
$routes->add('/set-san-pham/tao-set-san-pham', 'SetProducts::createSet', ['namespace' => 'App\Modules\SetProducts\Controllers']);
$routes->add('/set-san-pham/sua-set-san-pham/(:num)', 'SetProducts::editSet/$1', ['namespace' => 'App\Modules\SetProducts\Controllers']);

$routes->add('/set-san-pham/lay-quy-cach-set', 'SetProducts::getProductPrice', ['namespace' => 'App\Modules\SetProducts\Controllers']);
$routes->add('/set-san-pham/them-set-san-pham', 'SetProducts::addProductPrice', ['namespace' => 'App\Modules\SetProducts\Controllers']);
$routes->add('/addProductToSet', 'SetProducts::addProductToSet', ['namespace' => 'App\Modules\SetProducts\Controllers']);
$routes->add('/removeMultiSet', 'SetProducts::removeMultiSet', ['namespace' => 'App\Modules\SetProducts\Controllers']);

//Quản lý tin tức
$routes->add('/tin-tuc/danh-sach-tin-tuc', 'News::listNews', ['namespace' => 'App\Modules\News\Controllers']);
$routes->add('/tin-tuc/danh-sach-tin-tuc/(:num)', 'News::listNews/$1', ['namespace' => 'App\Modules\News\Controllers']);
$routes->add('/tin-tuc/them-tin-tuc', 'News::createNews', ['namespace' => 'App\Modules\News\Controllers']);
$routes->add('/tin-tuc/xoa-tin-tuc', 'News::removeNews', ['namespace' => 'App\Modules\News\Controllers']);
$routes->add('/tin-tuc/sua-tin-tuc/(:num)', 'News::editNews/$1', ['namespace' => 'App\Modules\News\Controllers']);
$routes->add('/checkExistNewsTitle', 'News::checkExistNewsTitle', ['namespace' => 'App\Modules\News\Controllers']);

//Quản lý danh mục
$routes->add('/danh-muc/tao-danh-muc', 'Category::addCategory', ['namespace' => 'App\Modules\Category\Controllers']);
$routes->add('/danh-muc/danh-sach-danh-muc', 'Category::listCategory', ['namespace' => 'App\Modules\Category\Controllers']);
$routes->add('/danh-muc/sua-danh-muc', 'Category::editCategory', ['namespace' => 'App\Modules\Category\Controllers']);
$routes->add('/danh-muc/xoa-danh-muc', 'Category::deleteCategory', ['namespace' => 'App\Modules\Category\Controllers']);
$routes->add('/checkExistCate', 'Category::checkExistCate', ['namespace' => 'App\Modules\Category\Controllers']);

//Quản lý methods
$routes->add('/phuong-thuc/tao-phuong-thuc', 'Methods::addMethods', ['namespace' => 'App\Modules\Methods\Controllers']);
$routes->add('/phuong-thuc/danh-sach-phuong-thuc', 'Methods::listMethods', ['namespace' => 'App\Modules\Methods\Controllers']);
$routes->add('/phuong-thuc/danh-sach-phuong-thuc/(:num)', 'Methods::listMethods/$1', ['namespace' => 'App\Modules\Methods\Controllers']);
$routes->add('/phuong-thuc/sua-phuong-thuc', 'Methods::editMethods', ['namespace' => 'App\Modules\Methods\Controllers']);
$routes->add('/phuong-thuc/xoa-phuong-thuc', 'Methods::deleteMethods', ['namespace' => 'App\Modules\Methods\Controllers']);
$routes->add('/checkExistMethod', 'Methods::checkExistMethod', ['namespace' => 'App\Modules\Methods\Controllers']);

//Quản lý Menus
$routes->add('/menus/tao-menus', 'Menus::addMenus', ['namespace' => 'App\Modules\Menus\Controllers']);
$routes->add('/menus/danh-sach-menus', 'Menus::listMenus', ['namespace' => 'App\Modules\Menus\Controllers']);
$routes->add('/menus/sua-menus', 'Menus::editMenus', ['namespace' => 'App\Modules\Menus\Controllers']);
$routes->add('/menus/xoa-menus', 'Menus::deleteMenus', ['namespace' => 'App\Modules\Menus\Controllers']);
$routes->add('/checkExistMenu', 'Menus::checkExistMenu', ['namespace' => 'App\Modules\Menus\Controllers']);

//Quản lý Banners
$routes->add('/banners/tao-banners', 'Banners::addBanners', ['namespace' => 'App\Modules\Banners\Controllers']);
$routes->add('/banners/danh-sach-banners', 'Banners::listBanners', ['namespace' => 'App\Modules\Banners\Controllers']);
$routes->add('/banners/sua-banners', 'Banners::editBanners', ['namespace' => 'App\Modules\Banners\Controllers']);
$routes->add('/banners/xoa-banners', 'Banners::deleteBanners', ['namespace' => 'App\Modules\Banners\Controllers']);
$routes->add('/checkExistBanner', 'Banners::checkExistBanner', ['namespace' => 'App\Modules\Banners\Controllers']);

//Quản lý Promotion
$routes->add('/khuyen-mai/tao-khuyen-mai', 'Promotion::addPromotion', ['namespace' => 'App\Modules\Promotion\Controllers']);
$routes->add('/khuyen-mai/danh-sach-khuyen-mai-san-pham-tang-kem', 'Promotion::listPromotion', ['namespace' => 'App\Modules\Promotion\Controllers']);
$routes->add('/khuyen-mai/danh-sach-khuyen-mai-don-hang', 'Promotion::listPromotionOrder', ['namespace' => 'App\Modules\Promotion\Controllers']);
$routes->add('/khuyen-mai/sua-khuyen-mai', 'Promotion::editPromotion', ['namespace' => 'App\Modules\Promotion\Controllers']);
$routes->add('/khuyen-mai/xoa-khuyen-mai', 'Promotion::deletePromotion', ['namespace' => 'App\Modules\Promotion\Controllers']);
$routes->add('/khuyen-mai/lay-quy-cach', 'Promotion::getProductPrice', ['namespace' => 'App\Modules\Promotion\Controllers']);
$routes->add('/khuyen-mai/them-san-pham-tang-kem', 'Promotion::addProductPrice', ['namespace' => 'App\Modules\Promotion\Controllers']);
$routes->add('/khuyen-mai/tao-khuyen-mai-don-hang', 'Promotion::addPromotionOrder', ['namespace' => 'App\Modules\Promotion\Controllers']);
$routes->add('/khuyen-mai/lay-thong-tin-khuyen-mai', 'Promotion::getPromotionOrder', ['namespace' => 'App\Modules\Promotion\Controllers']);
$routes->add('/checkExistPromotion', 'Promotion::checkExistPromotion', ['namespace' => 'App\Modules\Promotion\Controllers']);
$routes->add('/addSetProductPromotion', 'Promotion::addSetProductPromotion', ['namespace' => 'App\Modules\Promotion\Controllers']);
$routes->add('/khuyen-mai/them-san-pham-set-tang-kem', 'Promotion::addProductSetPrice', ['namespace' => 'App\Modules\Promotion\Controllers']);
$routes->add('/khuyen-mai/tao-set-khuyen-mai', 'Promotion::addSetPromotion', ['namespace' => 'App\Modules\Promotion\Controllers']);

//Quản lý Đánh giá
$routes->add('/danh-gia/tao-danh-gia', 'Reviews::addReviews', ['namespace' => 'App\Modules\Reviews\Controllers']);
$routes->add('/danh-gia/danh-sach-danh-gia', 'Reviews::listReviews', ['namespace' => 'App\Modules\Reviews\Controllers']);
$routes->add('/danh-gia/danh-sach-danh-gia/(:segment)', 'Reviews::listReviews/$1', ['namespace' => 'App\Modules\Reviews\Controllers']);
$routes->add('/danh-gia/sua-danh-gia', 'Reviews::editReviews', ['namespace' => 'App\Modules\Reviews\Controllers']);
$routes->add('/danh-gia/xoa-danh-gia', 'Reviews::deleteReviews', ['namespace' => 'App\Modules\Reviews\Controllers']);


//Quản lý trang trại
$routes->add('/trang-trai/in-tem-san-pham', 'Barcode::printProduct', ['namespace' => 'App\Modules\FRM_Barcode\Controllers']);
$routes->add('/trang-trai/previewPrint/(:num)', 'Barcode::previewPrint/$1', ['namespace' => 'App\Modules\FRM_Barcode\Controllers']);
$routes->add('/generateQRCode', 'Barcode::generateQRCode', ['namespace' => 'App\Modules\FRM_Barcode\Controllers']);
$routes->add('/trang-trai/in-tem-san-pham-moi', 'Barcode::printProductNew', ['namespace' => 'App\Modules\FRM_Barcode\Controllers']);
$routes->add('/trang-trai/previewPrintProduct', 'Barcode::previewPrintProduct', ['namespace' => 'App\Modules\FRM_Barcode\Controllers']);
$routes->add('/getDetailProduct', 'Barcode::getDetailProduct', ['namespace' => 'App\Modules\FRM_Barcode\Controllers']);

$routes->add('/trang-trai/in-tem-mau-moi', 'Barcode::printBarcodeNew', ['namespace' => 'App\Modules\FRM_Barcode\Controllers']);
$routes->add('/trang-trai/previewPrintBarCodeNew', 'Barcode::previewPrintBarCodeNew', ['namespace' => 'App\Modules\FRM_Barcode\Controllers']);


//Quản lý biểu mẫu zalo 
$routes->add('/quan-ly-zalo', 'ZaloController::listTempl', ['namespace' => 'App\Modules\Zalo\Controllers']);
$routes->add('/activeTemplZalo', 'ZaloController::activeTempl', ['namespace' => 'App\Modules\Zalo\Controllers']);
$routes->add('/exportExcelZalo', 'ZaloController::exportExcelZalo', ['namespace' => 'App\Modules\Zalo\Controllers']);

//Quản lý món ăn
$routes->add('/mon-an/danh-sach-mon-an', 'Menus::listDish', ['namespace' => 'App\Modules\MenusFood\Controllers']);
$routes->add('/mon-an/danh-sach-mon-an/(:num)', 'Menus::listDish/$1', ['namespace' => 'App\Modules\MenusFood\Controllers']);
$routes->add('/mon-an/them-moi-mon-an', 'Menus::addMenusFood', ['namespace' => 'App\Modules\MenusFood\Controllers']);
$routes->add('/mon-an/callApiAddNewDish', 'Menus::addNewDish', ['namespace' => 'App\Modules\MenusFood\Controllers']);
$routes->add('/mon-an/danh-sach-don-hang-food', 'OrderDish::listOrderMenuFood', ['namespace' => 'App\Modules\MenusFood\Controllers']);
$routes->add('/mon-an/danh-sach-don-hang-food/(:num)', 'OrderDish::listOrderMenuFood/$1', ['namespace' => 'App\Modules\MenusFood\Controllers']);
$routes->add('/mon-an/checkTimeOpening', 'Menus::checkTimeOpening', ['namespace' => 'App\Modules\MenusFood\Controllers']);
$routes->add('/mon-an/changeTimeSale', 'Menus::changeTimeSale', ['namespace' => 'App\Modules\MenusFood\Controllers']);
$routes->add('/changeStatusDishOrder', 'OrderDish::changeStatusDishOrder', ['namespace' => 'App\Modules\MenusFood\Controllers']);
$routes->add('/changeStatusDish', 'Menus::changeStatusDish', ['namespace' => 'App\Modules\MenusFood\Controllers']);
$routes->add('/getDetailDish', 'Menus::getDetailDish', ['namespace' => 'App\Modules\MenusFood\Controllers']);
$routes->add('/editDish', 'Menus::editDish', ['namespace' => 'App\Modules\MenusFood\Controllers']);
$routes->add('/exportExcelListOrders', 'OrderDish::exportExcelListOrders', ['namespace' => 'App\Modules\MenusFood\Controllers']);
$routes->add('/changeStockDish', 'Menus::changeStockDish', ['namespace' => 'App\Modules\MenusFood\Controllers']);
$routes->add('/mon-an/tong-hop-don-dat-hang', 'OrderDish::listStatistic', ['namespace' => 'App\Modules\MenusFood\Controllers']);
// Danh sách tài khoản đối tác 
$routes->add('/mon-an/danh-sach-tai-khoan-doi-tac', 'OrderDish::listAccount', ['namespace' => 'App\Modules\MenusFood\Controllers']);
$routes->add('/mon-an/danh-sach-tai-khoan-doi-tac/(:num)', 'OrderDish::listAccount/$1', ['namespace' => 'App\Modules\MenusFood\Controllers']);
$routes->add('/mon-an/danh-sach-tai-khoan-doi-tac', 'OrderDish::addAccount', ['namespace' => 'App\Modules\MenusFood\Controllers']);
$routes->add('/callAddAccount', 'OrderDish::addAccount', ['namespace' => 'App\Modules\MenusFood\Controllers']);
$routes->add('/deletePartner', 'OrderDish::deletePartner', ['namespace' => 'App\Modules\MenusFood\Controllers']);
$routes->add('/getAutoComplete', 'OrderDish::checkPhone', ['namespace' => 'App\Modules\MenusFood\Controllers']);
$routes->add('/editAccount', 'OrderDish::editAccount', ['namespace' => 'App\Modules\MenusFood\Controllers']);



/**
 * --------------------------------------------------------------------
 * HMVC Routing
 * --------------------------------------------------------------------
 */

/*foreach(glob(APPPATH . 'Modules/*', GLOB_ONLYDIR) as $item_dir)
{
	if (file_exists($item_dir . '/Config/Routes.php'))
	{
		require_once($item_dir . '/Config/Routes.php');
	}	
}*/

/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need to it be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */

if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
