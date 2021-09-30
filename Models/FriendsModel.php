<?php
    namespace App\Models;

    class FriendsModel {
        private $dbc;

        public function __construct(\App\Core\DatabaseConnection $dbc) {
            $this->dbc = $dbc;
        }

        public function getFriendsByUserId($userId) {
            $sql = 'SELECT * FROM `social_network`.`friends` WHERE `friends`.`user_id` = ?';
            $prep = $this->dbc->getConnection()->prepare($sql);
            $result = $prep->execute([ $userId ]);
            $rels = [];

            if ($result) {
                $rels = $prep->fetchAll(\PDO::FETCH_OBJ);
            }

            return $rels;
        }

        public function insertNewFriendship($userId, $friendId) {
            $sql = 'INSERT INTO `social_network`.`friends` (`user_id`,`friend_id`) VALUES (?,?);';
            $prep = $this->dbc->getConnection()->prepare($sql);
            $result = $prep->execute([ $userId, $friendId ]);

            if (!$result) {
                return false;
            }

            return $this->dbc->getConnection()->lastInsertId();
        }

    }
