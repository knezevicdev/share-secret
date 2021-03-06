<?php

include_once __DIR__ . '/header.php';
include_once __DIR__ . '/Secret.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

use Ramsey\Uuid\Uuid;
use Defuse\Crypto\Crypto;

class DB {
    private $dbServer;
    private $dbUsername;
    private $dbPassword;
    private $dbName;
    private $pdo;

    function __construct() {
        $this->dbServer = $_ENV['DB_SERVER'];
        $this->dbUsername = $_ENV['DB_USERNAME'];
        $this->dbPassword = $_ENV['DB_PASSWORD'];
        $this->dbName = $_ENV['DB_NAME'];

        try {
            $this->pdo = new PDO("mysql:host={$this->dbServer};dbname=$this->dbName", $this->dbUsername, $this->dbPassword);

            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql ="CREATE TABLE IF NOT EXISTS secrets (
                        id BINARY(16) PRIMARY KEY,
                        content LONGTEXT,
                        passphrase VARCHAR(255),
                        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                   );" ;
            $this->pdo->exec($sql);
        } catch (PDOException $e) {
            end_with_message('Error while connecting to database.');
        }
    }

    function createSecret ($content, $password = "") {
        $sql = "INSERT INTO secrets (id, content, passphrase) VALUES (:id, :content, :passphrase)";

        if($stmt = $this->pdo->prepare($sql)) {
            $uuid = Uuid::uuid4();
            $param_uuid = $uuid->getBytes();
            $param_content = trim($content);
            $param_password = NULL;

            if (!empty($password)) {
                $param_content = Crypto::encryptWithPassword($param_content, $password);
                $param_password = password_hash($password, PASSWORD_BCRYPT);
            }

            $stmt->bindParam(":id", $param_uuid);
            $stmt->bindParam(":content", $param_content);
            $stmt->bindParam(":passphrase", $param_password);

            if ($stmt->execute()) {
                return $uuid->toString();
            } else {
                return false;
            }
        }

        unset($stmt);
    }

    function getSecret ($id) {
        $sql = "SELECT * FROM secrets WHERE id = :id";

        try {
            $uuid = Uuid::fromString($id);
            $param_id = $uuid->getBytes();

            if($stmt = $this->pdo->prepare($sql)) {
                $stmt->bindParam(":id", $param_id);

                if ($stmt->execute()) {
                    if ($data =  $stmt->fetch()) {
                        $data['id'] = Uuid::fromBytes($data['id'])->toString();
                        return new Secret($data);
                    }
                }
            }
        } catch (Exception $e) {
            // error
        }

        return false;
    }

    function deleteSecret ($id) {
        $sql = "DELETE FROM secrets WHERE id = :id";

        try {
            $uuid = Uuid::fromString($id);
            $param_id = $uuid->getBytes();

            if($stmt = $this->pdo->prepare($sql)) {
                $stmt->bindParam(":id", $param_id);

                if ($stmt->execute()) {
                    return true;
                }
            }
        } catch (Exception $e) {
            // error
        }

        return false;
    }
}
