<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Auth extends BaseController
{

    protected $session;
    protected $adminModel;

    function __construct()
    {
        $this->session = \Config\Services::session();
        $this->adminModel = model('AdminModel', true, $db);
    }

    public function index()
    {
        //
    }

    public function login()
    {
        if ($this->session->has('oms_cetakfoto_user_session')) {
            return redirect()->to(base_url('admin'));
        }

        return view('auth/login');
    }

    public function auth()
    {
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        $saveuser = $_POST['saveuser'];

        if ($username == '' || $password == '') {
            return "empty";
        } else {
            if ($admin = $this->adminModel->where('username', $username)->find()) {
                if (password_verify($password, $admin[0]['password'])) {
                    if ($saveuser == "true") {
                        setcookie('oms_cetakfoto_last_user', $username, time() + 60 * 60 * 24 * 30);
                    } else {
                        setcookie('oms_cetakfoto_last_user', '', time() + 60 * 60 * 24 * 30);
                    }
                    $sessionData = [
                        'oms_cetakfoto_user_session' => $admin[0]['id']
                    ];
                    $this->session->set($sessionData);
                    return "success";
                } else {
                    // Password Incorrect
                    return "incorrect";
                }
            } else {
                return "notfound";
            }
        }
    }

    public function logout()
    {
        $this->session->destroy();
        return redirect()->to(base_url());
    }
}
