<?php
    namespace App\Controllers;

    class MainController extends \App\Core\Controller {
        public function home() {
            if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"]) {
                header('Location: ' . \Configuration::BASE . '/user/profile/');
            }
        }

        public function getRegister() { }

        public function postRegister() {
            $userModel = new \App\Models\UserModel($this->getDatabaseConnection());

            $forename = filter_input(INPUT_POST, 'forename', FILTER_SANITIZE_STRING);
            $surname = filter_input(INPUT_POST, 'surname', FILTER_SANITIZE_STRING);
            $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
            $password1 = filter_input(INPUT_POST, 'password1', FILTER_SANITIZE_STRING);
            $password2 = filter_input(INPUT_POST, 'password2', FILTER_SANITIZE_STRING);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

            if ($password1 !== $password2) {
                $this->set('message', 'Error: password does not match.');
                return;
            }

            $password_hash = password_hash($password1, PASSWORD_DEFAULT);
            $fields = [
                "forename" => $forename,
                "surname" => $surname,
                "username" => $username,
                "password_hash" => $password_hash,
                "email" => $email
            ];

            $userId = null;
            try {
                $userId = $userModel->addUser($fields);
            } catch (\Exception $e) {
                $this->set('message', $e->getMessage());
            }

            if ($userId) {
                $this->set('message', 'Account successfully created. Please, log in!');
            }
        }

        public function getLogin() {
            if ($_SESSION["loggedIn"]) {
                header('Location: ' . \Configuration::BASE);
            }

            if (isset($_COOKIE["username"]) && isset($_COOKIE["password"])) {
                $username = $_COOKIE["username"];
                $password = $_COOKIE["password"];

                $this->set('credentials', [0 => $username, 1 => $password]);
            }
        }

        public function postLogin() {
            $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
            $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);


            $userModel = new \App\Models\UserModel($this->getDatabaseConnection());
            $user = $userModel->getByUsername($username);

            if (!$user) {
                $this->set('message', 'Error: account with that username does not exist.');
                return;
            }

            if (!password_verify($password, $user->password_hash)) {
                sleep(1); // prevent brute force attack, needs improvement
                $this->set('message', 'Error: check credentials again.');
                return;
            }

            if (isset($_POST["remember"])) {
                # sačuvaj korisnikove kredencijale na nedelju dana
                setcookie("username", $username, time() + 86400 * 7);
                setcookie("password", $password, time() + 86400 * 7);
            }

            $_SESSION["loggedIn"] = true;
            $_SESSION["userId"] = $user->user_id;
            header('Location: ' . \Configuration::BASE . '/user/profile/');
        }

        public function getLogout() {
            session_destroy();
            header('Location: ' . \Configuration::BASE);
        }

    }
