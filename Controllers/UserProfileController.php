<?php
    namespace App\Controllers;

    class UserProfileController extends \App\Core\Role\UserRoleController {
        public function index() {
            $userId = $_SESSION["userId"];

            $userModel = new \App\Models\UserModel($this->getDatabaseConnection());
            $user = $userModel->getUserById($userId);
            $users = $userModel->getAllUsers();

            $friendsModel = new \App\Models\FriendsModel($this->getDatabaseConnection());
            $friends = $friendsModel->getFriendsByUserId($userId);
            $friendsIds = [];

            for ($i = 0; $i < count($friends); $i++) {
                $friendsIds[] = $friends[$i]->friend_id;
            }

            $filteredUsers = [];
            for ($i = 0; $i < count($users); $i++) {
                if (!in_array($users[$i]->user_id, $friendsIds) && $users[$i]->user_id != $user->user_id) {
                    $filteredUsers[] = $users[$i];
                }
            }

            $this->set('user', $user);
            $this->set('users', $filteredUsers);
        }

        public function getSendRequest($toUserId) {
            $friendRequestModel = new \App\Models\FriendRequestModel($this->getDatabaseConnection());
            $friendRequestId = $friendRequestModel->insertNewFriendRequest($toUserId, $_SESSION['userId']);

            $message = 'Friend request sent.';
            if ($friendRequestId == false) {
                $message = 'An unexpected error occured.';
            }

            $this->set('message', $message);
        }

        public function getNotification() {
            $userId = $_SESSION['userId'];
            $friendRequestModel = new \App\Models\FriendRequestModel($this->getDatabaseConnection());
            $friendRequests = $friendRequestModel->getAllFriendRequests($userId);

            $users = [];
            if (count($friendRequests) > 0) {
                $userModel = new \App\Models\UserModel($this->getDatabaseConnection());
                foreach ($friendRequests as $friendRequest) {
                    $user = $userModel->getUserById($friendRequest->request_from);
                    $users[] = $user;
                }
            }

            $this->set('users', $users);
        }

        public function getAcceptFriendRequest($id) {
            $userId = $_SESSION['userId'];
            $friendsModel = new \App\Models\FriendsModel($this->getDatabaseConnection());
            $friendsModel->insertNewFriendship($userId, $id);

            $friendRequestModel = new \App\Models\FriendRequestModel($this->getDatabaseConnection());
            $friendRequestModel->setStatus($userId, $id, 'ACCEPTED');

            $friendsModel->insertNewFriendship($id, $userId);

            $userModel = new \App\Models\UserModel($this->getDatabaseConnection());
            $user = $userModel->getUserById($id);

            $this->set('user', $user);
        }

    }
