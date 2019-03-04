<?php

require_once dirname(__FILE__) . '/../utils.php';
require_once dirname(__FILE__) . '/activity.php';

class Member {

  private $table = 'member';
  private $affiliate = 'affiliate';
  private $conn;
  private $activityModel;

  public function __construct($db) {
    $this->conn = $db;
    $this->activityModel = new Activity($db);
  }

  /**
   * Counts how many members there are
   * 
   * @return int number of members registered
   */
  public function count() {
    $query = 'select count(*) as cnt from ' . $this->table;
    $stmt  = $this->conn->prepare($query);
    $stmt->execute();

    if ($stmt->rowCount() == 0) {
      return 0;
    }

    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    extract($row);

    return $cnt;
  }

  /**
   * Gets the user associated to the passed id
   * 
   * @param int $id user id
   * @return array associative array with user data
   */
  public function find_one($id) {
    $query = 'select af.* from ' . $this->table . ' as m join ' . $this->affiliate . ' as af on m.id = af.id where m.id = :id';
    $stmt  = $this->conn->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
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
      'picture_url' => $picture_url
    );
  }

  /**
   * Gets a list of users allowing for basic pagination
   * given an offset and a limit
   * 
   * @param int $limit not the actual limit applied to the query. $limit - $offset gets applied
   * @param int $offset offset applied to the query
   * @return array associative arrays with user data
   */
  public function find($limit, $offset = 0) {
    $limit -= $offset;
    $ret = array();

    $query = 'select af.* from ' . $this->table . ' as m join ' . $this->affiliate . ' as af on m.id = af.id limit :limit offset :offset';
    $stmt  = $this->conn->prepare($query);

    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);

    $stmt->execute();

    if ($stmt->rowCount() == 0) {
      return $ret;
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
        'picture_url' => $picture_url
      );

      array_push($ret, $cur);
    }

    return $ret;
  }

  /**
   * Inserts a member in the database
   * 
   * @param array $member associative array with the data
   * @return int id which was assigned to the inserted member
   */
  public function insert_one($member) {
    extract($member);

    $query = 'insert into ' . $this->affiliate .
            ' set first_name = :first_name,
                  last_name = :last_name,
                  birthdate = :birthdate,
                  address = :address,
                  phone = :phone,
                  email = :email,
                  password = :password,
                  picture_url = :picture_url';
    $stmt  = $this->conn->prepare($query);

    $stmt->bindParam(':first_name', htmlspecialchars(strip_tags($first_name)));
    $stmt->bindParam(':last_name', htmlspecialchars(strip_tags($last_name)));
    $stmt->bindParam(':birthdate', htmlspecialchars(strip_tags($birthdate)));
    $stmt->bindParam(':address', htmlspecialchars(strip_tags($address)));
    $stmt->bindParam(':phone', htmlspecialchars(strip_tags($phone)));
    $stmt->bindParam(':email', htmlspecialchars(strip_tags($email)));
    $stmt->bindParam(':password', md5($password));
    $stmt->bindParam(':picture_url', htmlspecialchars(strip_tags($picture_url)));

    if ($stmt->execute()) {
      $id = $this->conn->lastInsertId();
      $query = 'insert into ' . $this->table . ' set id = :id';
      $stmt  = $this->conn->prepare($query);
      $stmt->bindParam(':id', $id, PDO::PARAM_INT);

      if ($stmt->execute()) {
        return $id;
      }
    }

    return -1;
  }

  /**
   * Updates the user associated to the passed id given
   * the passed diff associative array.
   * 
   * @param int $id member id
   * @param array $diff associative array with the values to change
   * @return bool true iif some member was actually updated
   */
  public function update_one($id, $diff) {
    $old = $this->find_one($id);

    $query = 'update ' . $this->affiliate .
            ' set first_name = :first_name,
                  last_name = :last_name,
                  birthdate = :birthdate,
                  address = :address,
                  phone = :phone,
                  email = :email
              where id = :id';
    $stmt  = $this->conn->prepare($query);

    $first_name = isset($diff['first_name']) ? htmlspecialchars(strip_tags($diff['first_name'])) : $old['first_name'];
    $last_name = isset($diff['last_name']) ? htmlspecialchars(strip_tags($diff['last_name'])) : $old['last_name'];
    $birthdate = isset($diff['birthdate']) ? htmlspecialchars(strip_tags($diff['birthdate'])) : $old['birthdate'];
    $address = isset($diff['address']) ? htmlspecialchars(strip_tags($diff['address'])) : $old['address'];
    $phone = isset($diff['phone']) ? htmlspecialchars(strip_tags($diff['phone'])) : $old['phone'];
    $email = isset($diff['email']) ? htmlspecialchars(strip_tags($diff['email'])) : $old['email'];

    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':first_name', $first_name);
    $stmt->bindParam(':last_name', $last_name);
    $stmt->bindParam(':birthdate', $birthdate);
    $stmt->bindParam(':address', $address);
    $stmt->bindParam(':phone', $phone);
    $stmt->bindParam(':email', $email);
    // $stmt->bindParam(':picture_url', isset($diff['picture_url']) ? htmlspecialchars(strip_tags($diff['picture_url'])) : $old['picture_url']);

    if ($stmt->execute()) {
      return $stmt->rowCount() > 0;
    }

    return false;
  }

  /**
   * Deletes the member associated to the passed id after removing
   * them from every activity they were previously registered to, if any.
   * 
   * @param int $id member id
   * @return bool true iif some member got actually deleted
   */
  public function delete_one($id) {
    $this->activityModel->remove_user_from_all_activities($id);

    $query = 'delete from ' . $this->table . ' where id = :id';
    $stmt  = $this->conn->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
      $query = 'delete from ' . $this->affiliate  . ' where id = :id';
      $stmt  = $this->conn->prepare($query);
      $stmt->bindParam(':id', $id, PDO::PARAM_INT);

      if ($stmt->execute()) {
        return true;
      }
    }

    return false;
  }

}

?>