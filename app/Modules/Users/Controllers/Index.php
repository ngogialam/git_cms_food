<?php 
namespace App\Modules\Users\Controllers;

class Index extends BaseController
{
	
	public function index()	{


        //--------------------------------------------------------------------
        //Get list users
		$result = $this->user->getListUsers();
		
        //--------------------------------------------------------------------
		$data['listUser'] 	= $result;
		$data['title'] = 'Quản lý thông tin người dùng';
		$data['view'] = 'backend/users/index';
		
		return view('kapella/layout', $data);
	}

	//--------------------------------------------------------------------
	
	public function create(){
		$post = $this->request->getPost();
		if(!empty($post)){
			$data = [
				'username' => $post['txt_username'],
				'password' => md5($post['txt_password']),
				'name' => $post['txt_name'],
				'status'  => $post['status'],
			];
			$result = $this->user->addUser($data);
			if($result){
				$this->logger->info('Tai khoan: '.$this->auth['username'].' | Them moi user | Ket qua : thanh cong', array(), 'users');
				$this->session->setFlashdata('msg_usr', 'Tạo user thành công.');
			}else{
				$this->logger->info('Tai khoan: '.$this->auth['username'].' | Them moi user | Ket qua : khoong thanh cong', array(), 'users');
				$this->session->setFlashdata('msg_usr', 'Tạo user không thành công.');
			}
			return redirect()->to('/backend/user');
		}
		
		//--------------------------------------------------------------------
		$data['title'] = 'Thêm mới người dùng';
		$data['view'] = 'backend/users/add';
		return view('kapella/layout', $data);
	}

	public function checkUsername(){
		$post = $this->request->getPost();
		$respond = '0';
		if(!empty($post)){
			$username = $post['username'];
			$result = $this->user->checkExistUser($username);
			if(!empty($result)){
				$respond = '1';
			}
		}
		return $respond;

	}
	public function editUser($id){
		$result = $this->user->getUser($id);
		$post = $this->request->getPost();
		if(!empty($post)){
			$data = [
				'username' => $result['username'],
				'name' => $post['txt_name'],
				'status'  => $post['status'],
			];
			$result = $this->user->updateUser($id,$data);
			if($result){
				$this->logger->info('Tai khoan: '.$this->auth['username'].' | Sua user '.$id.' | Ket qua : thanh cong', array(), 'users');
				$this->session->setFlashdata('msg_usr', 'Sửa user thành công.');
			}else{
				$this->logger->info('Tai khoan: '.$this->auth['username'].' | Sua user '.$id.' | Ket qua : Khong thanh cong', array(), 'users');
				$this->session->setFlashdata('msg_usr', 'Sửa user không thành công.');
			}
			return redirect()->to('/backend/user');
		}
		$data['id'] = $id;
		$data['user'] = $result;
		$data['title'] = 'Chỉnh sửa thông tin người dùng';
		$data['view'] = 'backend/users/edit';
		return view('kapella/layout', $data);
	}

	public function changePass(){
		$post = $this->request->getPost();
		if(!empty($post)){
			$auth = $this->session->get('auth');
			$id = $auth[0]['ID'];
			$data =[
				'password' => md5($post['txt_password'])
			];

			$result = $this->user->changePass($id,$data);
			if($result){
				$this->logger->info('Tai khoan: '.$this->auth['username'].' | Doi mat khau '.$id.' | Ket qua : thanh cong', array(), 'users');
				$this->session->setFlashdata('msg_usr', 'Đổi mật khẩu thành công.');
			}else{
				$this->logger->info('Tai khoan: '.$this->auth['username'].' | Doi mat khau '.$id.' | Ket qua : Khong thanh cong', array(), 'users');
				$this->session->setFlashdata('msg_usr', 'Đổi mật khẩu không thành công.');
			}
			return redirect()->to('/backend/user');

		}
		
		$data['title'] = 'Đổi mật khẩu người dùng';
		$data['view'] = 'backend/users/changePass';
		return view('kapella/layout', $data);
	}

	public function deleteUser($id){
		$result = $this->user->deleteUser($id);
			if($result){
				$this->logger->info('Tai khoan: '.$this->auth['username'].' | Khoa user '.$id.' | Ket qua : thanh cong', array(), 'users');
				$this->session->setFlashdata('msg_usr', 'Xóa user thành công.');
			}else{
				$this->logger->info('Tai khoan: '.$this->auth['username'].' | Khoa user '.$id.' | Ket qua : Khong thanh cong', array(), 'users');
				$this->session->setFlashdata('msg_usr', 'Xóa user không thành công.');
			}
			return redirect()->to('/backend/user');
	}
	
}
