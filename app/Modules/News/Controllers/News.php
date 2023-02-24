<?php 
namespace App\Modules\News\Controllers;

class News extends BaseController
{
	public function index()	{


        //--------------------------------------------------------------------
        //Get list users
		
		//--------------------------------------------------------------------
		$conditions = [];
		$list_news = $this->news->getList();
		$list_cate = $this->category->getList();

		$post = $this->request->getGet();
		if(!empty($post)){
			$conditions['name_vn'] = $post['name_vn'];
			$conditions['cid'] = $post['cid'];
			$conditions['status'] = $post['status'];
			$data['search'] = $conditions;
			$list_news = $this->news->getList($conditions);
		}
		$list_all_cate = $this->category->getAllCate(0,0,$conditions['cid']);
		
		//--------------------------------------------------------------------
		$data['list_news'] 	= $list_news;
		$data['list_cate'] 	= $list_cate;
		$data['list_all_cate'] 	= $list_all_cate;
		$data['title'] = 'Quản lý Tin bài';
		$data['view'] = 'backend/news/index';
		
		return view('kapella/layout', $data);
	}
	public function listNews($page = 1){
		$dataUser = $this->dataUserAuthen;
        $username = $dataUser->username;
		$title = 'Danh sách tin bài';
		$arraySearch = [
			'status' => -1
		];
		//Pagination
        $page 					= ($this->page)? $this->page : 1;
        $data['page'] 			= $page;
        $data['perPage'] 		= PERPAGE;
        $data['pager'] 			= $this->pager;
        $data['total'] 			= 0;
        $data['uri'] = $this->uri;
        $conditions['OFFSET'] = (($page - 1) * $data['perPage']);
        $conditions['LIMIT']  = $data['perPage'];

		$cateNews = $this->newsModels->getAllCate();
		$get = $this->request->getGet();
		if(!empty($get)){
			$arraySearch = [
				'titleNews' => $get['titleNews'],
				'category' => $get['category'],
				'status' => $get['status'],
			];
			$arrCate = explode(',', $get['category']);
			$cateNews = $this->newsModels->getAllCate(PID_DANH_MUC_SAN_PHAM, 0, $arrCate);
		}
		$listCategory = $this->newsModels->getListCateAll();
		$listNews = $this->newsModels->getListNews($arraySearch, $conditions);
		$getTotalNews = $this->newsModels->getTotalNews($arraySearch);
		// echo $getTotalNews;die;
		
		foreach($listNews as $keyNews => $news ){
			$listNews[$keyNews]['NEWS_CONTENT'] = $news['NEWS_CONTENT']->load();
		}
		// echo '<pre>';
		// print_r($listNews);die;
        $data['get'] = $get;
        $data['total'] = $getTotalNews;
		$listCategory = [];
		$data['listCategory'] = $listCategory;
		$data['cateNews'] = $cateNews;
		$data['title'] = $title;
		$data['listNews'] = $listNews;
		$data['dataUser'] = $dataUser;
		$data['view'] = 'App\Modules\News\Views\listNews';
        return view('layoutKho/layout', $data);
	}
	public function createNews(){
		$dataUser = $this->dataUserAuthen;
        $username = $dataUser->username;
        $userId = $dataUser->userId;
		$post = $this->request->getPost();
		$title = 'Tạo tin bài';
		$listCategory = $this->newsModels->getListCateAll();
		$cateNews = $this->newsModels->getAllCate();
		// echo '<pre>';
		// print_r($cateNews);die;
		if(!empty($post)){
			$newsTitle = $post['newsTitle'];
			$newsSapo = $post['newsSapo'];
			$newsContent = $post['newsContent'];
			$newContent = str_replace( array( 'src="/ckfinder/userfiles/files'), 'src="'.URL_IMAGE_CMS.'/ckfinder/userfiles/files', $newsContent);
            $newsContent = $newContent;
			$newsThumbnail = $post['newsThumbnail'];
			$status = 1;
			$ajax = 0;
			if(isset($post['ajax'])){
				$ajax = 1;
				$cate = PID_COOKING_RECIPE;
			}else{
				$cate = $post['newsCate'];
				$newsThumbnail = $post['imgThumbnailNews'];
			}
			if($ajax == 0){
				$this->validation->setRules([
					'newsTitle'=> [
						'label' => 'Label.txtNewsTitle',
						'rules' => 'required',
						'errors' => [
						]
					],
					'newsSapo'=> [
						'label' => 'Label.txtNewsSapo',
						'rules' => 'required',
						'errors' => [
						]
					],
					'newsContent'=> [
						'label' => 'Label.txtNewsContent',
						'rules' => 'required',
						'errors' => [
							'checkGreater' => 'Validation.checkGreater'
						]
					],
					'imgThumbnailNews'=> [
						'label' => 'Label.imgThumbnailNews',
						'rules' => 'required',
						'errors' => [
						]
					],
					'newsCate'=> [
						'label' => 'Label.txtNewsCate',
						'rules' => 'required|checkGreater',
						'errors' => [
							'checkGreater' => 'Validation.checkGreater'
						]
					],
				]);
				
				if(!$this->validation->withRequest($this->request)->run()  )
				{
					$getErrors = $this->validation->getErrors();
					$listCategory = [];
					$arrCate = explode(',', $cate);
					$cateNews = $this->newsModels->getAllCate(PID_DANH_MUC_SAN_PHAM, 0, $arrCate);
					$data['post'] = $post;
					$data['cateNews'] = $cateNews;
					$data['dataUser'] = $dataUser;
					$data['getErrors'] = $getErrors;
					$data['listCategory'] = $listCategory;
					$data['title'] = $title;
					$data['view'] = 'App\Modules\News\Views\addNews';
					return view('layoutKho/layout', $data);
				}

			}
			if(isset($post['status'])){
				$status = $post['status'];
			}
			// $slug = $this->convertString->to_slug($newsTitle);
			// $data = [
			// 	'NEWS_CATE_ID' => $cate,
			// 	'NEWS_TITLE' => $newsTitle,
			// 	'SLUG' => $slug,
			// 	'NEWS_SAPO' => $newsSapo,
			// 	'NEWS_CONTENT' => $newsContent,
			// 	'NEWS_IMG' => $newsThumbnail,
			// 	'STATUS' => $status,
			// ];
			$token = $dataUser->token;
			$headers = [
				'Accept: application/json',
				'Content-Type: application/json',
				'Authorization: ' . $token,
			];
		
			$data = [
				'newsCateId' => $cate,
				'newsTitle' => $newsTitle,
				'newsSapo' => $newsSapo,
				'newsContent' => $newsContent,
				'newsImg' => $newsThumbnail,
				'status' => $status,
			];

			$resultCreateNews = $this->newsModels->createNewsApi($data, $username, $headers);
			if($resultCreateNews->status == 200){
				if($ajax == 1){
					$listCooking = $this->productModels->getListCooking();
					$htmlCooking = '';
					foreach($listCooking as $cooking){
						$htmlCooking .= '<option value="'.$cooking['ID'].'">'. $cooking['NEWS_TITLE'] .'</option>';
					}
					echo json_encode(array('success' => true, 'html' => $htmlCooking));die;
				}else{
					setcookie ("__news",'success^_^Tạo thành công',time()+ (60*5) , '/');
					return redirect()->to('/tin-tuc/danh-sach-tin-tuc');
				}
			}else{
				if($ajax == 1){
					echo json_encode(array('success' => false));die;
				}else{
					setcookie ("__news",'false^_^Tạo không thành công',time()+ (60*5) , '/');
					return redirect()->to('/tin-tuc/danh-sach-tin-tuc');
				}
			}
		}
		$data['cateNews'] = $cateNews;
		$data['dataUser'] = $dataUser;
		$data['listCategory'] = $listCategory;
		$data['title'] = $title;
		$data['view'] = 'App\Modules\News\Views\addNews';
        return view('layoutKho/layout', $data);
	}
	public function checkExistNewsTitle(){
		$post = $this->request->getPost();
		if(!empty($post)){
			$title = $post['newsTitle'];
			$checkExist = $this->newsModels->checkExistTitle($title);
			if(empty($checkExist)){
                echo json_encode(array('success' => true, 'status' => '1',));die;
            }else{
                echo json_encode(array('false' => true, 'status' => '0',));die;
            }
		}else{
			echo json_encode(array('false' => true, 'status' => '0',));die;
		}
	}
	public function editNews($id){
		$title = 'Sửa tin bài';
		$dataUser = $this->dataUserAuthen;
        $username = $dataUser->username;
        $userId = $dataUser->userId;
		$listCategory = $this->newsModels->getListCateAll();
		$cateNews = $this->newsModels->getAllCate();
		$news = $this->newsModels->getNewsById($id);
		$news['NEWS_CONTENT'] = $news['NEWS_CONTENT']->load();
		$post = $this->request->getPost();
		if(!empty($post)){
			$this->validation->setRules([
				'newsTitle'=> [
					'label' => 'Label.txtNewsTitle',
					'rules' => 'required',
					'errors' => [
					]
				],
				'newsSapo'=> [
					'label' => 'Label.txtNewsSapo',
					'rules' => 'required',
					'errors' => [
					]
				],
				'newsContent'=> [
					'label' => 'Label.txtNewsContent',
					'rules' => 'required',
					'errors' => [
						'checkGreater' => 'Validation.checkGreater'
					]
				],
				'imgThumbnailNews'=> [
					'label' => 'Label.imgThumbnailNews',
					'rules' => 'required',
					'errors' => [
					]
				],
				'newsCate'=> [
					'label' => 'Label.txtNewsCate',
					'rules' => 'required|checkGreater',
					'errors' => [
						'checkGreater' => 'Validation.checkGreater'
					]
				],
			]);
			
			if(!$this->validation->withRequest($this->request)->run())
			{
				$getErrors = $this->validation->getErrors();
				
				$news = [
					'NEWS_TITLE' => $post['newsTitle'],
					'NEWS_SAPO' => $post['newsSapo'],
					'NEWS_CONTENT' => $post['newsContent'],
					'NEWS_IMG' => $post['imgThumbnailNews'],
					'STATUS' => $post['status'],
					'NEWS_CATE_ID' => $post['newsCate'],
				];
				$data['news'] = $news;
				$data['getErrors'] = $getErrors;
				$data['cateNews'] = $cateNews;
				$listCategory = [];
				$data['listCategory'] = $listCategory;
				$data['title'] = $title;
				$data['view'] = 'App\Modules\News\Views\editNews';
				return view('layoutKho/layout', $data);
			}else{
				$newsTitle = $post['newsTitle'];
				$newsSapo = $post['newsSapo'];
				$newsContent = $post['newsContent'];
				$newContent = str_replace( array( 'src="/ckfinder/userfiles/files'), 'src="'.URL_IMAGE_CMS.'/ckfinder/userfiles/files', $newsContent);
				$newsContent = $newContent;
				$newsThumbnail = $post['imgThumbnailNews'];
				$cate = $post['newsCate'];
				$status = $post['status'];
				$slug = $this->convertString->to_slug($newsTitle);
				$dataUpdate = [
					'newsId'=>$id,
					'newsCateId' => $cate,
					'newsTitle' => $newsTitle,
					'newsSapo' => $newsSapo,
					'newsContent' => $newsContent,
					'newsImg' => $newsThumbnail,
					'status' => $status
				];
				// $dataUpdate = [
				// 	'NEWS_CATE_ID' => $cate,
				// 	'NEWS_TITLE' => $newsTitle,
				// 	'SLUG' => $slug,
				// 	'NEWS_SAPO' => $newsSapo,
				// 	'NEWS_CONTENT' => $newsContent,
				// 	'NEWS_IMG' => $newsThumbnail,
				// 	'STATUS' => $status,
				// 	'EDITED_BY' => $userId,
				// ];
				$token = $dataUser->token;
				$headers = [
					'Accept: application/json',
					'Content-Type: application/json',
					'Authorization: ' . $token,
				];
				$resultUpdateNews = $this->newsModels->updateNewsApi($dataUpdate, $username, $headers);
				if($resultUpdateNews->status == 200){
					setcookie ("__news",'success^_^Cập nhật thành công',time()+ (60*5) , '/');
				}else{
					setcookie ("__news",'false^_^Cập nhật không thành công',time()+ (60*5) , '/');
				}
				return redirect()->to('/tin-tuc/danh-sach-tin-tuc');
			}
		}
		$data['dataUser'] = $dataUser;
		$data['news'] = $news;
		$data['cateNews'] = $cateNews;
		$data['listCategory'] = $listCategory;
		$data['title'] = $title;
		$data['view'] = 'App\Modules\News\Views\editNews';
        return view('layoutKho/layout', $data);
	}

	public function removeNews(){
		$dataUser = $this->dataUserAuthen;
        $username = $dataUser->username;
        $userId = $dataUser->userId;
		$post = $this->request->getPost();
		if(!empty($post)){
			$id = $post['newsId'];
			$data = [
				'USER_ID' => $userId,
				'USERNAME' => $username,
				'ID' => $id
			];
			$result = $this->newsModels->removeNews($data);
			if($result){
				setcookie ("__news",'success^_^Xóa thành công',time()+ (60*5) , '/');
				echo json_encode(array('success' => true));die;
			}else{
				setcookie ("__news",'fail^_^Xóa không thành công',time()+ (60*5) , '/');
				echo json_encode(array('success' => false));die;
			}
		}
			
	}

	public function uploadImage($data){
		
		$file = $this->request->getFile('upload');
		
		// if (!empty($_FILES['upload']['name'])) {
			$upload_path = FCPATH .'public/uploads';
			if(!is_dir($upload_path)) 
				{
					mkdir($upload_path,0777,TRUE);
				}
				$newName = $data->getRandomName();

				$data->move($upload_path, $newName);
				return 'public/uploads/'.$newName;
		// }
	}
}
