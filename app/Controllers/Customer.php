<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Files\File;

class Customer extends BaseController
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
        //
    }

    public function auth()
    {
        return view('customer/auth');
    }

    public function customerGetOrder()
    {
        $order_no = $_POST['order_no'];

        if ($order = $this->orderModel->where('order_no', $order_no)->find()) {
            return json_encode($order);
        } else {
            return "notfound";
        }
    }

    public function customerOrderDetail()
    {
        if (!isset($_GET['i'])) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        } else {
            $token = trim($_GET['i']);
            if ($token != '') {
                if ($data['order'] = $this->orderModel->where('token', $token)->find()) {
                    $db = \Config\Database::connect();
                    $builder = $db->table('photos');

                    $data['uploaded'] = $builder->select('*')->where('order_id =', $data['order'][0]['id'])->where('deleted_at =', NULL)->countAllResults();

                    $data['photos'] = $this->photoModel->where('order_id', $data['order'][0]['id'])->find();
                    return view('customer/order', $data);
                } else {
                    throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
                }
            } else {
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
            }
        }
    }
    public function customerUpload()
    {
        $token = trim($_GET['i']);

        if ($token == '') {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        } else {
            if ($order = $this->orderModel->where('token', $token)->find()) {
                $db = \Config\Database::connect();
                $builder = $db->table('photos');

                $uploaded = $builder->select('*')->where('order_id =', $order[0]['id'])->where('deleted_at =', NULL)->countAllResults();

                $validationRule = [
                    'photo' => [
                        'label' => 'Image File',
                        'rules' => 'uploaded[photo]'
                            . '|is_image[photo]'
                            . '|mime_in[photo,image/jpg,image/JPG,image/jpeg,image/JPEG,image/png,image/PNG,image/webp,image/WEBP]'
                    ],
                ];
                if (!$this->validate($validationRule)) {
                    $this->session->setFlashdata('return', 'File gambar tidak valid');
                    return redirect()->to(base_url('order') . "?i=" . $token);
                }

                $file = $this->request->getFile('photo');

                $newName = str_replace(" ", "", $order[0]['cust_name']) . '-' . $order[0]['order_no'] . '-' . time() . '.' . $file->getClientExtension();

                $photoData = [
                    "file_name" => $newName,
                    "order_id" => $order[0]['id']
                ];

                if ($uploaded < $order[0]['amount_photo']) {
                    if ($file->move("public/uploads/", $newName)) {
                        if ($this->photoModel->insert($photoData)) {
                            $this->session->setFlashdata('success', 'Pengunggahan gambar berhasil!');
                            return redirect()->to(base_url('order') . "?i=" . $token);
                        } else {
                            $this->session->setFlashdata('error', 'Pengunggahan gambar gagal! <br>(Error : database server)');
                            return redirect()->to(base_url('order') . "?i=" . $token);
                        }
                    } else {
                        $this->session->setFlashdata('error', 'Pengunggahan gambar gagal! <br>(Error : image server hosting)');
                        return redirect()->to(base_url('order') . "?i=" . $token);
                    }
                } else {
                    $this->session->setFlashdata('error', 'Pengunggahan gambar gagal! <br>Jumlah foto melebihi batas!');
                    return redirect()->to(base_url('order') . "?i=" . $token);
                }
            } else {
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
            }
        }
    }

    public function customerDeletePhoto()
    {
        $id = $_POST['id'];
        $file_name = $_POST['file_name'];


        if ($this->photoModel->where('file_name', $file_name)->where('id', $id)->find()) {
            if ($this->photoModel->delete($id)) {
                unlink('public/uploads/' . $file_name);
                return "deleted";
            }
        } else {
            return "notfound";
        }
    }

    public function customerConfirm()
    {
        $id = $_POST['id'];

        if ($order = $this->orderModel->find($id)) {
            if ($this->orderModel->where('id', $id)->set('status', 'queued')->update()) {
                return "success";
            }
        } else {
            return "notfound";
        }
    }
}
