<?php

namespace App\Modules\Zalo\Controllers;

class ZaloController extends BaseController
{
    public function listTempl()
    {
        $dataUser = $this->dataUserAuthen;
        $data = [];
        $get = $this->request->getGet();
        $page                      = ($this->page) ? $this->page : 1;
        $data['page']              = $page;
        $data['perPage']           = PERPAGE;
        $data['pager']             = $this->pager;
        $data['total']             = 0;
        $data['uri'] = $this->uri;
        $conditions['OFFSET'] = (($page - 1) * $data['perPage']);
        $conditions['LIMIT']  = $data['perPage'];


        $dataRequest = [
            'templateId' => '',
            'status' => -1,
            'service' => -1,
            'page' => 1,
            'pagesize' => 10
        ];

        if (!empty($get)) {
            $templateId = $get['templateId'];
            $service = $get['service'];
            $status = $get['status'];

            $dataRequest = [
                'templateId' => $templateId,
                'status' => $status,
                'service' => $service,
                'page' => 1,
                'pagesize' => 10
            ];
        }
        // print_r($dataRequest);
        // die;

        $token = $dataUser->token;

        $headers = [
            'Accept: application/json',
            'Content-Type: application/json',
            'Authorization: ' . $token,
        ];

        $dataTemplate = $this->zaloModal->getTempl($dataRequest, $headers);

        if ($dataTemplate->data) {
            $data['total'] = $dataTemplate->data->numberRecord;
            $data['dataTemplate'] = $dataTemplate->data->templateList;
        }
        $data['dataUser'] = $dataUser;
        $data['dataRequest'] = $dataRequest;
        $data['view'] = 'App\Modules\Zalo\Views\listTemplZalo';
        return view('layoutKho/layout', $data);
    }

    public function activeTempl()
    {
        $dataUser = $this->dataUserAuthen;
        $token = $dataUser->token;

        $headers = [
            'Accept: application/json',
            'Content-Type: application/json',
            'Authorization: ' . $token,
        ];

        $post = $this->request->getPost();

        $data = [
            'templateId' => $post['templateId'],
            'status' => $post['status'] == 0 ? 1 : 0
        ];

        $result = $this->zaloModal->activeTemplModels($data, $headers);

        if ($result) {
            setcookie("__templ", 'success^_^Cập nhật thành công', time() + (60 * 5), '/');
            echo json_encode(array('success' => true, 'data' => $result->message));
            die;
        } else {
            setcookie("__templ", 'false^_^Cập nhật không thành công', time() + (60 * 5), '/');
            echo json_encode(array('success' => false, 'data' => $result->message));
            die;
        }

        return redirect()->to('/user/danh-sach-nguoi-dung');
    }

    public function exportExcelZalo()
    {
        $dataUser = $this->dataUserAuthen;
        $token = $dataUser->token;

        $headers = [
            'Accept: application/json',
            'Content-Type: application/json',
            'Authorization: ' . $token,
        ];

        $post = $this->request->getPost();

        $data = [
            'templateId' => !empty($post['templateId']) ?  $post['templateId'] : '',
            'service' => (int) $post['service'],
            'status' => (int) $post['status']
        ];

        $result = $this->zaloModal->exportExcelZalo($data, $headers);

        $fileName = 'Danh sách biểu mẫu tin nhắn Zalo';

        $response =  array(
            'href' => base_url('/quan-ly-zalo'),
            'name' => $fileName,
            'status' => '200',
            'file' => "data:application/vnd.ms-excel;base64," . base64_encode($result)
        );

        die(json_encode($response));
    }
}
