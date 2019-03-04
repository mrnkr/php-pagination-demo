<?php

require_once dirname(__FILE__) . '/../utils.php';

class Activity {

  public $table = 'activity';
  public $affiliate = 'affiliate';
  public $partake = 'partake';
  public $conn;

  public function __construct($db) {
    $this->conn = $db;
  }

  /**
   * Gets all activities from database
   * 
   * @return array list of available activities
   */
  public function get_all() {
    $res = array();

    $query = 'select distinct name, id, picture_url from ' . $this->table;
    $stmt  = $this->conn->prepare($query);
    $stmt->execute();

    if ($stmt->rowCount() == 0) {
      return $res;
    }

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      extract($row);

      $cur = array(
        'id' => $id,
        'name' => $name,
        'picture_url' => $picture_url
      );

      array_push($res, $cur);
    }

    return $res;
  }

  /**
   * Returns a list of users which partake in the passed activity
   * 
   * @param int $activity activity id
   * @return array list of users participating in the passed activity
   */
  public function get_users_for_activity($activity) {
    $res = array();

    $query = 'select af.* from ' . $this->partake  . ' as p join ' . $this->affiliate  . ' as af on p.member_id = af.id where p.activity_id = :id';
    $stmt  = $this->conn->prepare($query);

    $stmt->bindParam(':id', $activity, PDO::PARAM_INT);

    $stmt->execute();

    if ($stmt->rowCount() == 0) {
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
        'picture_url' => $picture_url
      );

      array_push($res, $cur);
    }

    return $res;
  }

  /**
   * Returns an associative array that looks like:
   *  array('futbol' => true, 'bochas' => false)
   *  when a user plays football and does not play bochas :)
   * 
   * @param int $user user id
   * @return array activities and whether the user participates in them
   */
  public function for_user($user) {
    $res = array();

    $query = '(
      select distinct a.name,
             true as partakes
      from ' . $this->table  . ' as a
      left join ' . $this->partake . ' as p
      on p.activity_id = a.id
      where p.member_id = :user
    ) union (
      select distinct name,
              false as partakes
      from ' . $this->table . '
      where id not in (
        select distinct a.id
        from ' . $this->table  . ' as a
        left join ' . $this->partake  . ' as p
        on p.activity_id = a.id
        where p.member_id = :user
      )
    )';

    $stmt  = $this->conn->prepare($query);
    $stmt->bindParam(':user', $user, PDO::PARAM_INT);

    $stmt->execute();

    if ($stmt->rowCount() == 0) {
      return $res;
    }

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      extract($row);

      $res[$name] = $partakes;
    }

    return $res;
  }

  /**
   * If a user is participating in an activity, this removes them from it.
   * If a user is NOT participating in an actigity, this signs them up.
   * 
   * @param int $activity activity id
   * @param int $user user id
   * @return bool true iif the user is now participating in the activity
   */
  public function toggle_activity_for_user($activity, $user) {
    $is_partaking = $this->is_user_partaking($activity, $user);
    $query = $is_partaking ?
              'delete from ' . $this->partake . ' where activity_id = :activity_id and member_id = :member_id' :
              'insert into ' . $this->partake . ' (activity_id, member_id) values (:activity_id, :member_id)';

    $stmt  = $this->conn->prepare($query);
    $stmt->bindParam(':activity_id', $activity, PDO::PARAM_INT);
    $stmt->bindParam(':member_id', $user, PDO::PARAM_INT);

    if ($stmt->execute()) {
      return !$is_partaking;
    }

    throw new Exception('Something went wrong toggling activity :(');
  }

  /**
   * Removes the passed user from all activities
   * 
   * @param int $user user id
   */
  public function remove_user_from_all_activities($user) {
    $query = 'delete from ' . $this->partake . ' where member_id = :member_id';
    $stmt  = $this->conn->prepare($query);
    $stmt->bindParam(':member_id', $user, PDO::PARAM_INT);
    return $stmt->execute();
  }

  /**
   * Checks if a user is participating in a given activity
   * 
   * @param int $activity activity id
   * @param int $user user id
   * @return bool true iif user is participating
   */
  private function is_user_partaking($activity, $user) {
    $query = 'select if((select count(*) from ' . $this->partake  . ' where member_id = :user and activity_id = :activity) > 0, true, false) as partaking';
    $stmt  = $this->conn->prepare($query);

    $stmt->bindParam(':activity', $activity, PDO::PARAM_INT);
    $stmt->bindParam(':user', $user, PDO::PARAM_INT);

    $stmt->execute();

    if ($stmt->rowCount() == 0) {
      throw new Exception('Something went terribly wrong!!');
    }

    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    extract($row);

    return $partaking;
  }

}

?>