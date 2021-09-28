<?php
    namespace App\Controllers;

    class UserProfileController extends \App\Core\Role\UserRoleController {
        public function index() {
            $userModel = new \App\Models\UserModel($this->getDatabaseConnection());
            $userId = $_SESSION["userId"];
            $user = $userModel->getUserById($userId);

            $this->set('user', $user);
        }
    }
