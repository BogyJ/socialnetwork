<?php
    namespace App\Controllers;

    class UserProfileController extends \App\Core\Role\UserRoleController {
        public function index() {
            $userId = $_SESSION["userId"];

            $userModel = new \App\Models\UserModel($this->getDatabaseConnection());
            $user = $userModel->getUserById($userId);
            $users = $userModel->getAllUsers();

            $friendModel = new \App\Models\FriendsModel($this->getDatabaseConnection());
            $friends = $friendModel->getFriendsByUserId($userId);
            var_dump(count($friends));

            for ($i = 0; $i < count($users); $i++) {
                if ($users[$i]->user_id == $userId) {
                    unset($users[$i]);
                }

            }

            $this->set('user', $user);
            $this->set('users', $users);
        }
    }
