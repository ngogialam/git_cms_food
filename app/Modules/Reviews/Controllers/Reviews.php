<?php 
namespace App\Modules\Reviews\Controllers;

class Reviews extends BaseController
{
	public function listReviews($page = 1){
		$dataUser = $this->dataUserAuthen;
        $username = $dataUser->username;
		$title = 'Danh sách đánh giá sản phẩm';
		$arraySearch = [];
		$arrGroupMethods = json_decode(METHODS_TYPE);
		//Pagination
        $page 					= ($this->page)? $this->page : 1;
        $data['page'] 			= $page;
        $data['perPage'] 		= PERPAGE;
        $data['pager'] 			= $this->pager;
        $data['total'] 			= 0;
        $data['uri'] = $this->uri;
        $conditions['OFFSET'] = (($page - 1) * $data['perPage']);
        $conditions['LIMIT']  = $data['perPage'];

        $resultListReviews = $this->reviewsModels->getListReviews($arraySearch, $conditions);
		$get = $this->request->getGet();
		if(!empty($get)){
			$arraySearch = [
				'methodsName' => $get['methodsName'],
				'methodsType' => $get['methodsType'],
				'status' => $get['statusMethods'],
				'methodsShow' => $get['showMethods'],
			];
            $data['conditions'] = $arraySearch;
            $resultListReviews = $this->reviewsModels->getListReviews($arraySearch, $conditions);
            
		}

		$getTotal = $this->reviewsModels->getTotalReviews($arraySearch, $conditions);
		$resultListProduct = $this->reviewsModels->getListProducts($username);
       

      
        $data['get'] = $arraySearch;
        $data['total'] = $getTotal;
        $data['resultListProduct'] = $resultListProduct;
        //  print_r(  $data['resultListProduct']);die; 
        $data['arrGroupMethods'] = (array) $arrGroupMethods;
		$data['objects'] = $resultListReviews;
		$data['title'] = $title;
		$data['dataUser'] = $dataUser;
		$data['view'] = 'App\Modules\Reviews\Views\listReviews';
        return view('layoutKho/layout', $data);
	}

	public function addReviews(){
		$dataUser = $this->dataUserAuthen;
        $username = $dataUser->username;
		$userId = $dataUser->userId;
		$arrGroupMethods = json_decode(METHODS_TYPE);
		$post = $this->request->getPost();
		if(!empty($post)){
			$this->validation->setRules([
                'product'=> [
                    'label' => 'Label.txtProduct',
                    'rules' => 'required|checkGreater',
                    'errors' => [
                        'checkGreater' => 'Validation.checkGreater'
                    ]
                ],
                'comment'=> [
                    'label' => 'Label.txtComment',
                    'rules' => 'required',
                    'errors' => [
                    ]
                ],
                'scoreReviews'=> [
                    'label' => 'Label.txtScore',
                    'rules' => 'required',
                    'errors' => [
                    ]
                ],
            ]);

            if(!$this->validation->withRequest($this->request)->run()  )
            {
                $getErrors = $this->validation->getErrors();
                echo json_encode(array('success' => false, 'data' => $getErrors));die;
            }else{
                $dataInsert = [
					'PRODUCT_ID' => $post['product'],
					'SCORES' => $post['scoreReviews'],
					'STATUS' => $post['statusReviews'],
					'COMMENTS' => $post['comment'],
					'IS_SHOW' => $post['isShow'],
				];
                
                $resultAddReviews = $this->reviewsModels->createReviews($dataInsert, $username);
                
                if(!empty($resultAddReviews)){
                    $dataImg = [];
                    $rreviewId = $resultAddReviews['CURRVAL'];
                    if(isset($post['imgReviews']) && $post['imgReviews'] != ''){ 
                        $dataImg = [
                                'VOTE_ID' => $rreviewId,
                                'IMAGE' => $post['imgReviews'],
                                'STATUS' => 1,
                            ];
                        $resultAddMethods = $this->reviewsModels->createReviewsImg($dataImg, $username);
                    }
                    setcookie ("__reviews",'success^_^Tạo thành công',time()+ (60*5) , '/');
                }else{
                    setcookie ("__reviews",'false^_^Tạo không thành công',time()+ (60*5) , '/');
                }
                echo json_encode(array('success' => true));die;
            }
		}
		$data['arrGroupMethods'] = (array) $arrGroupMethods;
		$data['view'] = 'App\Modules\Methods\Views\addMethods';
        return view('layoutKho/layout', $data);
	}

