<?php
    namespace App\Models;

    class FriendRequestModel {
        private $dbc;

        public function __construct(\App\Core\DatabaseConnection $dbc) {
            $this->dbc = $dbc;
        }

        public function insertNewFriendRequest($toUserId, $fromUserId) {
            $sql = 'INSERT INTO `social_network`.`friend_request` (`request_to`,`request_from`) VALUES (?,?);';
            $prep = $this->dbc->getConnection()->prepare($sql);
            $result = $prep->execute([ $toUserId, $fromUserId ]);

            if (!$result) {
                return false;
            }

            return $this->dbc->getConnection()->lastInsertId();
        }

        public function getAllFriendRequests($userId) {
            $sql = 'SELECT * FROM `social_network`.`friend_request` WHERE `request_to` = ? AND `status` = "PENDING"';
            $prep = $this->dbc->getConnection()->prepare($sql);
            $result = $prep->execute([ $userId ]);
            $friendRequests = [];

            if ($result) {
                $friendRequests = $prep->fetchAll(\PDO::FETCH_OBJ);
            }

            return $friendRequests;
        }

        public function setStatus($toUserId, $fromUserId, $status) {
            $sql = 'UPDATE `social_network`.`friend_request` SET status = ? WHERE `request_from` = ? AND `request_to` = ?';
            $prep = $this->dbc->getConnection()->prepare($sql);
            $result = $prep->execute([ $status, $fromUserId, $toUserId ]);

            if (!$result) {
                return false;
            }

            return true;
        }

    }
