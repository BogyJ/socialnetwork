<?php
    namespace App\Controllers;

    class UserController extends \App\Core\Role\UserRoleController {
        public function index() {
            $userModel = new \App\Models\UserModel($this->getDatabaseConnection());
            $userId = $_SESSION["userId"];
            $user = $userModel->getUserById($userId);

            if (!$_SESSION["login-recorded"]) {
                $userLoginModel = new \App\Models\UserLoginModel($this->getDatabaseConnection());
                $userLoginModel->addLogin($userId, $_SESSION["ip-address"]);
                $_SESSION["login-recorded"] = true;
            }

            $this->set('user', $user);
        }
    }
