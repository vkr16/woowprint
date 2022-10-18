<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Admin extends BaseController
{
    protected $session;
    protected $adminModel;
    protected $orderModel;
    protected $photoModel;

    function __construct()
    {
        $this->session = \Config\Services::session();
        $this->adminModel = model('AdminModel', true, $db);
        $this->orderModel = model('OrderModel', true, $db);
        $this->photoModel = model('PhotoModel', true, $db);
    }

    public function index()
    {
        return view('admin/dashboard');
    }

    /**
     * Orders
     */
    public function orders()
    {
        return view('admin/orders/list');
    }

    public function ordersGetUploading()
    {
        $data['orders_uploading'] = $this->orderModel->where('status', 'uploading')->orderBy('id', 'asc')->find();

        $db = \Config\Database::connect();
        $builder = $db->table('photos');

        foreach ($data['orders_uploading'] as $key => $order) {
            $data['orders_uploading'][$key]['uploaded'] = $builder->select('*')->where('order_id =', $order['id'])->where('deleted_at =', NULL)->countAllResults();
        }


        return view('admin/orders/uploading_table', $data);
    }

    public function ordersGetQueued()
    {
        $data['orders_queued'] = $this->orderModel->where('status', 'queued')->orderBy('id')->find();

        return view('admin/orders/queued_table', $data);
    }

    public function ordersGetProcessing()
    {
        $data['orders_processing'] = $this->orderModel->where('status', 'processing')->orderBy('id')->find();

        return view('admin/orders/processing_table', $data);
    }

    public function ordersGetShipping()
    {
        $data['orders_shipping'] = $this->orderModel->where('status', 'shipping')->orderBy('id')->find();

        return view('admin/orders/shipping_table', $data);
    }

    public function ordersGetCompleted()
    {
        $data['orders_completed'] = $this->orderModel->where('status', 'completed')->orderBy('id')->find();

        return view('admin/orders/completed_table', $data);
    }

    public function ordersAdd()
    {
        $cust_name = trim($_POST['cust_name']);
        $cust_phone = trim($_POST['cust_phone']);
        $cust_address = trim($_POST['cust_address']);
        $description = trim($_POST['description']);
        $amount_photo = trim($_POST['amount_photo']);
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $order_no = '';
        for ($i = 0; $i < 6; $i++) {
            $order_no .= $characters[rand(0, $charactersLength - 1)];
        }
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $token = '';
        for ($i = 0; $i < 16; $i++) {
            $token .= $characters[rand(0, $charactersLength - 1)];
        }

        if ($cust_name == '' || $cust_phone == '' || $cust_address == '' || $description == '' || $amount_photo == '') {
            return "empty";
        } else {
            if ($this->orderModel->where('order_no', $order_no)->find()) {
                return "conflict";
            } else {
                // return $order_no . '-' . $token;
                $newOrder = [
                    "order_no" => $order_no,
                    "token" => $token,
                    "cust_name" => $cust_name,
                    "cust_phone" => $cust_phone,
                    "cust_address" => $cust_address,
                    "description" => $description,
                    "amount_photo" => $amount_photo,
                    "status" => 'uploading',
                    "order_maker" => $this->session->get('oms_cetakfoto_user_session')
                ];

                if ($this->orderModel->insert($newOrder)) {
                    return "success";
                } else {
                    return "failed";
                }
            }
        }
    }
}
