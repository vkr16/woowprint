<?php

namespace App\Controllers;

use App\Controllers\BaseController;

use CodeIgniter\API\ResponseTrait;

class Api extends BaseController
{
    use ResponseTrait;
    protected $adminModel;

    function __construct()
    {
        $this->adminModel = model('AdminModel', true, $db);
    }

    public function addAdmin()
    {
        $name = $_POST['name'];
        $username = $_POST['username'];
        $password = trim($_POST['password']);
        $api_password = trim($_POST['api_password']);

        if (password_verify($api_password, getenv('API_PASSWORD'))) {
            if ($username == '' || $password == '') {
                return $this->respond("Field cannot be empty!", 400);
            } else {
                if ($this->adminModel->where('username', $username)->find()) {
                    return $this->failResourceExists("username already exist");
                } else {
                    $adminData = [
                        "name" => $name,
                        "username" => $username,
                        "password" => password_hash($password, PASSWORD_DEFAULT)
                    ];

                    if ($this->adminModel->insert($adminData)) {
                        return $this->respondCreated("New Admin Registered");
                    }
                }
            }
        } else {
            return $this->failUnauthorized("Wrong API Password");
        }
    }
}
