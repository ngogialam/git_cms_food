<?php 
namespace App\Modules\Backend\Config\Controllers;

class Index extends BaseController
{
	public function index()	{
		$post = $this->request->getPost();
		if (!empty($post)) {
			if(isset($post['config_index']['intro'])){
				$post['config_index']['intro'] = 1;
			}else{
				$post['config_index']['intro'] = 0;
			}

			if(isset($post['config_index']['featured_services'])){
				$post['config_index']['featured_services'] = 1;
			}else{
				$post['config_index']['featured_services'] = 0;
			}

			if(isset($post['config_index']['about'])){
				$post['config_index']['about'] = 1;
			}else{
				$post['config_index']['about'] = 0;
			}

			if(isset($post['config_index']['services'])){
				$post['config_index']['services'] = 1;
			}else{
				$post['config_index']['services'] = 0;
			}

			if(isset($post['config_index']['team'])){
				$post['config_index']['team'] = 1;
			}else{
				$post['config_index']['team'] = 0;
			}

			if(isset($post['config_index']['contact'])){
				$post['config_index']['contact'] = 1;
			}else{
				$post['config_index']['contact'] = 0;
			}

			$config = array(
				'config_index' 			=> $post['config_index'],
				'config_contact' 		=> $post['config_contact'],
				'config_intro_footer' 	=> $post['config_intro_footer']
			);
			$config = json_encode($config);
			$data_update = array(
				'configs' => $config
			);
			$update = $this->config->updateConfigs($data_update);
		}
		$config = $this->config->getConfigs();
		$config = json_decode($config['configs']);

		$data['config_index'] 			= $config->config_index;
		$data['config_contact'] 		= $config->config_contact;
		$data['config_intro_footer']	= $config->config_intro_footer;

        //--------------------------------------------------------------------
		$data['title'] = 'Thiết lập hệ thống';
		$data['view'] = 'backend/config/index';
		
		return view('kapella/layout', $data);
	}
}