    public function editReviews(){
        $dataUser = $this->dataUserAuthen;
        $username = $dataUser->username;
		$userId = $dataUser->userId;
		$post = $this->request->getPost();
       
		if(!empty($post) && $post['getData'] == 1){
			$getReviewById = $this->reviewsModels->getReviewById($post['id']);
			if($getReviewById){
                $htmlTypeReview = '';
                $listProducts = $this->reviewsModels->getListProducts($username);
                foreach($listProducts as $product){
                    if($getReviewById->productId == $product->ID){
                        $htmlTypeReview .= '<option selected value="'.$product->ID.'">'.$product->NAME.' </option>';
                    }else{
                        $htmlTypeReview .= '<option value="'.$product->ID.'">'.$product->NAME.' </option>';
                    }
                }
				echo json_encode(array('success' => true, 'data' => $getReviewById, 'htmlOptions' => $htmlTypeReview));die;
			}else{
				setcookie ("__notiCate",'false^_^Không tồn tại đánh giá',time()+ (60*5) , '/');
				echo json_encode(array('success' => false));die;
			}			
		}
		if(!empty($post) && $post['getData'] == 0){


			$idProduct = $post['idProduct'];
            $vote = $post['vote'];
            $status = $post['status'];
            $isShow = $post['isShow'];
            $images = $post['images'];
            $comment = $post['comment'];

			$this->validation->setRules([
                'product'=> [
                    'label' => 'Label.txtProduct',
                    'rules' => 'required|checkGreater',
                    'errors' => [
                        'checkGreater' => 'Validation.checkGreater'
                    ]
                ],
                'comment'=> [
                    'label' => 'Label.txtComment',
                    'rules' => 'required',
                    'errors' => [
                    ]
                ],
                'scoreReviews'=> [
                    'label' => 'Label.txtScore',
                    'rules' => 'required',
                    'errors' => [
                    ]
                ],
            ]);
			if(!$this->validation->withRequest($this->request)->run()) {
                $getErrors = $this->validation->getErrors();
                echo json_encode(array('success' => false, 'data' => $getErrors));die;
            }else{
                $dataUpdate = [
                    'PRODUCT_ID' => $post['product'],
                    'SCORES' => $post['scoreReviews'],
                    'STATUS' => $post['statusReviews'],
                    'COMMENTS' => $post['comment'],
                    'IS_SHOW' => $post['isShow'],
                ];
                
                $voteId = $post['voteId'];
                $respon = $this->reviewsModels->updataReview($dataUpdate, $voteId, $username);
                if( $post['imgReviews'] != ''){ 
                    $img = $this->reviewsModels->removeVoteImg($voteId,$username);
                    $dataImg = [
                            'VOTE_ID' => $voteId,
                            'IMAGE' => $post['imgReviews'],
                            'STATUS' => 1,
                        ];
                    $resultAddMethods = $this->reviewsModels->createReviewsImg($dataImg, $username);
                }

                if($respon){
                    setcookie ("__methods",'success^_^Sửa thành công',time()+ (60*5) , '/');
                }else{
                    setcookie ("__methods",'false^_^Sửa không thành công',time()+ (60*5) , '/');
                }
                echo json_encode(array('success' => true));die;
                // return redirect()->to('/danh-gia/danh-sach-danh-gia');
            }
		}
    }
    public function deleteReviews(){
        $dataUser = $this->dataUserAuthen;
		$post = $this->request->getPost();
		if(!empty($post)){
			$data = [
				'STATUS' => $post['status']
			];
            $ids =  str_replace(',', "','", $post['id']);
			$result = $this->reviewsModels->disableReviews($ids, $data);
			if($result){
				setcookie ("__reviews",'success^_^Xóa thành công',time()+ (60*5) , '/');
				echo json_encode(array('success' => true));die;
			}else{
				setcookie ("__reviews",'false^_^Xóa không thành công',time()+ (60*5) , '/');
				echo json_encode(array('success' => false));die;
			}
		}
    }
}
