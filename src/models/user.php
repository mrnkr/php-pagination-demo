<?php

require_once dirname(__FILE__) . '/../../utils.php';

class User {

  private $table = 'users';
  private $conn;

  public function __construct($db) {
    $this->conn = $db;
  }

  public function findOne($id) {
    $query = 'SELECT * FROM '. $this->table . ' WHERE id = :id';
    $stmt  = $this->conn->prepare($query);
    $stmt->bindParam(':id', $limit);
    $stmt->execute();

    if ($stmt->rowCount() == 0) {
      return array();
    }

    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    extract($row);

    return array(
      'id' => $id,
      'first_name' => $first_name,
      'last_name' => $last_name,
      'birthdate' => $birthdate,
      'address' => $address,
      'phone' => $phone,
      'email' => $email,
      'picture_url' => $picture_url,
      'scope' => $scope
    );
  }

  public function find($limit, $offset = 0) {
    $limit = $limit - $offset;

    $res = array(
      'count' => 0,
      'data' => array()
    );

    $query = 'SELECT * FROM ' . $this->table . ' LIMIT :limit OFFSET :offset';
    $stmt  = $this->conn->prepare($query);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();

    $res['count'] = $stmt->rowCount();
    
    if ($res['count'] == 0) {
      return $res;
    }

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      extract($row);
      
      $cur = array(
        'id' => $id,
        'first_name' => $first_name,
        'last_name' => $last_name,
        'birthdate' => $birthdate,
        'address' => $address,
        'phone' => $phone,
        'email' => $email,
        'picture_url' => $picture_url,
        'scope' => $scope
      );

      array_push($res['data'], $cur);
    }

    return $res;
  }

  public function insertOne($user) {
    $query = 'INSERT INTO ' . $this->table . '
              SET first_name = :first_name,
                  last_name = :last_name,
                  birthdate = :birthdate,
                  address = :address,
                  phone = :phone,
                  email = :email,
                  picture_url = :picture_url,
                  password = :password,
                  scope = :scope';

    $stmt = $this->conn->prepare($query);

    $stmt->bindParam(':first_name', htmlspecialchars(strip_tags($user['first_name'])));
    $stmt->bindParam(':last_name', htmlspecialchars(strip_tags($user['last_name'])));
    $stmt->bindParam(':birthdate', htmlspecialchars(strip_tags($user['birthdate'])));
    $stmt->bindParam(':address', htmlspecialchars(strip_tags($user['address'])));
    $stmt->bindParam(':phone', htmlspecialchars(strip_tags($user['phone'])));
    $stmt->bindParam(':email', htmlspecialchars(strip_tags($user['email'])));
    $stmt->bindParam(':picture_url', htmlspecialchars(strip_tags($user['picture_url'])));
    $stmt->bindParam(':password', md5($user['password']));
    $stmt->bindParam(':scope', htmlspecialchars(strip_tags($user['scope'])));

    if ($stmt->execute()) {
      return $this->conn->lastInsertId();
    }

    return -1;
  }

  public function updateOne($id, $diff) {
    $old = $this->findOne($id);

    $query = 'UPDATE \`' . $this->table . '\`
              SET first_name = :first_name,
                  last_name = :last_name,
                  birthdate = :birthdate,
                  address = :address,
                  phone = :phone,
                  email = :email,
                  picture_url = :picture_url,
                  password = :password,
                  scope = :scope
              WHERE id = :id';

    $stmt = $this->conn->prepare($query);

    $stmt->bindParam(':first_name', isset($diff['first_name']) ? htmlspecialchars(strip_tags($diff['first_name'])) : $old['first_name']);
    $stmt->bindParam(':last_name', isset($diff['last_name']) ? htmlspecialchars(strip_tags($diff['last_name'])) : $old['last_name']);
    $stmt->bindParam(':birthdate', isset($diff['birthdate']) ? htmlspecialchars(strip_tags($diff['birthdate'])) : $old['birthdate']);
    $stmt->bindParam(':address', isset($diff['address']) ? htmlspecialchars(strip_tags($diff['address'])) : $old['address']);
    $stmt->bindParam(':phone', isset($diff['phone']) ? htmlspecialchars(strip_tags($diff['phone'])) : $old['phone']);
    $stmt->bindParam(':email', isset($diff['email']) ? htmlspecialchars(strip_tags($diff['email'])) : $old['email']);
    $stmt->bindParam(':picture_url', isset($diff['picture_url']) ? htmlspecialchars(strip_tags($diff['picture_url'])) : $old['picture_url']);
    $stmt->bindParam(':password', isset($diff['password']) ? md5($diff['password']) : $old['password']);
    $stmt->bindParam(':scope', isset($diff['scope']) ? htmlspecialchars(strip_tags($diff['scope'])) : $old['scope']);

    if ($stmt->execute()) {
      return true;
    }

    printf("Error: %s.\n", $stmt->error);

    return false;
  }

  public function deleteOne($id) {
    $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';
    $stmt  = $this->conn->prepare($query);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
      return true;
    }

    printf("Error: %s.\n", $stmt->error);

    return false;
  }

}

?>