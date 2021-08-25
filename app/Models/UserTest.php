<?php

namespace App\Models;

use PDO;
use PDOException;

class UserTest{
    // Database information
    public $dbh;
    public static $primaryKey = "id";
    public static $tableName = "users";

    // Database Columns
    public $id;
    public $name;
    public $email;
    public $date_created;
    public $date_updated;


    public function read(){
        $result = $this->dbh->prepare("SELECT * FROM `users`");
        $result->execute();
        $gotData = $result->fetchAll(PDO::FETCH_ASSOC);
        return $gotData;
    }

    public function create() {

        Utility::$dbh = $this->dbh;
        Utility::$tableName = self::$tableName;
        if (Utility::checkIfExists("name", $this->name) == 1) {
            $result = $this->dbh->prepare("INSERT INTO `users`
        (`name`,`email`,`date_created`)
        VALUES(:we,:wer,:wert)");
            $result->bindParam(':we', $this->name, PDO::PARAM_STR);
            $result->bindParam(':wer', $this->email, PDO::PARAM_STR);
            $result->bindParam(':wert', $this->date_created, PDO::PARAM_STR);

            try {
                $this->dbh->beginTransaction();
                $result->execute();
                $this->id = $this->dbh->lastInsertId();
                $this->dbh->commit();
                $this->response = 1;
            } catch (PDOException $e) {
                $this->dbh->rollback();
                $this->response = $e->getMessage();
            }
            return $this->response;
        } else {
            return 2; //record exists
        }
    }

    public function update() {
        $result = $this->dbh->prepare("UPDATE `users` SET `name` = :we,`email` = :wer,`date_updated` = :wert WHERE `id` = :werty");
        $result->bindParam(':we', $this->name, PDO::PARAM_STR);
        $result->bindParam(':wer', $this->email, PDO::PARAM_STR);
        $result->bindParam(':wert', $this->date_updated, PDO::PARAM_STR);
        $result->bindParam(':werty', $this->id, PDO::PARAM_INT);

        try {
            $this->dbh->beginTransaction();
            $result->execute();
            $this->dbh->commit();
            $this->response = 1;
        } catch (PDOException $e) {
            $this->dbh->rollback();
            $this->response = $e->getMessage();
        }
        return $this->response;
    }

    public function delete() {
        $result = $this->dbh->prepare("UPDATE `users` SET `publish` = 1 WHERE `id` = :we");
        $result->bindParam(':we', $this->id, PDO::PARAM_INT);
        try {
            $this->dbh->beginTransaction();
            $result->execute();
            $this->dbh->commit();
            $this->response = 1;
        } catch (PDOException $e) {
            $this->dbh->rollback();
            $this->response = $e->getMessage();
        }
        return $this->response;
    }

    public function getUserById(){
        $result = $this->dbh->prepare("SELECT * FROM `users` WHERE `id` = :we AND `publish` = 0");
        $result->bindParam(':we', $this->id, PDO::PARAM_INT);
        $result->execute();
        if($result->rowCount() === 0){
            return null;
        }
        $gotData = $result->fetch(PDO::FETCH_ASSOC);
        return $gotData;

    }

}