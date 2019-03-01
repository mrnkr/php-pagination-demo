<?php

require_once dirname(__FILE__) . '/../utils.php';

class Activity {

  public $table = "activity";
  public $partake = "partake";
  public $conn;

  public function getAll() {
    $res = array();

    $query = "select distinct name from ".$this->table;
    $stmt  = $this->conn->prepare($query);
    $stmt->execute();

    if ($stmt->rowCount() == 0) {
      return $res;
    }

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      extract($row);
      array_push($res, $name);
    }

    return $res;
  }

  public function forUser($user) {
    $res = array();

    $query = "(
		select distinct a.name,
		       true as partakes
		from activity as a
		left join partake as p
		on p.id_activity = a.id
		where p.id_associate = :user
	      ) union (
		select distinct name,
		       false as partakes
		from activity
		where id not in (
			select distinct a.name
			from activity as a
			left join partake as p
			on p.id_activity = a.id
			where p.id_associate = :user
		)
	       )";
    $stmt  = $this->conn->prepare($query);
    $stmt->bindParam(":user", $user);

    $stmt->execute();

    if ($stmt->rowCount() == 0) {
      return $res;
    }

    while ($row = $stmt->fetch($stmt->fetch(PDO::FETCH_ASSOC)) {
      extract($row);

      $res[$name] = $partakes;
    }

    return $res;
  }

}

?>
