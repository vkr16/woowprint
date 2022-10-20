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
        return redirect()->to(base_url('admin/orders'));
    }

    public function shippingConfig()
    {
        $name = $_POST['updateSenderName'];
        $phone = $_POST['updateSenderPhone'];
        $address = $_POST['updateSenderAddress'];

        $db = \Config\Database::connect();
        if ($db->query("UPDATE shipping SET sender_name = '$name', sender_phone = '$phone', sender_address = '$address' WHERE id = '1'")) {
            $this->session->setFlashdata('ReturnSuccess', 'Sender information has been updated');
        } else {
            $this->session->setFlashdata('ReturnFailed', 'Internal Server Error');
        }

        return redirect()->to(base_url('admin/orders'));
    }

    /**
     * Orders
     */
    public function orders()
    {
        $db = \Config\Database::connect();
        $query = $db->query("SELECT * FROM shipping WHERE id = '1'");

        $data['sender'] = $query->getResult('array');

        return view('admin/orders/list', $data);
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
                    "status" => 'uploading'
                ];

                if ($this->orderModel->insert($newOrder)) {
                    return "success";
                } else {
                    return "failed";
                }
            }
        }
    }

    public function ordersDelete()
    {
        $id = $_POST['id'];
        $order_no = $_POST['order_no'];

        if ($order = $this->orderModel->where('order_no', $order_no)->where('id', $id)->find()) {
            if ($this->orderModel->delete($id)) {
                $photos = $this->photoModel->where('order_id', $order[0]['id'])->find();
                foreach ($photos as $key => $photo) {
                    $this->photoModel->delete($photo['id']);
                    unlink('public/uploads/' . $photo['file_name']);
                }
                return "success";
            }
        } else {
            return "notfound";
        }
    }

    public function ordersUpdate()
    {
        $id = $_POST['id'];
        $cust_name = trim($_POST['cust_name']);
        $cust_phone = trim($_POST['cust_phone']);
        $cust_address = trim($_POST['cust_address']);
        $description = trim($_POST['description']);
        $amount_photo = trim($_POST['amount_photo']);

        $newOrderData = [
            'cust_name' => $cust_name,
            'cust_phone' => $cust_phone,
            'cust_address' => $cust_address,
            'description' => $description,
            'amount_photo' => $amount_photo
        ];

        if ($cust_name == '' || $cust_phone == '' || $cust_address == '' || $description == '' || $amount_photo == '') {
            return "empty";
        } else {
            if ($this->orderModel->find($id)) {
                if ($this->orderModel->where('id', $id)->set($newOrderData)->update()) {
                    return "success";
                } else {
                    return "failed";
                }
            } else {
                return "notfound";
            }
        }
    }

    public function ordersUpdateStatus()
    {
        $id = $_POST['id'];
        $order_no = trim($_POST['order_no']);
        $status = trim($_POST['status']);

        if ($order_no == '' || $status == '') {
            return "empty";
        } else {
            if ($this->orderModel->where('order_no', $order_no)->where('id', $id)->find()) {
                if ($this->orderModel->where('id', $id)->set('status', $status)->update()) {
                    return "success";
                }
            } else {
                return "notfound";
            }
        }
    }

    public function ordersDownload()
    {
        $id = $_POST['id'];
        $order_no = $_POST['order_no'];

        if ($this->orderModel->where('id', $id)->where('order_no', $order_no)->find()) {
            if ($photos = $this->photoModel->where('order_id', $id)->find()) {
                return json_encode($photos);
            }
        }
    }

    public function photosDownload()
    {
        if (isset($_GET['i'])) {
            $file_name = $_GET['i'];

            return $this->response->download('public/uploads/' . $file_name, null);
        }
    }

    public function ordersFinished()
    {
        $id = $_POST['id'];
        $order_no = $_POST['order_no'];

        if ($this->orderModel->where('id', $id)->where('order_no', $order_no)->find()) {
            if ($this->orderModel->where('id', $id)->set('status', 'shipping')->update()) {
                return "success";
            }
        } else {
            return "notfound";
        }
    }

    public function ordersCompleted()
    {
        $id = $_POST['id'];
        $order_no = $_POST['order_no'];

        if ($this->orderModel->where('id', $id)->where('order_no', $order_no)->find()) {
            if ($this->orderModel->where('id', $id)->set('status', 'completed')->update()) {
                $photos = $this->photoModel->where('order_id', $id)->find();

                foreach ($photos as $key => $photo) {
                    $this->photoModel->delete($photo['id']);
                    unlink('public/uploads/' . $photo['file_name']);
                }
                return "success";
            }
        } else {
            return "notfound";
        }
    }

    public function ordersDeliveryNote()
    {
        $order_no = $_GET['i'];


        $db = \Config\Database::connect();
        $query = $db->query("SELECT * FROM shipping WHERE id = '1'");

        $data['sender'] = $query->getResult('array');

        $data['order'] = $this->orderModel->where('order_no', $order_no)->find();

        return view('admin/orders/delivery_note', $data);
    }


    /**
     * Admin Management
     */
    public function administrators()
    {
        $data['administrators'] = $this->adminModel->findAll();
        return view('admin/administrators/list', $data);
    }

    public function administratorsAdd()
    {
        $name = trim($_POST['inputName']);
        $username = trim($_POST['inputUsername']);
        $password = trim($_POST['inputPassword']);

        $newData = [
            'name' => $name,
            'username' => $username,
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ];

        if (!$this->adminModel->where('username', $username)->find()) {
            if ($this->adminModel->insert($newData)) {
                $this->session->setFlashdata('ReturnSuccess', 'New admin has been added');
            }
        } else {
            $this->session->setFlashdata('ReturnFailed', 'Username already taken');
        }
        return redirect()->to(base_url('admin/administrators'));
    }

    public function administratorsReset()
    {
        $id = $_POST['adminId'];
        $password = trim($_POST['inputPassword2']);

        if ($password != '') {
            if ($this->adminModel->find($id)) {
                if ($this->adminModel->where('id', $id)->set('password', password_hash($password, PASSWORD_DEFAULT))->update()) {
                    $this->session->setFlashdata('ReturnSuccess', 'Password has been reset');
                }
            } else {
                $this->session->setFlashdata('ReturnFailed', 'Administrator not found');
            }
        } else {
            $this->session->setFlashdata('ReturnFailed', 'Password cannot be empty');
        }
        return redirect()->to(base_url('admin/administrators'));
    }

    public function administratorsUpdate()
    {
        $id = trim($_POST['adminId']);
        $name = trim($_POST['inputName2']);
        $username = trim($_POST['inputUsername2']);

        $newData = [
            'name' => $name,
            'username' => $username,
        ];

        if ($this->adminModel->where('username', $username)->where('id <>', $id)->find()) {
            $this->session->setFlashdata('ReturnFailed', 'Username already taken');
        } else {
            if ($this->adminModel->where('id', $id)->set($newData)->update()) {
                $this->session->setFlashdata('ReturnSuccess', 'Admin data has been updated');
            }
        }
        return redirect()->to(base_url('admin/administrators'));
    }

    public function administratorsDelete()
    {
        $id = $_GET['id'];

        if ($this->adminModel->find($id)) {
            if ($this->adminModel->delete($id)) {
                $this->session->setFlashdata('ReturnSuccess', 'Admin data has been deleted');
            }
        } else {
            $this->session->setFlashdata('ReturnFailed', 'Admin data not found');
        }
        return redirect()->to(base_url('admin/administrators'));
    }
}
