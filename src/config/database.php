<?php

require_once dirname(__FILE__) . '/../../configuracion.php';
require_once dirname(__FILE__) . '/../utils.php';

class Database {

  private $conn;

  /**
   * Connects to a mysql database using credentials provided in configuracion.php
   * 
   * @return PDO The connection to the database
   */
  public function connect() {
    global $host, $db_name, $username, $password;
    $this->conn = null;

    try {
      $this->conn = new PDO('mysql:host=' . $host . ';dbname=' . $db_name, $username, $password);
      $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
      console_error('Connection error: ' . $e->getMessage());
    }

    return $this->conn;
  }

}

?>