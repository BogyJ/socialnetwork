<?php
    namespace App\Models;

    class UserModel {
        private $dbc;

        public function __construct(\App\Core\DatabaseConnection $dbc) {
            $this->dbc = $dbc;
        }

        public function getAllUsers(): array {
            $sql = 'SELECT * FROM `survey`.`user`;';
            $prep = $this->dbc->getConnection()->prepare($sql);
            $result = $prep->execute();
            $users = [];

            if ($result) {
                $users = $prep->fetchAll(\PDO::FETCH_OBJ);
            }

            return $users;
        }

        public function getUserById(int $userId) {
            $sql = 'SELECT * FROM `survey`.`user` WHERE `user`.`user_id` = ?;';
            $prep = $this->dbc->getConnection()->prepare($sql);
            $result = $prep->execute([ $userId ]);
            $user = NULL;

            if ($result) {
                $user = $prep->fetch(\PDO::FETCH_OBJ);
            }

            return $user;
        }

        public function getByUsername(string $username) {
            $sql = 'SELECT * FROM `survey`.`user` WHERE `user`.`username` = ?;';
            $prep = $this->dbc->getConnection()->prepare($sql);
            $result = $prep->execute([ $username ]);
            $user = NULL;

            if ($result) {
                $user = $prep->fetch(\PDO::FETCH_OBJ);
            }

            return $user;
        }

        public function addUser(array $fieldsValues) {
            $sql = "INSERT INTO `survey`.`user`(forename, surname, username, password_hash, email) VALUES(?, ?, ?, ?, ?)";
            $prep = $this->dbc->getConnection()->prepare($sql);
            $result = false;
            try {
                $result = $prep->execute([ $fieldsValues["forename"], $fieldsValues["surname"], $fieldsValues["username"], $fieldsValues["password_hash"], $fieldsValues["email"] ]);
            } catch (\PDOException $error) {
                if ($error->errorInfo[1] == 1062) { # 1062 kod greške koji označava da ta vrednost već postoji u bazi podataka (duplicate entry)
                    throw new \Exception("Account with that username or email already exist.");
                }
            }

            if (!$result) {
                return false;
            }

            return $this->dbc->getConnection()->lastInsertId();
        }
    }
