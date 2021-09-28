<?php
    namespace App\Core;

    class DatabaseConfiguration {
        private $host;
        private $user;
        private $password;
        private $dbname;

        public function __construct(string $host, string $user, string $password, string $dbname) {
            $this->host = $host;
            $this->user = $user;
            $this->password = $password;
            $this->dbname = $dbname;
        }

        public function getSource(): string {
            return "mysql:{$this->host};dbname={$this->dbname};charset=utf8";
        }

        public function getUser(): string {
            return $this->user;
        }

        public function getPassword(): string {
            return $this->password;
        }
    }
