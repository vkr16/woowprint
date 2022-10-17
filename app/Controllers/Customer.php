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

                    $data['uploaded'] = $builder->select('*')->where('order_id =', $data['order'][0]['id'])->countAllResults();
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
                $validationRule = [
                    'photo' => [
                        'label' => 'Image File',
                        'rules' => 'uploaded[photo]'
                            . '|is_image[photo]'
                            . '|mime_in[photo,image/jpg,image/JPG,image/jpeg,image/JPEG,image/png,image/PNG,image/webp,image/WEBP]'
                    ],
                ];
                if (!$this->validate($validationRule)) {
                    $this->session->setFlashdata('error', 'File gambar tidak valid');
                    return redirect()->to(base_url('order') . "?i=" . $token);
                }

                $img = $this->request->getFile('photo');
                var_dump($img);

                // if (!$img->hasMoved()) {
                //     $filepath = WRITEPATH . 'uploads/' . $img->store();

                //     $data = ['uploaded_flleinfo' => new File($filepath)];

                //     return view('upload_success', $data);
                // }
                // $data = ['errors' => 'The file has already been moved.'];

                // return view('upload_form', $data);
            } else {
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
            }
        }
    }
}
