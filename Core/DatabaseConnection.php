<?php
    namespace App\Core;

    class DatabaseConnection {
        private $configuration;
        private $connection;

        public function __construct(DatabaseConfiguration $configuration) {
            $this->configuration = $configuration;
        }

        public function getConnection(): \PDO {
            if ($this->connection === NULL) {
                $this->connection = new \PDO($this->configuration->getSource(), $this->configuration->getUser(), $this->configuration->getPassword());
            }

            return $this->connection;
        }
    }
